<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AnnualReport;
use App\Models\FundAllocation;
use Illuminate\View\View;

class TransparencyController extends Controller
{
    public function __invoke(): View
    {
        return view('site.transparency', [
            'reports' => AnnualReport::query()->where('is_published', true)->orderByDesc('year')->get(),
            'allocations' => FundAllocation::query()->with('project')->latest('spent_at')->paginate(20),
        ]);
    }
}
