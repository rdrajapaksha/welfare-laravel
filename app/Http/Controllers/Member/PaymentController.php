<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMembershipRenewalRequest;
use App\Models\Payment;
use App\Support\MembershipDues;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $member = request()->user()->member;
        abort_if($member === null, 403);

        return view('member.payments', [
            'member' => $member,
            'payments' => $member->payments()->latest('paid_at')->get(),
            'donations' => $member->donations()->latest()->get(),
            'unpaid' => MembershipDues::unpaidMonths($member),
            'fee' => MembershipDues::monthlyFee(),
            'dueAmount' => MembershipDues::amountDue($member),
        ]);
    }

    public function store(StoreMembershipRenewalRequest $request): RedirectResponse
    {
        $member = $request->user()->member;
        abort_if($member === null, 403);

        $fee = MembershipDues::monthlyFee();

        foreach ($request->validated('months') as $key) {
            [$year, $month] = array_map('intval', explode('-', $key));

            $exists = $member->payments()
                ->where('type', 'MEMBERSHIP_FEE')
                ->where('period_year', $year)
                ->where('period_month', $month)
                ->exists();

            if ($exists) {
                continue;
            }

            Payment::query()->create([
                'receipt_no' => 'HLA-P-'.strtoupper(Str::random(8)),
                'member_id' => $member->id,
                'amount' => $fee,
                'type' => 'MEMBERSHIP_FEE',
                'period_year' => $year,
                'period_month' => $month,
                'method' => $request->string('method')->toString(),
                'status' => 'PENDING',
            ]);
        }

        return back()->with('status', (string) d('fees.renewSuccess'));
    }
}
