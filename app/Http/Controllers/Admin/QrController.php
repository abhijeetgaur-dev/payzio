<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrCode;
use App\Models\Vendor;
use App\Mail\SaveQR;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class QrController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function store(Request $request)
    {
        try{
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

        
        if ($this->sendSaveQRmail($qrCode)) {
            Log::info('QR code saved successfully');
            return response()
            ->json([
                'success' => true, 
                'message' => 'You have Registered Successfully. A mail has been sent to your registered email address.'
            ]);
        } else {
            Log::error('Failed to save QR code');
            return response()
                ->json([
                    'success' => false, 
                    'message' => 'Failed to save QR code. Please try again.'
                ]);
        }
    } catch (\Exception $e){
        Log::error('Error saving qr code: ' . $e->getMessage());
        return response()
        ->json([
            'success' => false,
            'message' => 'An error occured while sending the email. Please try again later.'
        ]);
    }
}


protected function sendSaveQRmail(QrCode $qrCode){
    try{

        $vendor = Vendor::findOrFail($qrCode->vendor_id);
        $data = [
            'vendor_name' => $vendor->vendor_name,
            'email'=> $vendor->email,
            'qr_code_url' => $qrCode->qr_code_url
        ];

        \Mail::to($vendor->email)
        ->send(new SaveQR($data));

        return true;

    }catch(\Exception $e){
        Log::error('Vendor Signup email error: ' . $e->getMessage());
        return false;

    }
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
