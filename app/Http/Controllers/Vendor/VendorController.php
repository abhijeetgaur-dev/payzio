<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Mail\VendorSignup;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class VendorController extends Controller
{
    public function index()
    {

    }

    public function storeOld(Request $request)
    {
        try{
        $validator = Validator::make($request->all(), [
            'vendor_name' => 'required|string|max:255',
            'vendor_type' => 'nullable|string|max:100',
            'business_category' => 'nullable|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:vendors,email',
            'phone' => 'required|string|max:20',
            'pan_number' => 'required|string|max:20',
            'pan_card_file' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'password' => 'nullable|string|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except([
            'pan_card_file',
        ]);
        

        // Handle file uploads
        if ($request->hasFile('pan_card_file')) {
            $data['pan_card_file'] = $request->file('pan_card_file')->store('vendor_documents', 'public');
        }

        $plainPassword = $data['password'];
        $data['password'] = bcrypt($plainPassword);


        $vendor = Vendor::create($data);

            if ($this->sendVendorSignUpMail($vendor, $plainPassword)) {
                Log::info('Mail sent to vendor successfully');
                return redirect()->back()->with('success', 'You have Registered Successfully. A mail has been sent to your registered email address.');
            } else {
                Log::error('Mail not sent to vendor');
                return redirect()->back()->with('error', 'You have Registered Successfully. However, there was an error sending the confirmation email. Please contact support.');
            }
        } catch (\Exception $e) {
            Log::error('Vendor Registration Error: ' . $e->getMessage());
            return back()->with('error', 'Error registering vendor');
        }
    }


    public function store(Request $request)
    {
        try{
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
            $data['pan_card_file'] = $request->file('pan_card_file')->store('vendor_documents', 'public');
        }

        if ($request->hasFile('gst_certificate_file')) {
            $data['gst_certificate_file'] = $request->file('gst_certificate_file')->store('vendor_documents', 'public');
        }

        if ($request->hasFile('registration_doc_file')) {
            $data['registration_doc_file'] = $request->file('registration_doc_file')->store('vendor_documents', 'public');
        }

        if ($request->hasFile('cancelled_cheque_file')) {
            $data['cancelled_cheque_file'] = $request->file('cancelled_cheque_file')->store('vendor_documents', 'public');
        }



        $plainPassword = Str::random(8); // Generate a random password
        $data['password'] = bcrypt($plainPassword);


        $vendor = Vendor::create($data);

            if ($this->sendVendorSignUpMail($vendor, $plainPassword)) {
                Log::info('Mail sent to vendor successfully');
                return redirect()->back()->with('success', 'You have Registered Successfully. A mail has been sent to your registered email address.');
            } else {
                Log::error('Mail not sent to vendor');
                return redirect()->back()->with('error', 'You have Registered Successfully. However, there was an error sending the confirmation email. Please contact support.');
            }
        } catch (\Exception $e) {
            Log::error('Vendor Registration Error: ' . $e->getMessage());
            return back()->with('error', 'Error registering vendor');
        }
    }


protected function sendVendorSignUpMail(Vendor $vendor, string $plainPassword)
    {
        try {
            $data = [
                'vendor_name' => $vendor->vendor_name,
                'vendor_type' => $vendor->status,
                'business_category' => $vendor->business_category,
                'contact_person' => $vendor->contact_person,
                'email' => $vendor->email,
                'phone' => $vendor->phone,
                'pan_number' => $vendor->pan_number,
                'pan_card_file' => $vendor->pan_card_file,
                'password' => $plainPassword,
            ];

            // $recipients = [
            //     $vendor->email,
            //     'coordinator@company.com',
            //     'ceo@company.com'
            // ];

            Mail::to($vendor->email)
                // ->cc(array_slice($recipients, 1))
                ->send(new VendorSignup($data));

            return true;
        } catch (\Exception $e) {
            Log::error('Vendor Signup email error: ' . $e->getMessage());
            return false;
        }
    }




    public function settings()
    {
        $vendor = auth()->guard('vendor')->user();
        return view('vendor.settings', compact('vendor'));
    }

    public function updateSettings(Request $request)
    {
        $vendor = auth()->guard('vendor')->user();

        $validated = $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|different:current_password',
            'new_password_confirmation' => 'nullable|same:new_password',
        ]);

        // Update basic info


        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($vendor->profile_image) {
                Storage::delete($vendor->profile_image);
            }
            // Store new image
            $path = $request->file('profile_image')->store('vendor-profiles', 'public');
            $vendor->profile_image = $path;
        }

        // Update password if provided
        if ($validated['new_password']) {
            if (!Hash::check($validated['current_password'], $vendor->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $vendor->password = Hash::make($validated['new_password']);
        }

        $vendor->save();

        return redirect()->route('vendor.settings')->with('success', 'Settings updated successfully!');
    }

    public function success()
    {
        return view('vendor/signup-success');
    }

    public function signup()
    {
        return view('vendor/signup');
    }

    public function login()
    {
        return view('vendor/login');
    }

    public function dashboard(){
        return view('vendor/dashboard');
    }

    public function generateQr(){
        return view('vendor/generateQr');
    }
    
    

}


