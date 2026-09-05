<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MemberMeeting;
use Illuminate\View\View;

class MemberMeetingController extends Controller
{
    public function index(): View
    {
        $upcoming = MemberMeeting::query()->published()->upcoming()->get();

        return view('member.meetings', [
            'nextMeeting' => $upcoming->first(),
            'upcoming' => $upcoming->slice(1)->values(),
            'past' => MemberMeeting::query()->published()->past()->get(),
        ]);
    }
}
