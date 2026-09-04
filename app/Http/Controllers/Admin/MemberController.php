<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdminMemberRequest;
use App\Models\Member;
use App\Support\MembershipDues;
use App\Support\PhotoStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->toString();

        $members = Member::query()
            ->with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search): void {
                    $inner->where('full_name', 'like', '%'.$search.'%')
                        ->orWhere('nic', 'like', '%'.$search.'%')
                        ->orWhere('membership_no', 'like', '%'.$search.'%');
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.members.index', [
            'members' => $members,
            'search' => $search,
        ]);
    }

    public function show(string $locale, Member $member): View
    {
        $member->load(['user', 'payments', 'donations', 'benefitClaims.programme']);

        return view('admin.members.show', [
            'member' => $member,
            'dueAmount' => MembershipDues::amountDue($member),
            'unpaid' => MembershipDues::unpaidMonths($member),
        ]);
    }

    public function update(string $locale, UpdateAdminMemberRequest $request, Member $member): RedirectResponse
    {
        $validated = $request->safe()->except(['photo']);

        $member->update([
            ...$validated,
            'photo_url' => PhotoStore::store($request->file('photo'), 'members', $member->photo_url),
        ]);

        if ($member->user) {
            $member->user->update([
                'name' => $validated['full_name'],
                'is_active' => $validated['status'] === 'ACTIVE',
            ]);
        }

        return back()->with('status', (string) d('common.success'));
    }
}
