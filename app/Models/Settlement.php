<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settlement extends Model
{
    use HasFactory;

    protected $table = 'settlements';

    protected $fillable = [
        'transaction_ids',
        'settlement_reference',
        'settled_at',
        'vendor_id',
        'transaction_amount',
        'total_commission',
        'total_amount',
        'payment_method',
        'status',
        'admin_id',
        'notes',
        'vendor_bank_details',
        'admin_bank_details'
    ];

    protected $casts = [
        'settled_at' => 'datetime',
        'transaction_amount' => 'decimal:2',
        'total_commission' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'vendor_bank_details' => 'array',
        'admin_bank_details' => 'array',
    ];

    // Relationships
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
