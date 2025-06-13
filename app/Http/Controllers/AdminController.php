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
        //
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

    public function login()
    {
        return view('admin.login');
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
        // Assuming the admin is authenticated, return the dashboard view
        return view('admin.dashboard');
    }

    public function generateQr()
    {
        $vendors = Vendor::select('id', 'vendor_name', 'email', 'phone')->get();
        return view('admin.generateQR', compact('vendors'));
    }

}
