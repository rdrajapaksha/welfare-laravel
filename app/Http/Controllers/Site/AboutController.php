<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use App\Support\AboutContent;
use App\Support\SiteContent;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('site.about', [
            'introParagraphs' => SiteContent::introParagraphs(),
            'vision' => SiteContent::vision(),
            'mission' => SiteContent::mission(),
            'objectives' => SiteContent::objectives(),
            'values' => AboutContent::values(),
            'history' => AboutContent::history(),
        ]);
    }

    public function committee(): View
    {
        return view('site.committee', [
            'title' => d('about.committeeTitle'),
            'subtitle' => d('about.committeeSubtitle'),
            'members' => CommitteeMember::query()->current()->executive()->get(),
        ]);
    }

    public function advisory(): View
    {
        return view('site.committee', [
            'title' => d('about.advisoryTitle'),
            'subtitle' => d('about.advisorySubtitle'),
            'members' => CommitteeMember::query()->current()->advisory()->get(),
        ]);
    }
}
