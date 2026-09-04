<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function index(): View
    {
        return view('admin.donations', [
            'donations' => Donation::query()->with('project')->latest()->paginate(20),
        ]);
    }

    public function confirm(string $locale, Donation $donation): RedirectResponse
    {
        $donation->update([
            'status' => 'CONFIRMED',
            'confirmed_at' => now(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }
}
