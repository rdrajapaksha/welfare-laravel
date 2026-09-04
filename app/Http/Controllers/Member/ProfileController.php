<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMemberProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $member = request()->user()->member;
        abort_if($member === null, 403);

        return view('member.profile', ['member' => $member]);
    }

    public function update(UpdateMemberProfileRequest $request): RedirectResponse
    {
        $member = $request->user()->member;
        abort_if($member === null, 403);

        $member->update($request->safe()->only([
            'phone', 'whatsapp', 'email', 'address_line1', 'address_line2', 'city',
            'occupation', 'emergency_name', 'emergency_phone', 'bio', 'show_in_directory',
        ]));

        return back()->with('status', (string) d('dashboard.profileSaved'));
    }
}
