<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberDirectoryController extends Controller
{
    public function __invoke(Request $request): View
    {
        $search = $request->string('q')->toString();
        $district = $request->string('district')->toString();
        $type = $request->string('type')->toString();

        $members = Member::query()
            ->where('show_in_directory', true)
            ->where('status', 'ACTIVE')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search): void {
                    $inner->where('full_name', 'like', '%'.$search.'%')
                        ->orWhere('city', 'like', '%'.$search.'%')
                        ->orWhere('membership_no', 'like', '%'.$search.'%');
                });
            })
            ->when($district !== '', fn ($query) => $query->where('district', $district))
            ->when($type !== '', fn ($query) => $query->where('membership_type', $type))
            ->orderBy('full_name')
            ->paginate(24)
            ->withQueryString();

        return view('site.members', [
            'members' => $members,
            'districts' => Member::query()->where('show_in_directory', true)->distinct()->orderBy('district')->pluck('district'),
            'search' => $search,
            'district' => $district,
            'type' => $type,
        ]);
    }
}
