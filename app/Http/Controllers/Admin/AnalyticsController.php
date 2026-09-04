<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Member;
use App\Models\MonthlyStat;
use App\Models\SupportTicket;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        return view('admin.analytics', [
            'stats' => MonthlyStat::query()->orderByDesc('year')->orderByDesc('month')->take(12)->get()->reverse()->values(),
            'membersByDistrict' => Member::query()->selectRaw('district, count(*) as total')->groupBy('district')->orderByDesc('total')->get(),
            'donationPurpose' => Donation::query()->where('status', 'CONFIRMED')->selectRaw('purpose, sum(amount) as total')->groupBy('purpose')->get(),
            'ticketStatus' => SupportTicket::query()->selectRaw('status, count(*) as total')->groupBy('status')->get(),
        ]);
    }
}
