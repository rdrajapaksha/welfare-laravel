<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPhoto;
use App\Support\PhotoStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        return view('admin.events', [
            'events' => Event::query()->with('photos')->orderByDesc('starts_at')->paginate(20),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'starts_at' => ['required', 'date'],
            'cover_image' => PhotoStore::imageRules(),
            'photos' => ['nullable', 'array', 'max:'.Event::MAX_PHOTOS],
            'photos.*' => PhotoStore::imageRules(),
        ]);

        $event = Event::query()->create([
            'slug' => Str::slug($validated['title_en']).'-'.Str::random(5),
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_en' => $validated['summary_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'body_en' => $validated['summary_en'],
            'body_si' => $validated['summary_en'],
            'body_ta' => $validated['summary_en'],
            'venue' => $validated['venue'],
            'city' => $validated['city'],
            'starts_at' => $validated['starts_at'],
            'cover_image' => PhotoStore::store($request->file('cover_image'), 'events'),
            'is_published' => true,
            'registration_open' => true,
        ]);

        if (is_string($event->cover_image) && $event->cover_image !== '') {
            $event->photos()->create([
                'path' => $event->cover_image,
                'sort_order' => 0,
            ]);
        }

        $photos = $request->file('photos', []);

        $this->storeUploadedPhotos(
            $event,
            is_array($photos) ? $photos : ($photos ? [$photos] : []),
        );

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, Event $event, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'starts_at' => ['required', 'date'],
            'cover_image' => PhotoStore::imageRules(),
        ]);

        $previousCover = $event->cover_image;
        $coverImage = PhotoStore::store($request->file('cover_image'), 'events', $event->cover_image);

        $event->update([
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_en' => $validated['summary_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'venue' => $validated['venue'],
            'city' => $validated['city'],
            'starts_at' => $validated['starts_at'],
            'cover_image' => $coverImage,
            'is_published' => $request->boolean('is_published'),
        ]);

        if ($request->hasFile('cover_image') && is_string($coverImage) && $coverImage !== $previousCover) {
            $this->syncReplacedCoverPhoto($event, $previousCover, $coverImage);
        }

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, Event $event): RedirectResponse
    {
        $event->load('photos');

        foreach ($event->photos as $photo) {
            PhotoStore::delete($photo->path);
        }

        PhotoStore::delete($event->cover_image);
        PhotoStore::delete($event->document_path);
        $event->delete();

        return back()->with('status', (string) d('common.success'));
    }

    public function storePhoto(string $locale, Event $event, Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => PhotoStore::imageRules(required: true),
        ]);

        if ($event->photos()->count() >= Event::MAX_PHOTOS) {
            return back()->withErrors(['photo' => (string) d('admin.eventPhotosHint')]);
        }

        $this->storeUploadedPhotos($event, [$request->file('photo')]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroyPhoto(string $locale, Event $event, EventPhoto $photo): RedirectResponse
    {
        abort_unless($photo->event_id === $event->id, 404);

        PhotoStore::delete($photo->path);

        if ($event->cover_image === $photo->path) {
            $next = $event->photos()->where('id', '!=', $photo->id)->first();
            $event->update(['cover_image' => $next?->path]);
        }

        $photo->delete();

        return back()->with('status', (string) d('common.success'));
    }

    /**
     * @param  list<UploadedFile|null>  $files
     */
    private function storeUploadedPhotos(Event $event, array $files): void
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

            if ($event->photos()->count() >= Event::MAX_PHOTOS) {
                break;
            }

            $seen[$fingerprint] = true;
            $path = PhotoStore::store($file, 'events');

            $event->photos()->create([
                'path' => $path,
                'sort_order' => (int) $event->photos()->max('sort_order') + 1,
            ]);

            if (! $event->cover_image) {
                $event->update(['cover_image' => $path]);
            }
        }
    }

    private function syncReplacedCoverPhoto(Event $event, ?string $previousCover, string $coverImage): void
    {
        $photo = is_string($previousCover) && $previousCover !== ''
            ? $event->photos()->where('path', $previousCover)->first()
            : null;

        if ($photo !== null) {
            $photo->update(['path' => $coverImage]);

            return;
        }

        if ($event->photos()->count() < Event::MAX_PHOTOS) {
            $event->photos()->create([
                'path' => $coverImage,
                'sort_order' => 0,
            ]);
        }
    }
}
