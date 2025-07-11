<?php

namespace App\Http\Controllers;

use App\Models\CustomerTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerTicketController extends Controller
{
    public function index()
    {
        return view('raise-ticket');
    }

  public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|max:255',
            'phone'       => 'required|string|max:20',
            'subject'     => 'required|string|max:255',
            'category'    => 'required|in:payment,technical,account,other',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|max:5120', // max 5MB per file
        ]);

        // Handle multiple attachments
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPaths[] = $file->store('customer_attachments', 'public');
            }
        }

        // Generate unique reference ID
        $referenceId = 'CUST-TKT-' . strtoupper(Str::random(8));

        // Create the ticket
        $ticket = CustomerTicket::create([
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'],
            'subject'      => $validated['subject'],
            'category'     => $validated['category'],
            'description'  => $validated['description'],
            'attachments'  => $attachmentPaths ? json_encode($attachmentPaths) : null,
            'reference_id' => $referenceId,
            'status'       => 'Open',
        ]);

        return redirect()
            ->route('home')
            ->with('success', "Your ticket has been submitted! Reference ID: {$referenceId}");
    }
}
