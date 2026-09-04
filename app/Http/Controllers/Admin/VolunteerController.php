<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VolunteerApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VolunteerController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        return view('admin.volunteers', [
            'volunteers' => VolunteerApplication::query()
                ->when($status !== '', fn ($query) => $query->where('status', $status))
                ->latest()
                ->paginate(20)
                ->withQueryString(),
            'status' => $status,
        ]);
    }

    public function update(string $locale, Request $request, VolunteerApplication $volunteer): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:NEW,CONTACTED,ACTIVE,INACTIVE,DECLINED'],
        ]);

        $volunteer->update([
            'status' => $validated['status'],
            'reviewed_at' => now(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }
}
