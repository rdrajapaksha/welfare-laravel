<form method="POST" action="{{ route('admin.committee.store') }}" enctype="multipart/form-data" class="card-surface mt-4 grid max-w-4xl gap-3 p-5 sm:grid-cols-2">
    @csrf
    <input type="hidden" name="board" value="{{ $board }}">
    <input class="field" name="name" required placeholder="{{ $d['forms']['fullName'] }}">
    <input class="field" name="position_en" required placeholder="{{ $d['admin']['position'] }} (EN)">
    <input class="field" name="position_si" placeholder="{{ $d['admin']['position'] }} (සි)">
    <input class="field" name="position_ta" placeholder="{{ $d['admin']['position'] }} (த)">
    <input class="field" name="phone" placeholder="{{ $d['forms']['phone'] }}">
    <input class="field" type="number" name="term_from" required value="2024" min="2000" max="2100">
    <input class="field" type="number" name="term_to" value="2026" min="2000" max="2100">
    <div class="sm:col-span-2">
        <label class="label">{{ d('forms.photo', 'Photo') }}</label>
        <input class="field" type="file" name="photo" accept="image/jpeg,image/png,image/webp">
    </div>
    <textarea class="field sm:col-span-2" name="bio_en" rows="2" placeholder="{{ $d['admin']['bio'] }} (EN)"></textarea>
    <textarea class="field" name="bio_si" rows="2" placeholder="{{ $d['admin']['bio'] }} (සි)"></textarea>
    <textarea class="field" name="bio_ta" rows="2" placeholder="{{ $d['admin']['bio'] }} (த)"></textarea>
    <div class="sm:col-span-2">
        <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
    </div>
</form>
<div class="mt-6 space-y-4">
    @forelse ($members as $member)
        <form method="POST" action="{{ route('admin.committee.update', $member) }}" enctype="multipart/form-data" class="card-surface grid gap-3 p-5 sm:grid-cols-[auto_1fr_1fr]">
            @csrf
            @method('PUT')
            <div class="sm:row-span-4">
                <x-person-photo :src="$member->photo_url" :name="$member->name" size="md" />
            </div>
            <input type="hidden" name="board" value="{{ $member->board->value }}">
            <input class="field mt-0" name="name" required value="{{ $member->name }}">
            <input class="field mt-0" name="position_en" required value="{{ $member->position_en }}">
            <input class="field mt-0" name="position_si" value="{{ $member->position_si }}">
            <input class="field mt-0" name="position_ta" value="{{ $member->position_ta }}">
            <input class="field mt-0" name="phone" value="{{ $member->phone }}">
            <input class="field mt-0" type="number" name="term_from" required value="{{ $member->term_from }}">
            <input class="field mt-0" type="number" name="term_to" value="{{ $member->term_to }}">
            <input class="field mt-0 sm:col-span-2" type="file" name="photo" accept="image/jpeg,image/png,image/webp">
            <textarea class="field mt-0 sm:col-span-2" name="bio_en" rows="2">{{ $member->bio_en }}</textarea>
            <textarea class="field mt-0" name="bio_si" rows="2">{{ $member->bio_si }}</textarea>
            <textarea class="field mt-0" name="bio_ta" rows="2">{{ $member->bio_ta }}</textarea>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_current" value="1" @checked($member->is_current)> {{ $d['about']['present'] }}</label>
            <div class="flex items-center justify-end gap-3 sm:col-span-2">
                <button class="btn btn-outline" type="submit">{{ $d['common']['save'] }}</button>
            </div>
        </form>
        <form method="POST" action="{{ route('admin.committee.destroy', $member) }}" class="-mt-2 mb-4">
            @csrf
            @method('DELETE')
            <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
        </form>
    @empty
        <p class="text-sm text-ink-500">{{ $d['admin']['noRecords'] }}</p>
    @endforelse
</div>
