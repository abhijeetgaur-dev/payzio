<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CustomerTicket extends Model
{
    use HasFactory;

    protected $table = 'customer_tickets';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'category',
        'description',
        'attachments',
        'status',
        'assigned_by',
        'assigned_to',
        'resolution',
        'resolved_at',
        'reference_id',
    ];

    protected $casts = [
        'attachments' => 'array',
        'resolved_at' => 'datetime',
    ];

    // Optional: If you want to define relationships for assigned_by or assigned_to
    public function assignedTo()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(Admin::class, 'assigned_by');
    }
}