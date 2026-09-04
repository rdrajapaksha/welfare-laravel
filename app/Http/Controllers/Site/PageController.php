<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Support\SiteContent;
use Illuminate\View\View;

class PageController extends Controller
{
    public function privacy(): View
    {
        return view('site.legal', [
            'title' => d('footer.privacy'),
            'body' => SiteContent::copy('legal.privacy'),
        ]);
    }

    public function terms(): View
    {
        return view('site.legal', [
            'title' => d('footer.terms'),
            'body' => SiteContent::copy('legal.terms'),
        ]);
    }
}
