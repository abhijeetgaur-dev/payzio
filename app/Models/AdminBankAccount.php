<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminBankAccount extends Model
{
    use HasFactory;

    protected $table = 'admin_bank_accounts';

    protected $fillable = [
        'admin_id',
        'bank_name',
        'account_number',
        'account_holder',
        'ifsc_code',
        'branch_name',
        'is_primary',
        'notes',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
