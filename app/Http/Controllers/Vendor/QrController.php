<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrCode;
use Illuminate\Support\Str;

class QrController extends Controller
{
    public function index(){
        $qrCodes = QrCode::where('vendor_id', auth('vendor')->user()->id)
            ->latest()
            ->paginate(10);
        return view('vendor.qr.index', compact('qrCodes'));
    }

    public function createQr(){
        return view('vendor.qr.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->vendor_id != auth('vendor')->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to create QR codes for this vendor.',
            ], 403);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'QR code saved successfully.',
    ]);
    }

}
