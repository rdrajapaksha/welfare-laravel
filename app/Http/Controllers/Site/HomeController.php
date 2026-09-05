<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AnnualReport;
use App\Models\Event;
use App\Models\Faq;
use App\Models\Member;
use App\Models\NewsPost;
use App\Models\Partner;
use App\Models\Programme;
use App\Models\Project;
use App\Support\SiteContent;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $report = AnnualReport::query()->where('is_published', true)->orderByDesc('year')->first();
        $adminPct = $report && $report->total_expenditure > 0
            ? (int) round(($report->admin_spend / $report->total_expenditure) * 100)
            : 7;

        return view('site.home', [
            'programmes' => Programme::active()->take(4)->get(),
            'projects' => Project::query()
                ->completed()
                ->take(3)
                ->get(),
            'news' => NewsPost::published()->take(3)->get(),
            'events' => Event::published()->where('starts_at', '>=', now())->take(3)->get(),
            'partners' => Partner::active()->get(),
            'faqs' => Faq::published()->take(5)->get(),
            'report' => $report,
            'memberCount' => max(Member::query()->where('status', 'ACTIVE')->count(), (int) config('hla.impact.members')),
            'directPct' => 100 - $adminPct,
            'introParagraphs' => SiteContent::introParagraphs(),
        ]);
    }
}
