<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Payment;
use App\Models\SiteSetting;
use App\Support\MembershipDues;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FeeController extends Controller
{
    public function index(): View
    {
        $members = Member::query()->where('status', 'ACTIVE')->whereIn('membership_type', ['ORDINARY', 'JUNIOR'])->get();

        $arrears = $members->map(function (Member $member) {
            $amount = MembershipDues::amountDue($member);

            return $amount > 0 ? ['member' => $member, 'amount' => $amount, 'months' => MembershipDues::unpaidMonths($member)->count()] : null;
        })->filter()->values();

        return view('admin.fees', [
            'monthlyFee' => MembershipDues::monthlyFee(),
            'registrationFee' => MembershipDues::registrationFee(),
            'pending' => Payment::query()->where('status', 'PENDING')->with('member')->latest()->get(),
            'arrears' => $arrears,
            'members' => $members,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'monthly_fee' => ['required', 'integer', 'min:1'],
            'registration_fee' => ['required', 'integer', 'min:1'],
        ]);

        foreach (['monthly_fee', 'registration_fee'] as $key) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                [
                    'value_en' => (string) $validated[$key],
                    'value_si' => (string) $validated[$key],
                    'value_ta' => (string) $validated[$key],
                    'group' => 'fees',
                ],
            );
        }

        return back()->with('status', (string) d('admin.feesSaved'));
    }

    public function record(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'year' => ['required', 'integer', 'min:2013'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'method' => ['required', 'in:BANK_TRANSFER,CASH,CHEQUE'],
        ]);

        $exists = Payment::query()
            ->where('member_id', $validated['member_id'])
            ->where('period_year', $validated['year'])
            ->where('period_month', $validated['month'])
            ->where('type', 'MEMBERSHIP_FEE')
            ->exists();

        if ($exists) {
            return back()->with('error', (string) d('admin.paymentDuplicate'));
        }

        Payment::query()->create([
            'receipt_no' => 'HLA-P-'.strtoupper(Str::random(8)),
            'member_id' => $validated['member_id'],
            'amount' => MembershipDues::monthlyFee(),
            'type' => 'MEMBERSHIP_FEE',
            'period_year' => $validated['year'],
            'period_month' => $validated['month'],
            'method' => $validated['method'],
            'status' => 'PAID',
            'paid_at' => now(),
        ]);

        return back()->with('status', (string) d('admin.paymentRecorded'));
    }

    public function confirm(string $locale, Payment $payment): RedirectResponse
    {
        $payment->update([
            'status' => 'PAID',
            'paid_at' => now(),
        ]);

        return back()->with('status', (string) d('admin.paymentConfirmed'));
    }
}
