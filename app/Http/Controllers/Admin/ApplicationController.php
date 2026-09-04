<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(): View
    {
        return view('admin.applications', [
            'applications' => MembershipApplication::query()->latest()->paginate(20),
        ]);
    }

    public function admit(string $locale, MembershipApplication $application): RedirectResponse
    {
        if (Member::query()->where(function ($query) use ($application): void {
            $query->where('nic', $application->nic)->orWhere('email', $application->email);
        })->exists()) {
            return back()->with('error', (string) d('admin.admitDuplicateError'));
        }

        $password = Str::password(12);
        $user = User::query()->where('email', $application->email)->first();

        if ($user === null) {
            $user = User::query()->create([
                'name' => $application->full_name,
                'email' => $application->email,
                'password' => $password,
                'role' => UserRole::Member,
                'locale' => app()->getLocale(),
                'is_active' => true,
            ]);
        }

        $count = Member::query()->count();

        Member::query()->create([
            'membership_no' => 'HLA-'.str_pad((string) (1001 + $count), 4, '0', STR_PAD_LEFT),
            'full_name' => $application->full_name,
            'name_with_initials' => $application->full_name,
            'nic' => $application->nic,
            'date_of_birth' => $application->date_of_birth,
            'gender' => $application->gender,
            'occupation' => $application->occupation,
            'address_line1' => $application->address_line1,
            'city' => $application->city,
            'district' => $application->district,
            'phone' => $application->phone,
            'email' => $application->email,
            'membership_type' => $application->membership_type,
            'status' => 'ACTIVE',
            'joined_at' => now(),
            'user_id' => $user->id,
        ]);

        $application->update([
            'status' => 'APPROVED',
            'decided_at' => now(),
        ]);

        return back()->with('status', d('admin.admitSuccessText').' '.$application->email.' / '.$password);
    }

    public function reject(string $locale, MembershipApplication $application): RedirectResponse
    {
        $application->update([
            'status' => 'REJECTED',
            'decided_at' => now(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }
}
