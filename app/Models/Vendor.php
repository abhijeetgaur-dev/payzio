<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = [
        'vendor_name',
        'vendor_type',
        'business_category',
        'business_description',
        'contact_person',
        'designation',
        'email',
        'phone',
        'website',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'pan_number',
        'gst_number',
        'bank_name',
        'account_number',
        'account_holder',
        'ifsc_code',
        'branch_name',
        'pan_card_file',
        'gst_certificate_file',
        'registration_doc_file',
        'cancelled_cheque_file',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
