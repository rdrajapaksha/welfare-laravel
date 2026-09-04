<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsletterRequest;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;

class NewsletterController extends Controller
{
    public function store(StoreNewsletterRequest $request): RedirectResponse
    {
        $subscriber = Subscriber::query()->firstOrNew(['email' => $request->string('email')->toString()]);

        if ($subscriber->exists && $subscriber->unsubscribed_at === null) {
            return back()->with('status', (string) d('footer.newsletterExists'));
        }

        $subscriber->fill([
            'locale' => app()->getLocale(),
            'is_confirmed' => true,
            'unsubscribed_at' => null,
        ])->save();

        return back()->with('status', (string) d('footer.newsletterSuccess'));
    }
}
