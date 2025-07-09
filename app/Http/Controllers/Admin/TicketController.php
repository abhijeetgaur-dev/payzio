<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Admin;
use App\Models\TicketStatusLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TicketController extends Controller
{
    protected $statuses = ['Open', 'In Progress', 'Pending', 'Resolved'];
    protected $priorities = ['Low', 'Medium', 'High', 'Critical'];

    public function ticketsRaised(Request $request)
    {
        $admin = auth('admin')->user();
        $tickets = Ticket::with('vendor')
            ->where('status', '!=', 'Resolved')
            ->get()
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'reference_id' => $ticket->reference_id,
                    'subject' => $ticket->subject,
                    'status' => $ticket->status,
                    'category' => $ticket->category,
                    'created_at' => $ticket->created_at,
                    'priority' => $ticket->priority,
                    'vendor' => $ticket->vendor,
                    'assigned_to' => $ticket->assigned_to,
                    'assigned_by' => $ticket->assigned_by,
                ];
            });

        return view('admin.tickets.raised', compact('tickets'));
    }

    public function ticketsView($ticketId, Request $request)
    {
        $admins = Admin::all();
        $ticket = Ticket::with('vendor', 'assignedTo', 'assignedBy')->where('id', $ticketId)->firstOrFail();

        $assigned_to_admin = $ticketData = [
            'id' => $ticket->id,
            'reference_id' => $ticket->reference_id,
            'subject' => $ticket->subject,
            'status' => $ticket->status,
            'category' => $ticket->category,
            'created_at' => $ticket->created_at,
            'priority' => $ticket->priority,
            'vendor' => $ticket->vendor,
            'assigned_to' => $ticket->assignedTo,
            'assigned_by' => $ticket->assignedBy,
        ];

        $statuses = $this->statuses;
        $priorities = $this->priorities;

        return view('admin.tickets.view', compact('admins', 'statuses', 'priorities'), ['ticket' => $ticketData]);
    }

    public function updateStatus($ticketId, Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'status' => 'required|string|in:Open,In Progress,Pending Customer,Resolved',
        ]);

        $ticket = Ticket::findOrFail($ticketId);
        $ticket->status = $request->input('status');

        if ($request->status === 'Resolved') {
            $ticket->resolution = $request->resolution;
            $ticket->resolved_at = now();
        }

        $ticket->save();

        $statusLog = TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => $request->status,
            'changed_at' => now(),
            'changed_by' => $admin->id,
        ]);

        return redirect()->back()->with('success', 'Ticket status updated successfully.');
    }

    public function assignTicket($ticketId, Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'assigned_to' => 'required|integer|exists:admins,id',
        ]);

        $ticket = Ticket::findOrFail($ticketId);
        $ticket->assigned_to = $request->input('assigned_to');
        $ticket->assigned_by = $admin->id;
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket Assigned Successfully.');
    }

    public function assignPriority($ticketId, Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'priority' => 'required|string|in:Low,Medium,High,Critical',
        ]);

        $ticket = Ticket::findOrFail($ticketId);
        $ticket->priority = $request->input('priority');
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket Priority Updated Successfully.');
    }
    public function ticketsClosed(Request $request)
    {
        $admin = auth('admin')->user();

        $tickets = Ticket::with('vendor', 'assignedTo', 'assignedBy')
            ->where('status', 'Resolved')
            ->get()
            ->map(function ($ticket) {
                $timeToResolve = null;

                if ($ticket->resolved_at && $ticket->created_at) {
                    $diff = $ticket->created_at->diff($ticket->resolved_at);

                    $parts = [];

                    if ($diff->d > 0) {
                        $parts[] = $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
                    }
                    if ($diff->h > 0) {
                        $parts[] = $diff->h . ' hr' . ($diff->h > 1 ? 's' : '');
                    }
                    if ($diff->i > 0) {
                        $parts[] = $diff->i . ' min' . ($diff->i > 1 ? 's' : '');
                    }

                    $timeToResolve = implode(' ', $parts) ?: 'Less than 1 min';
                }

                return [
                    'id' => $ticket->id,
                    'reference_id' => $ticket->reference_id,
                    'subject' => $ticket->subject,
                    'status' => $ticket->status,
                    'category' => $ticket->category,
                    'created_at' => $ticket->created_at,
                    'priority' => $ticket->priority,
                    'vendor' => $ticket->vendor,
                    'assigned_to' => $ticket->assignedTo,
                    'assigned_by' => $ticket->assignedBy,
                    'resolution' => $ticket->resolution,
                    'resolved_at' => $ticket->resolved_at,
                    'time_to_resolve' => $timeToResolve,
                ];
            });

        $totalClosedTickets = $tickets->count();

        return view('admin.tickets.closed', compact('tickets', 'totalClosedTickets'));
    }
}
