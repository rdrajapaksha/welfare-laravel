<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Models\SupportTicket;
use App\Models\TicketMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(): View
    {
        $member = request()->user()->member;
        abort_if($member === null, 403);

        return view('member.tickets.index', [
            'tickets' => $member->tickets()->latest()->get(),
        ]);
    }

    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $user = $request->user();
        $member = $user->member;
        abort_if($member === null, 403);

        $ticket = SupportTicket::query()->create([
            ...$request->safe()->only(['category', 'subject', 'description', 'priority']),
            'ticket_no' => 'HLA-T-'.strtoupper(Str::random(7)),
            'member_id' => $member->id,
            'contact_name' => $member->full_name,
            'email' => $user->email,
            'phone' => $member->phone,
            'status' => 'OPEN',
        ]);

        return redirect()->route('member.tickets.show', $ticket)
            ->with('status', d('dashboard.ticketCreated2').' '.$ticket->ticket_no);
    }

    public function show(string $locale, SupportTicket $ticket): View
    {
        $this->authorizeTicket($ticket);
        $ticket->load('messages');

        return view('member.tickets.show', ['ticket' => $ticket]);
    }

    public function reply(string $locale, Request $request, SupportTicket $ticket): RedirectResponse
    {
        $this->authorizeTicket($ticket);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:4000'],
        ]);

        TicketMessage::query()->create([
            'support_ticket_id' => $ticket->id,
            'author_id' => $request->user()->id,
            'author_name' => $request->user()->name,
            'author_role' => 'MEMBER',
            'body' => $validated['body'],
            'is_internal' => false,
        ]);

        $ticket->update(['status' => 'OPEN']);

        return back()->with('status', (string) d('common.success'));
    }

    private function authorizeTicket(SupportTicket $ticket): void
    {
        abort_unless($ticket->member_id === request()->user()?->member?->id, 404);
    }
}
