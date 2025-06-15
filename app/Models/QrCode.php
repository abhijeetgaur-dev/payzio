<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    // Optional if Laravel doesn't automatically detect table name
    protected $table = 'vendor_qr_codes';

    // Allow mass assignment
    protected $fillable = [
        'vendor_id',
        'qr_code_token',
        'qr_code_url',
        'is_active',
    ];

    // Casts
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship: Each QR code belongs to a vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}