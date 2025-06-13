<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


class AdminVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $vendors = Vendor::paginate(10); // 10 items per page
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
