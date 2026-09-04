<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        return view('admin.messages', [
            'messages' => ContactMessage::query()->latest()->paginate(20),
        ]);
    }

    public function update(string $locale, Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:NEW,READ,REPLIED,ARCHIVED'],
        ]);

        $message->update($validated);

        return back()->with('status', (string) d('common.success'));
    }
}
