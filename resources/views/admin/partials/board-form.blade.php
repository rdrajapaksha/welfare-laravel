<div class="mt-5" x-data="{ addOpen: {{ $members->isEmpty() ? 'true' : 'false' }} }">
    <button type="button" class="btn btn-brand" @click="addOpen = !addOpen">{{ $d['admin']['addOfficer'] }}</button>
    <form
        x-show="addOpen"
        x-cloak
        method="POST"
        action="{{ route('admin.committee.store') }}"
        enctype="multipart/form-data"
        class="card-surface mt-4 grid max-w-4xl gap-4 p-5 sm:grid-cols-2"
    >
        @csrf
        <input type="hidden" name="board" value="{{ $board }}">
        <div>
            <label class="label">{{ $d['forms']['fullName'] }}</label>
            <input class="field" name="name" required value="{{ old('name') }}">
        </div>
        <div>
            <label class="label">{{ $d['admin']['position'] }} (EN)</label>
            <input class="field" name="position_en" required value="{{ old('position_en') }}">
        </div>
        <div>
            <label class="label">{{ $d['admin']['position'] }} (සි)</label>
            <input class="field" name="position_si" value="{{ old('position_si') }}">
        </div>
        <div>
            <label class="label">{{ $d['admin']['position'] }} (த)</label>
            <input class="field" name="position_ta" value="{{ old('position_ta') }}">
        </div>
        <div>
            <label class="label">{{ $d['forms']['phone'] }}</label>
            <input class="field" name="phone" value="{{ old('phone') }}">
        </div>
        <div>
            <label class="label">{{ $d['forms']['email'] }}</label>
            <input class="field" type="email" name="email" value="{{ old('email') }}">
        </div>
        <div>
            <label class="label">{{ $d['admin']['termFrom'] }}</label>
            <input class="field" type="number" name="term_from" required value="{{ old('term_from', 2024) }}" min="2000" max="2100">
        </div>
        <div>
            <label class="label">{{ $d['admin']['termTo'] }}</label>
            <input class="field" type="number" name="term_to" value="{{ old('term_to', 2026) }}" min="2000" max="2100">
        </div>
        <div>
            <label class="label">{{ $d['admin']['sortOrder'] }}</label>
            <input class="field" type="number" name="sort_order" value="{{ old('sort_order', $members->count()) }}" min="0" max="999">
        </div>
        <div>
            <label class="label">{{ $d['forms']['photo'] }}</label>
            <input class="field" type="file" name="photo" accept="image/jpeg,image/png,image/webp">
        </div>
        <div class="sm:col-span-2">
            <label class="label">{{ $d['admin']['bio'] }} (EN)</label>
            <textarea class="field" name="bio_en" rows="2">{{ old('bio_en') }}</textarea>
        </div>
        <div>
            <label class="label">{{ $d['admin']['bio'] }} (සි)</label>
            <textarea class="field" name="bio_si" rows="2">{{ old('bio_si') }}</textarea>
        </div>
        <div>
            <label class="label">{{ $d['admin']['bio'] }} (த)</label>
            <textarea class="field" name="bio_ta" rows="2">{{ old('bio_ta') }}</textarea>
        </div>
        <div class="sm:col-span-2">
            <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
        </div>
    </form>
</div>

<div class="mt-6 grid gap-5">
    @forelse ($members as $member)
        <article class="card-surface overflow-hidden">
            <form method="POST" action="{{ route('admin.committee.update', $member) }}" enctype="multipart/form-data" class="grid gap-4 p-5 lg:grid-cols-[auto_1fr_1fr]">
                @csrf
                @method('PUT')
                <input type="hidden" name="board" value="{{ $member->board->value }}">
                <div class="flex flex-col items-center gap-3 lg:row-span-6">
                    <x-person-photo :src="$member->photo_url" :name="$member->name" size="lg" />
                    <p class="max-w-[9rem] text-center text-xs font-semibold text-ink-500">{{ $member->translate('position') }}</p>
                </div>
                <div>
                    <label class="label">{{ $d['forms']['fullName'] }}</label>
                    <input class="field" name="name" required value="{{ old('name', $member->name) }}">
                </div>
                <div>
                    <label class="label">{{ $d['admin']['position'] }} (EN)</label>
                    <input class="field" name="position_en" required value="{{ old('position_en', $member->position_en) }}">
                </div>
                <div>
                    <label class="label">{{ $d['admin']['position'] }} (සි)</label>
                    <input class="field" name="position_si" value="{{ old('position_si', $member->position_si) }}">
                </div>
                <div>
                    <label class="label">{{ $d['admin']['position'] }} (த)</label>
                    <input class="field" name="position_ta" value="{{ old('position_ta', $member->position_ta) }}">
                </div>
                <div>
                    <label class="label">{{ $d['forms']['phone'] }}</label>
                    <input class="field" name="phone" value="{{ old('phone', $member->phone) }}">
                </div>
                <div>
                    <label class="label">{{ $d['forms']['email'] }}</label>
                    <input class="field" type="email" name="email" value="{{ old('email', $member->email) }}">
                </div>
                <div>
                    <label class="label">{{ $d['admin']['termFrom'] }}</label>
                    <input class="field" type="number" name="term_from" required value="{{ old('term_from', $member->term_from) }}" min="2000" max="2100">
                </div>
                <div>
                    <label class="label">{{ $d['admin']['termTo'] }}</label>
                    <input class="field" type="number" name="term_to" value="{{ old('term_to', $member->term_to) }}" min="2000" max="2100">
                </div>
                <div>
                    <label class="label">{{ $d['admin']['sortOrder'] }}</label>
                    <input class="field" type="number" name="sort_order" value="{{ old('sort_order', $member->sort_order) }}" min="0" max="999">
                </div>
                <div>
                    <label class="label">{{ $d['admin']['replacePhoto'] }}</label>
                    <input class="field" type="file" name="photo" accept="image/jpeg,image/png,image/webp">
                </div>
                <div class="lg:col-span-2">
                    <label class="label">{{ $d['admin']['bio'] }} (EN)</label>
                    <textarea class="field" name="bio_en" rows="2">{{ old('bio_en', $member->bio_en) }}</textarea>
                </div>
                <div>
                    <label class="label">{{ $d['admin']['bio'] }} (සි)</label>
                    <textarea class="field" name="bio_si" rows="2">{{ old('bio_si', $member->bio_si) }}</textarea>
                </div>
                <div>
                    <label class="label">{{ $d['admin']['bio'] }} (த)</label>
                    <textarea class="field" name="bio_ta" rows="2">{{ old('bio_ta', $member->bio_ta) }}</textarea>
                </div>
                <label class="flex items-center gap-2 text-sm font-semibold">
                    <input type="checkbox" name="is_current" value="1" @checked(old('is_current', $member->is_current))>
                    {{ $d['admin']['currentOfficer'] }}
                </label>
                <div class="flex justify-end lg:col-span-2">
                    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
                </div>
            </form>
            <form method="POST" action="{{ route('admin.committee.destroy', $member) }}" class="border-t border-ink-100 px-5 py-3" onsubmit="return confirm(@js($d['common']['deleteConfirm']))">
                @csrf
                @method('DELETE')
                <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['admin']['deleteOfficer'] }}</button>
            </form>
        </article>
    @empty
        <p class="text-sm text-ink-500">{{ $d['admin']['noRecords'] }}</p>
    @endforelse
</div>
