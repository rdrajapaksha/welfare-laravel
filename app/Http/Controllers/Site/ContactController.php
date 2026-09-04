<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('site.contact');
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        ContactMessage::query()->create([
            ...$request->safe()->only(['name', 'email', 'phone', 'subject', 'message', 'topic']),
            'status' => 'NEW',
        ]);

        return back()->with('status', (string) d('contact.successText'));
    }
}
