<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorBankAccount extends Model
{
    use HasFactory;

    protected $table = 'vendor_bank_accounts';

    protected $fillable = [
        'vendor_id',
        'bank_name',
        'account_number',
        'account_holder',
        'ifsc_code',
        'branch_name',
        'is_primary',
        'notes',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }
}
