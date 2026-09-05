<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\MemberMeeting;
use App\Support\MembershipDues;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = request()->user();
        $member = $user->member;

        return view('member.dashboard', [
            'member' => $member,
            'dueAmount' => $member ? MembershipDues::amountDue($member) : 0,
            'dueMonths' => $member ? MembershipDues::unpaidMonths($member) : collect(),
            'claims' => $member?->benefitClaims()->with('programme')->latest()->take(5)->get() ?? collect(),
            'announcements' => Announcement::published()
                ->whereIn('audience', ['ALL', 'MEMBERS'])
                ->take(5)
                ->get(),
            'nextEvent' => Event::published()->where('starts_at', '>=', now())->first(),
            'nextMeeting' => MemberMeeting::query()->published()->upcoming()->first(),
        ]);
    }
}
