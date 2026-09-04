<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBenefitClaimRequest;
use App\Models\BenefitClaim;
use App\Models\Programme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BenefitController extends Controller
{
    public function index(): View
    {
        $member = request()->user()->member;
        abort_if($member === null, 403);

        return view('member.benefits', [
            'claims' => $member->benefitClaims()->with('programme')->latest()->get(),
            'programmes' => Programme::active()->get(),
        ]);
    }

    public function store(StoreBenefitClaimRequest $request): RedirectResponse
    {
        $member = $request->user()->member;
        abort_if($member === null, 403);

        BenefitClaim::query()->create([
            ...$request->safe()->only(['programme_id', 'amount', 'reason']),
            'member_id' => $member->id,
            'claim_no' => 'HLA-C-'.strtoupper(Str::random(7)),
            'status' => 'SUBMITTED',
            'submitted_at' => now(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }
}
