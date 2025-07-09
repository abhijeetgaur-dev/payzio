<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketStatusLog extends Model
{
    use HasFactory;

    protected $table = 'ticket_status_logs';

    public $timestamps = false; 

    protected $fillable = [
        'ticket_id',
        'status',
        'changed_at',
        'changed_by',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];


    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function changedBy()
    {

        return $this->belongsTo(Admin::class, 'changed_by');
    }
}