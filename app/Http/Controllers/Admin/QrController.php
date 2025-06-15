<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrCode;
use Illuminate\Support\Str;


class QrController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $token = Str::uuid()->toString();
        $filename = $request->file('qr_image')->hashName(); // just name
        $request->file('qr_image')->storeAs('qr_codes', $filename, 'public'); // store with custom name

        // Save to DB
        $qrCode = QrCode::create([
            'vendor_id' => $request->vendor_id,
            'qr_code_token' => $token,
            'qr_code_url' => $filename,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'QR code saved successfully.');
    }

    public function index()
    {
         $qrCodes = QrCode::with('vendor')
                ->latest()
                ->paginate(10);
                
    return view('admin.qr.index', compact('qrCodes'));
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
