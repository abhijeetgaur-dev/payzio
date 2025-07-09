<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'vendor_id',
        'reference_id',
        'subject',
        'description',
        'category',
        'priority',
        'status',
        'resolution',
        'assigned_by',
        'assigned_to',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(Admin::class, 'assigned_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    public function statusLogs()
    {
        return $this->hasMany(TicketStatusLog::class);
    }

}
