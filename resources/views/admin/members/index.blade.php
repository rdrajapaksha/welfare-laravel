@extends('layouts.dash')
@section('title', $d['admin']['members'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['members'] }}</h1>
<form class="mt-6 flex gap-2" method="GET">
    <input class="field mt-0 max-w-sm" name="q" value="{{ $search }}" placeholder="{{ $d['admin']['searchMembers'] }}">
    <button class="btn btn-outline" type="submit">{{ $d['common']['search'] }}</button>
</form>
<div class="mt-6 overflow-x-auto">
    <table class="min-w-full text-left text-sm">
        <thead class="text-xs uppercase text-ink-400">
            <tr><th class="py-2">No.</th><th>Name</th><th>NIC</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr class="border-t border-ink-100">
                    <td class="py-3 font-semibold">{{ $member->membership_no }}</td>
                    <td>{{ $member->full_name }}</td>
                    <td>{{ $member->nic }}</td>
                    <td>{{ $member->status }}</td>
                    <td><a class="font-bold text-brand-700" href="{{ route('admin.members.show', $member) }}">{{ $d['admin']['viewMember'] }}</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $members->links() }}</div>
@endsection
