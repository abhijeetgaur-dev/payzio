<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrCode as QRCode;
use Illuminate\Support\Str;

class QrController extends Controller
{
    public function index(){
        $qrCodes = QrCode::where('vendor_id', auth('vendor')->user()->id)
            ->latest()
            ->paginate(10);
        return view('vendor.qr.index', compact('qrCodes'));
    }

    
    public function show($qrCodeId){
        $vendor = auth('vendor')->user();
        $qr = QrCode::findOrFail($qrCodeId);

        return view('vendor.qr.show', compact('qr', 'vendor'));

    }


    public function destroy($qrId)
    {
        \Log::info("Trying to delete QR with ID: " . $qrId);

        $qr = QRCode::findOrFail($qrId); // Will throw 404 if not found

        $qr->delete();

        return response()->json(['success' => 'Qr deleted successfully.']);
    }


}
