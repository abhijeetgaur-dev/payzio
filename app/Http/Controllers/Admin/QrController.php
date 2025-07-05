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
                'message' => 'QR code save successfully but error sending the mail. A mail has been sent to your registered email address.'
            ]);
        } else {
            Log::error('Failed to save QR code');
            return response()
                ->json([
                    'success' => true, 
                    'message' => 'QR code save successfully but error sending the mail.'
                ]);
        }
    } catch (\Exception $e){
        Log::error('Error saving qr code: ' . $e->getMessage());
        return response()
        ->json([
            'success' => false,
            'message' => 'An error occured while saving the QR code. Please try again later.'
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

    public function show($qrCodeId){
        $qr = QRCode::findOrFail($qrCodeId);
        $vendorId = $qr->vendor_id;
        $vendor = Vendor::findOrFail($vendorId);

        return view('admin.qr.show', compact('qr', 'vendor'));

    }

    public function updateStatus(Request $request, $qrId){
        $request->validate(['status' => 'required|in:0,1',]);

        $qr = QrCode::findOrFail($qrId);

        // Assign new values
        $qr->is_active = $request->status;

        $qr->save();

        return redirect()->back()->with('success', 'QR Status updated successfully');

    }


    public function destroy($qrId)
    {
        \Log::info("Trying to delete QR with ID: " . $qrId);

        $qr = QRCode::findOrFail($qrId); // Will throw 404 if not found

        $qr->delete();

        return response()->json(['success' => 'Qr deleted successfully.']);
    }
}
