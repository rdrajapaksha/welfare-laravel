<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRegistrationRequest;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $past = $request->string('filter')->toString() === 'past';

        $events = Event::published()
            ->when(
                $past,
                fn ($query) => $query->where('starts_at', '<', now())->orderByDesc('starts_at'),
                fn ($query) => $query->where('starts_at', '>=', now())->orderBy('starts_at'),
            )
            ->paginate(9)
            ->withQueryString();

        return view('site.events.index', [
            'events' => $events,
            'past' => $past,
        ]);
    }

    public function show(string $locale, Event $event): View
    {
        abort_unless($event->is_published, 404);

        return view('site.events.show', ['event' => $event]);
    }

    public function register(string $locale, StoreEventRegistrationRequest $request, Event $event): RedirectResponse
    {
        abort_unless($event->registration_open, 403);

        EventRegistration::query()->create([
            ...$request->safe()->only(['full_name', 'email', 'phone', 'guests', 'note']),
            'event_id' => $event->id,
            'member_id' => $request->user()?->member?->id,
            'status' => 'CONFIRMED',
        ]);

        $event->increment('attendee_count');

        return back()->with('status', (string) d('events.registrationSuccess'));
    }
}
