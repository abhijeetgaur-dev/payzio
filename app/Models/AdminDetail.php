<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminDetail extends Model
{
    use HasFactory;

    protected $table = 'admin_details';

    protected $fillable = [
        'admin_id',
        'contact_person',
        'designation',
        'website',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'pan_number',
        'gst_number',
        'pan_card_file',
        'gst_certificate_file',
        'registration_doc_file',
        'cancelled_cheque_file',
        'status',
        'status_reason',
        'company_logo',
        'company_header',
        'company_footer',
        'admin_type'
    ];

    public function bankAccounts()
    {
        return $this->hasMany(AdminBankAccount::class, 'admin_id', 'admin_id');
    }
}
