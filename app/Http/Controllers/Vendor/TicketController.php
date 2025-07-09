<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class TicketController extends Controller
{
    public function ticketsRaised(Request $request)
    {
        $vendor = auth('vendor')->user();

        $tickets = Ticket::where('vendor_id', $vendor->id)
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

        ];
    });

        return view('vendor.tickets.raised', compact('tickets'));
    }

    public function ticketsClosed(Request $request)
    {
        $vendor = auth('vendor')->user();

        $tickets = Ticket::where('vendor_id', $vendor->id)
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
            'resolution' =>$ticket->resolution,
            'category' => $ticket->category,
            'created_at' => $ticket->created_at,
            'resolved_at' => $ticket->resolved_at,
            'time_to_resolve' => $timeToResolve,

        ];
    });

        return view('vendor.tickets.closed', compact('tickets'));
    }
     public function ticketsCreate(){
        return view('vendor.tickets.create');
     }

      public function ticketsCreateStore(Request $request)
    {
        $vendor = auth('vendor')->user();
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|string|in:payment,technical,account,other',
            'description' => 'required|string',
        ]);

        // Generate a unique reference ID
        $referenceId = 'TKT-' . strtoupper(Str::random(8));

        // Create the ticket
        $ticket = Ticket::create([
            'vendor_id' => $vendor->id, 
            'reference_id' => $referenceId,
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'status' => 'Open', 
        ]);


        return redirect()->route('vendor.tickets.raised')
            ->with('success', "Ticket created successfully! Your reference ID is: {$referenceId}");
    }

}
