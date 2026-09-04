<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function privacy(): View
    {
        return view('site.legal', [
            'title' => d('footer.privacy'),
            'body' => 'Heart Link Allianze Welfare Society stores membership and donation records only for association administration, welfare claims and statutory reporting. We do not sell personal data.',
        ]);
    }

    public function terms(): View
    {
        return view('site.legal', [
            'title' => d('footer.terms'),
            'body' => 'Use of this website is subject to the constitution of the association. Membership is granted only after committee admission. Donations are voluntary and receipted once confirmed.',
        ]);
    }
}
