<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use App\Support\AboutContent;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('site.about', [
            'vision' => AboutContent::vision(),
            'mission' => AboutContent::mission(),
            'values' => AboutContent::values(),
            'history' => AboutContent::history(),
        ]);
    }

    public function committee(): View
    {
        return view('site.committee', [
            'members' => CommitteeMember::query()->where('is_current', true)->orderBy('sort_order')->get(),
        ]);
    }
}
