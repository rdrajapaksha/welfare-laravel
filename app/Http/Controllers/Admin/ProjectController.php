<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectPhoto;
use App\Support\PhotoStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects', [
            'projects' => Project::query()->with('photos')->latest('started_at')->orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string', 'max:2000'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:PLANNED,ONGOING,COMPLETED'],
            'target_amount' => ['required', 'integer', 'min:0'],
            'raised_amount' => ['nullable', 'integer', 'min:0'],
            'cover_image' => PhotoStore::imageRules(),
            'photos' => ['nullable', 'array', 'max:'.Project::MAX_PHOTOS],
            'photos.*' => PhotoStore::imageRules(),
        ]);

        $project = Project::query()->create([
            'slug' => Str::slug($validated['title_en']).'-'.Str::lower(Str::random(4)),
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_en' => $validated['summary_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'body_en' => $validated['summary_en'],
            'body_si' => $validated['summary_en'],
            'body_ta' => $validated['summary_en'],
            'location' => $validated['location'],
            'status' => $validated['status'],
            'target_amount' => $validated['target_amount'],
            'raised_amount' => $validated['raised_amount'] ?? 0,
            'spent_amount' => 0,
            'cover_image' => PhotoStore::store($request->file('cover_image'), 'projects'),
            'started_at' => now(),
        ]);

        if (is_string($project->cover_image) && $project->cover_image !== '') {
            $project->photos()->create([
                'path' => $project->cover_image,
                'sort_order' => 0,
            ]);
        }

        $photos = $request->file('photos', []);

        $this->storeUploadedPhotos(
            $project,
            is_array($photos) ? $photos : ($photos ? [$photos] : []),
        );

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, Project $project, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string', 'max:2000'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:PLANNED,ONGOING,COMPLETED'],
            'target_amount' => ['required', 'integer', 'min:0'],
            'raised_amount' => ['nullable', 'integer', 'min:0'],
            'cover_image' => PhotoStore::imageRules(),
        ]);

        $previousCover = $project->cover_image;
        $coverImage = PhotoStore::store($request->file('cover_image'), 'projects', $project->cover_image);

        $project->update([
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_en' => $validated['summary_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'location' => $validated['location'],
            'status' => $validated['status'],
            'target_amount' => $validated['target_amount'],
            'raised_amount' => $validated['raised_amount'] ?? $project->raised_amount,
            'cover_image' => $coverImage,
        ]);

        if ($request->hasFile('cover_image') && is_string($coverImage) && $coverImage !== $previousCover) {
            $this->syncReplacedCoverPhoto($project, $previousCover, $coverImage);
        }

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, Project $project): RedirectResponse
    {
        $project->load('photos');

        foreach ($project->photos as $photo) {
            PhotoStore::delete($photo->path);
        }

        PhotoStore::delete($project->cover_image);
        PhotoStore::delete($project->document_path);
        $project->delete();

        return back()->with('status', (string) d('common.success'));
    }

    public function storePhoto(string $locale, Project $project, Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => PhotoStore::imageRules(required: true),
        ]);

        if ($project->photos()->count() >= Project::MAX_PHOTOS) {
            return back()->withErrors(['photo' => (string) d('admin.projectPhotosHint')]);
        }

        $this->storeUploadedPhotos($project, [$request->file('photo')]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroyPhoto(string $locale, Project $project, ProjectPhoto $photo): RedirectResponse
    {
        abort_unless($photo->project_id === $project->id, 404);

        PhotoStore::delete($photo->path);

        if ($project->cover_image === $photo->path) {
            $next = $project->photos()->where('id', '!=', $photo->id)->first();
            $project->update(['cover_image' => $next?->path]);
        }

        $photo->delete();

        return back()->with('status', (string) d('common.success'));
    }

    /**
     * @param  list<UploadedFile|null>  $files
     */
    private function storeUploadedPhotos(Project $project, array $files): void
    {
        $seen = [];

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $fingerprint = $file->getRealPath().'|'.$file->getClientOriginalName();

            if (isset($seen[$fingerprint])) {
                continue;
            }

            if ($project->photos()->count() >= Project::MAX_PHOTOS) {
                break;
            }

            $seen[$fingerprint] = true;
            $path = PhotoStore::store($file, 'projects');

            $project->photos()->create([
                'path' => $path,
                'sort_order' => (int) $project->photos()->max('sort_order') + 1,
            ]);

            if (! $project->cover_image) {
                $project->update(['cover_image' => $path]);
            }
        }
    }

    private function syncReplacedCoverPhoto(Project $project, ?string $previousCover, string $coverImage): void
    {
        $photo = is_string($previousCover) && $previousCover !== ''
            ? $project->photos()->where('path', $previousCover)->first()
            : null;

        if ($photo !== null) {
            $photo->update(['path' => $coverImage]);

            return;
        }

        if ($project->photos()->count() < Project::MAX_PHOTOS) {
            $project->photos()->create([
                'path' => $coverImage,
                'sort_order' => 0,
            ]);
        }
    }
}
