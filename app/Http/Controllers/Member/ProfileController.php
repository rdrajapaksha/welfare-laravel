<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMemberProfileRequest;
use App\Support\PhotoStore;
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

        $member->update([
            ...$request->safe()->except(['photo', 'show_in_directory']),
            'show_in_directory' => $request->boolean('show_in_directory'),
            'photo_url' => PhotoStore::store($request->file('photo'), 'members', $member->photo_url),
        ]);

        return back()->with('status', (string) d('dashboard.profileSaved'));
    }
}
