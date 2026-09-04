<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Member;
use App\Models\MembershipApplication;
use App\Models\SupportTicket;
use App\Models\VolunteerApplication;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'members' => Member::query()->where('status', 'ACTIVE')->count(),
            'applications' => MembershipApplication::query()->where('status', 'PENDING')->count(),
            'donationsMonth' => Donation::query()->where('status', 'CONFIRMED')->where('confirmed_at', '>=', now()->startOfMonth())->sum('amount'),
            'openTickets' => SupportTicket::query()->whereIn('status', ['OPEN', 'IN_PROGRESS'])->count(),
            'upcomingEvents' => Event::published()->where('starts_at', '>=', now())->count(),
            'volunteers' => VolunteerApplication::query()->where('status', 'NEW')->count(),
            'recentDonations' => Donation::query()->latest()->take(5)->get(),
            'recentApplications' => MembershipApplication::query()->latest()->take(5)->get(),
        ]);
    }
}
