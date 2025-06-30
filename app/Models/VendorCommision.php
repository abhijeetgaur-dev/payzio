<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Admin; 
use App\Models\Vendor; 

class VendorCommission extends Model
{
    protected $table = 'vendor_commissions';

    protected $fillable = [
        'vendor_id',
        'commission',
        'status',
        'active_date',
        'end_date',
        'status_reason',
        'updated_by',
    ];

    protected $casts = [
        'active_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
}