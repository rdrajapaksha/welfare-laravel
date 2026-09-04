<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        return view('member.announcements', [
            'announcements' => Announcement::published()->whereIn('audience', ['ALL', 'MEMBERS'])->get(),
        ]);
    }
}
