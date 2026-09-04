<?php

namespace App\Support;

use App\Models\Member;
use App\Models\SiteSetting;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class MembershipDues
{
    public static function monthlyFee(): int
    {
        $stored = SiteSetting::query()->where('key', 'monthly_fee')->value('value_en');

        return is_numeric($stored) ? (int) $stored : (int) config('hla.fees.monthly');
    }

    public static function registrationFee(): int
    {
        $stored = SiteSetting::query()->where('key', 'registration_fee')->value('value_en');

        return is_numeric($stored) ? (int) $stored : (int) config('hla.fees.registration');
    }

    public static function isExempt(Member $member): bool
    {
        return $member->membership_type === 'HONORARY';
    }

    /**
     * @return Collection<int, array{year: int, month: int, key: string, label: string}>
     */
    public static function unpaidMonths(Member $member): Collection
    {
        if (self::isExempt($member) || $member->status !== 'ACTIVE') {
            return collect();
        }

        $paidKeys = $member->payments()
            ->where('type', 'MEMBERSHIP_FEE')
            ->whereIn('status', ['PAID', 'PENDING'])
            ->get()
            ->map(fn ($payment) => sprintf('%04d-%02d', $payment->period_year, $payment->period_month))
            ->all();

        $cursor = CarbonImmutable::parse($member->joined_at ?? $member->created_at)->startOfMonth();
        $end = CarbonImmutable::now()->startOfMonth();
        $months = collect();

        while ($cursor->lessThanOrEqualTo($end)) {
            $key = $cursor->format('Y-m');

            if (! in_array($key, $paidKeys, true)) {
                $months->push([
                    'year' => (int) $cursor->year,
                    'month' => (int) $cursor->month,
                    'key' => $key,
                    'label' => $cursor->isoFormat('MMMM YYYY'),
                ]);
            }

            $cursor = $cursor->addMonth();
        }

        return $months;
    }

    public static function amountDue(Member $member): int
    {
        return self::unpaidMonths($member)->count() * self::monthlyFee();
    }
}
