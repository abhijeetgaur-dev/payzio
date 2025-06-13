<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;

class AdminVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Vendor::all();
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
        $validator = Validator::make($request->all(), [
            'vendor_name' => 'required|string|max:255',
            'vendor_type' => 'nullable|string|max:100',
            'business_category' => 'nullable|string|max:255',
            'business_description' => 'nullable|string',

            'contact_person' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:vendors,email',
            'phone' => 'required|string|max:20',
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

            'pan_card_file' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'gst_certificate_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'registration_doc_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'cancelled_cheque_file' => 'required|file|mimes:pdf,jpg,png|max:2048',
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

        // Handle file uploads
        if ($request->hasFile('pan_card_file')) {
            $data['pan_card_file'] = $request->file('pan_card_file')->store('uploads/vendors/pan_cards');
        }
        if ($request->hasFile('gst_certificate_file')) {
            $data['gst_certificate_file'] = $request->file('gst_certificate_file')->store('uploads/vendors/gst_certificates');
        }
        if ($request->hasFile('registration_doc_file')) {
            $data['registration_doc_file'] = $request->file('registration_doc_file')->store('uploads/vendors/registration_docs');
        }
        if ($request->hasFile('cancelled_cheque_file')) {
            $data['cancelled_cheque_file'] = $request->file('cancelled_cheque_file')->store('uploads/vendors/cancelled_cheques');
        }

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
        // Logic to update vendor details
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
