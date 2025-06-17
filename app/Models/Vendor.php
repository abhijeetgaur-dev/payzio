<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'vendors';

    protected $fillable = [
        'vendor_name',
        'vendor_type',
        'business_category',
        'business_description',
        'contact_person',
        'designation',
        'email',
        'password',
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

        /**
     * The attributes that should be hidden for arrays and JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
