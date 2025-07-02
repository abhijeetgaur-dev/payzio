<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\VendorCommission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\VendorStatusUpdated;


class AdminVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $query = Vendor::query();
    
    // Search functionality
    if ($request->filled('search')) {
        $searchTerm = $request->get('search');
        $query->where(function($q) use ($searchTerm) {
            $q->where('vendor_name', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%');
        });
    }
    
    // Date filtering
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->get('date_from'));
    }
    
    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->get('date_to'));
    }
    
    // Status filtering
    if ($request->filled('status') && $request->get('status') !== '') {
        $query->where('status', $request->get('status'));
    }
    
    // Sorting functionality
    $sortField = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');
    
    // Validate sort field to prevent SQL injection
    $allowedSortFields = ['vendor_name', 'email', 'phone', 'created_at', 'status'];
    if (!in_array($sortField, $allowedSortFields)) {
        $sortField = 'created_at';
    }
    
    // Validate sort direction
    $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? $sortDirection : 'desc';
    
    $query->orderBy($sortField, $sortDirection);
    
    // Paginate results and append query parameters
    $vendors = $query->paginate(10)->appends($request->query());
    
    return view('admin.vendors.index', compact('vendors'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
        'vendor_name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:vendors,email',
        'phone' => 'required|string|max:20',
        'vendor_type' => 'nullable|in:individual,company,partner',
        'pan_card_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'cancelled_cheque_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if($validator ->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
        'vendor_name',
        'email',
        'phone',
        'vendor_type'
        ]);

        $data['pan_card_file'] = $request->file('pan_card_file')->store('vendor_documents', 'public');
        $data['cancelled_cheque_file'] = $request->file('cancelled_cheque_file')->store('vendor_documents', 'public');

        Vendor::create($data);

        return redirect()->route('admin.vendors')->with('success', 'Vendor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function view($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'vendor_name' => 'required|string|max:255',
            'vendor_type' => 'nullable|string|max:100',
            'business_category' => 'nullable|string|max:255',
            'business_description' => 'nullable|string',

            'contact_person' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',

            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',

            'pan_number' => 'required|string|max:20',
            'gst_number' => 'nullable|string|max:30',

            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:30',
            'account_holder' => 'required|string|max:100',
            'ifsc_code' => 'required|string|max:20',
            'branch_name' => 'nullable|string|max:100',

            'pan_card_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'gst_certificate_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'registration_doc_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'cancelled_cheque_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except([
            'pan_card_file',
            'gst_certificate_file',
            'registration_doc_file',
            'cancelled_cheque_file'
        ]);

        // Handle file uploads - only update if new file is provided
        $fileFields = [
            'pan_card_file',
            'gst_certificate_file', 
            'registration_doc_file',
            'cancelled_cheque_file'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if it exists
                if ($vendor->$field) {
                    Storage::disk('public')->delete($vendor->$field);
                }
                // Store new file
                $data[$field] = $request->file($field)->store('vendor_documents', 'public');
            }
        }

        $vendor->update($data);

        return redirect()->route('admin.vendor.view', $vendor->id)
            ->with('success', 'Vendor updated successfully!');
    }

    // public function updateCommissionStatus(Request $request, $id ){
    //         $request->validate([
    //             'vendor_id' => 'required|exists:vendors,id',
    //             'commission' => 'required|numeric|min:0',
    //             'status' => 'required|in:0,1,2',
    //             'updated_by' => 'required|exists:admins,id',
    //             'status_reason' => 'nullable|string|max:255'
    //     ]);

    //         $data = $request->only([
    //             'vendor_id',
    //             'commission',
    //             'status',
    //             'updated_by',
    //             'status_reason'
    //         ]);

    //          // Fetch latest active commission for this vendor
    //         $lastCommission = VendorCommission::where('vendor_id', $data['vendor_id'])
    //             ->orderByDesc('created_at')
    //             ->first();

    //         if ($lastCommission && $lastCommission->status === '1') {
    //             if ($data['status'] === '2') {
    //                 return response()->json([
    //                     'message' => 'Invalid status change: Active commission cannot be suspended.'
    //                 ], 422);
    //             }

    //         // If deactivating, set end_date
    //             if ($data['status'] === '0') {
    //                 $data['end_date'] = Carbon::now();
    //             }
    //         }

    //         if ($data['status'] === '1') {
    //             $data['active_date'] = Carbon::now();
    //         }

    //         $commission = VendorCommission::create($data);

    //         return response()->json([
    //             'message' => 'Vendor commission status updated successfully.',
    //             'data' => $commission
    //         ], 201);
    //     }

public function vendorUpdateStatus(Request $request, $id)
        {
        try{
            $request->validate([
                    'status' => 'required|in:0,1,2',
                    'status_reason' => 'nullable|string|max:255'
                ]);

                $vendor = Vendor::findOrFail($id); // This was missing

                $admin = auth('admin')->user();

                if($vendor->status == '1' || $vendor->status == '0'){
                    if ($request->status == '2') {
                         return redirect()->back()->with('error', 'Invalid status change: Vendor cannot be suspended from active or inactive status.');
                    }
                }
                // Assign new values
                $vendor->status = $request->status;
                $vendor->status_reason = $request?->status_reason;
                $vendor->updated_by = $admin->id;

                $vendor->save();

            if ($this->sendVendorUpdateStatus($vendor)) {
                Log::info('Mail sent to vendor successfully');
                return redirect()->back()->with('success', 'Status updated successfully and mail sent to vendor');
            } else {
                Log::error('Mail not sent to vendor');
                return redirect()->back()->with('error', 'Status updated but email not sent');
                }
            } catch (\Exception $e) {
                Log::error('Vendor Status Update Error: ' . $e->getMessage());
                return back()->with('error', 'Error updating vendor status');
            }
        }

protected function sendVendorUpdateStatus(Vendor $vendor)
    {
        try {
            
            $admin= auth('admin')->user();

            
            $data = [
                'vendor_name' => $vendor->vendor_name,
                'status' => $vendor->status,
                'status_reason' => $vendor->status_reason,
                'admin_name' => $admin->name,
                // 'link' => route('cold-mails.edit', $assignment->id),
            ];

            // $recipients = [
            //     $vendor->email,
            //     'coordinator@company.com',
            //     'ceo@company.com'
            // ];

            Mail::to($vendor->email)
                // ->cc(array_slice($recipients, 1))
                ->send(new VendorStatusUpdated($data));

            return true;
        } catch (\Exception $e) {
            Log::error('Vendor status update email error: ' . $e->getMessage());
            return false;
        }
    }

   public function updateCommission(Request $request, $vendorId)
    {
        $validated = $request->validate([
            // 'status' => 'required|string',
            'commission' => 'required|numeric|min:0|max:100',
            'note' => 'nullable|string|max:255',
        ]);

        $vendor = Vendor::findOrFail($vendorId);

        // Deactivate current active commission
        $activeCommission = VendorCommission::where('vendor_id', $vendorId)
            // ->where('status', '1') // assuming '1' is active
            ->latest('active_date')
            ->first();

        if ($activeCommission) {
            $activeCommission->update([
                'status' => '0', // deactivated
                'end_date' => now(),
            ]);
        }

        // Create new commission entry
        VendorCommission::create([
            'vendor_id' => $vendorId,
            'commission' => $validated['commission'] ?? 0,
            // 'status' => $validated['status'],
            'updated_by' => auth('admin')->id(),
            'active_date' => now(),
            'note' => $validated['note'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Commission updated successfully.');
    }

    public function showVendorCommission($vendorId){

            $vendor = Vendor::findOrFail($vendorId);
            return view('admin.vendors.set_commission', compact('vendor'));
    }

        

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return response()->json(['success' => 'Vendor deleted successfully.']);
    }
}
