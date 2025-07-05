<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction_of_customers';

    protected $fillable = [
        'cust_id',
        'cust_machine_id',
        'date',
        'time',
        'paid_by',
        'amount',
        'vendor_id',
        'status',
        'commission',
        'settled',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i:s',
        'amount' => 'decimal:2',
        'commission' => 'decimal:2',
        'status' => 'int',
        'settled' => 'boolean',
    ];

    public $timestamps = true;

        public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }
}