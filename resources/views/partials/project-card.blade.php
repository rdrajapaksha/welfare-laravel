<a href="{{ route('projects.show', $project) }}" class="card-surface card-interactive overflow-hidden">
    <div class="relative">
        <img src="{{ media_url($project->cover_image, '/media/community-hall.svg') }}" alt="" class="h-48 w-full object-cover">
        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-ink-950/70 to-transparent px-4 pb-3 pt-10">
            @if ($project->completed_at)
                <p class="text-xs font-bold text-white">{{ $project->completed_at->format('M Y') }}</p>
            @endif
        </div>
        <span class="absolute left-3 top-3 rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wider ring-1 {{ $project->themeChipClass() }}">{{ $project->themeLabel() }}</span>
    </div>
    <div class="p-6">
        <p class="text-xs font-bold uppercase tracking-[0.12em] text-teal-700">{{ $d['projects']['status'.ucfirst(strtolower($project->status))] ?? $project->status }}</p>
        <h3 class="mt-2 font-extrabold">{{ $project->translate('title') }}</h3>
        <p class="mt-2 text-sm text-ink-600">{{ $project->translate('summary') }}</p>
        @if ($project->location)
            <p class="mt-3 text-xs font-semibold text-ink-500">{{ $d['projects']['location'] }} · {{ $project->location }}</p>
        @endif
        @if ($project->hasFundraising())
            <p class="mt-4 text-sm font-semibold">{{ $d['projects']['raised'] }} {{ lkr($project->raised_amount) }} / {{ lkr($project->target_amount) }}</p>
        @endif
    </div>
</a>
