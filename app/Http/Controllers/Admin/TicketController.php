<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\TicketMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(): View
    {
        return view('admin.tickets.index', [
            'tickets' => SupportTicket::query()->latest()->paginate(20),
        ]);
    }

    public function show(string $locale, SupportTicket $ticket): View
    {
        $ticket->load('messages', 'member');

        return view('admin.tickets.show', ['ticket' => $ticket]);
    }

    public function reply(string $locale, Request $request, SupportTicket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:4000'],
            'status' => ['nullable', 'in:OPEN,IN_PROGRESS,AWAITING_MEMBER,RESOLVED,CLOSED'],
        ]);

        TicketMessage::query()->create([
            'support_ticket_id' => $ticket->id,
            'author_id' => $request->user()->id,
            'author_name' => $request->user()->name,
            'author_role' => 'ADMIN',
            'body' => $validated['body'],
            'is_internal' => false,
        ]);

        $ticket->update([
            'status' => $validated['status'] ?? 'IN_PROGRESS',
            'resolved_at' => in_array($validated['status'] ?? '', ['RESOLVED', 'CLOSED'], true) ? now() : $ticket->resolved_at,
        ]);

        return back()->with('status', (string) d('common.success'));
    }
}
