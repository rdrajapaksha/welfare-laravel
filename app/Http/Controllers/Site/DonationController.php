<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDonationRequest;
use App\Models\Donation;
use App\Models\FundAllocation;
use App\Models\Project;
use App\Support\DonationPurpose;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::query()->ongoing()->get();

        return view('site.donations.index', [
            'projects' => $projects,
            'fundPurposes' => DonationPurpose::funds(),
            'selectedDestination' => DonationPurpose::selectedDestination(
                $request->string('project')->toString(),
                $projects,
            ),
        ]);
    }

    public function store(StoreDonationRequest $request): RedirectResponse
    {
        $donation = Donation::query()->create([
            ...$request->safe()->only([
                'donor_name', 'email', 'phone', 'amount', 'method', 'purpose', 'project_id', 'message', 'is_anonymous', 'is_recurring',
            ]),
            'reference' => 'HLA-D-'.strtoupper(Str::random(8)),
            'status' => 'PENDING',
            'member_id' => $request->user()?->member?->id,
        ]);

        return redirect()
            ->route('donations.thanks', $donation)
            ->with('status', (string) d('donations.thankYouText'));
    }

    public function thanks(string $locale, Donation $donation): View
    {
        return view('site.donations.thanks', [
            'donation' => $donation->loadMissing('project'),
        ]);
    }

    public function updates(): View
    {
        return view('site.donations.updates', [
            'donations' => Donation::query()->with('project')->where('status', 'CONFIRMED')->latest('confirmed_at')->paginate(20),
            'allocations' => FundAllocation::query()->with('project')->latest('spent_at')->take(12)->get(),
        ]);
    }
}
