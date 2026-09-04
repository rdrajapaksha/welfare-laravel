<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Support\MembershipDues;
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

    public function update(string $locale, Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:ACTIVE,PENDING,SUSPENDED,RESIGNED'],
            'membership_type' => ['required', 'in:ORDINARY,HONORARY,JUNIOR'],
        ]);

        $member->update($validated);

        if ($member->user) {
            $member->user->update(['is_active' => $validated['status'] === 'ACTIVE']);
        }

        return back()->with('status', (string) d('common.success'));
    }
}
