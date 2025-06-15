<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(admin $admin)
    {
        //
    }
    public function auth(Request $request)
    {
        // Handle authentication logic here
        $credentials = true; // This is a placeholder. Replace with actual authentication logic.
        if ($credentials) {
            // Assuming the admin is authenticated successfully
            return redirect()->route('admin.dashboard');
        } else {
            // If authentication fails, redirect back with an error message
            return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
        }
    }

    public function dashboard()
    {

        return view('admin.dashboard');
    }

    public function generateQr()
    {
        $vendors = Vendor::select('id', 'vendor_name', 'email', 'phone')->get();
        return view('admin.generateQR', compact('vendors'));
    }

    public function login()
    {
        return view('admin.login');
    }

    public function saveQr(Request $request , $id)
    {
        
        return redirect()->back()->with('success', 'QR code saved successfully.');
    }


    public function updateStatus(Request $request, $id ){
            $request->validate(['vendor_id' => 'required|exists:vendors,id',
                                'status' => 'boolean'] ,
                            );
            $vendor = Vendor::findOrFail($id);
            $vendor->status = $request->input('status');
            $vendor->save();
            
            return redirect()->back()->with('success', 'Vendor status updated successfully.');
    }



    public function settings()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.settings', compact('admin'));
    }

        public function updateSettings(Request $request)
    {
        $admin = auth()->guard('admin')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|different:current_password',
            'new_password_confirmation' => 'nullable|same:new_password',
        ]);

        // Update basic info
        $admin->name = $validated['name'];
        $admin->phone = $validated['phone'];

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($admin->profile_image) {
                Storage::delete($admin->profile_image);
            }
            // Store new image
            $path = $request->file('profile_image')->store('admin-profiles', 'public');
            $admin->profile_image = $path;
        }

        // Update password if provided
        if ($validated['new_password']) {
            if (!Hash::check($validated['current_password'], $admin->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $admin->password = Hash::make($validated['new_password']);
        }

        $admin->save();

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully!');
    }

}
