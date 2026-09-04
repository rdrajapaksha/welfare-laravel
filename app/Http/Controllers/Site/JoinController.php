<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJoinRequest;
use App\Models\Member;
use App\Models\MembershipApplication;
use App\Support\MembershipDues;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JoinController extends Controller
{
    public function create(): View
    {
        return view('site.join', [
            'monthlyFee' => MembershipDues::monthlyFee(),
            'registrationFee' => MembershipDues::registrationFee(),
        ]);
    }

    public function store(StoreJoinRequest $request): RedirectResponse
    {
        $nic = $request->string('nic')->toString();
        $email = $request->string('email')->toString();

        if (Member::query()->where(function ($query) use ($nic, $email): void {
            $query->where('nic', $nic)->orWhere('email', $email);
        })->exists()) {
            return back()->withErrors(['nic' => (string) d('members.alreadyMember')])->withInput();
        }

        MembershipApplication::query()->create([
            ...$request->safe()->only([
                'full_name', 'nic', 'date_of_birth', 'gender', 'occupation', 'address_line1',
                'city', 'district', 'phone', 'email', 'membership_type', 'referred_by', 'motivation',
            ]),
            'application_no' => 'HLA-A-'.strtoupper(Str::random(7)),
            'status' => 'PENDING',
        ]);

        return back()->with('status', (string) d('members.requestReceivedText'));
    }
}
