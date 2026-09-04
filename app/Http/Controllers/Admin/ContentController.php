<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAboutContentRequest;
use App\Http\Requests\UpdateHomeContentRequest;
use App\Http\Requests\UpdateLegalContentRequest;
use App\Http\Requests\UpdateSiteIdentityRequest;
use App\Models\Faq;
use App\Support\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        return view('admin.content', [
            'faqs' => Faq::query()->orderBy('sort_order')->get(),
            'about' => SiteContent::aboutForm(),
            'homeCopy' => SiteContent::homeForm(),
            'legal' => SiteContent::legalForm(),
            'identity' => SiteContent::identity(),
        ]);
    }

    public function updateAbout(UpdateAboutContentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        SiteContent::saveLocalized('about_vision', 'about', [
            'en' => $validated['vision_en'],
            'si' => $validated['vision_si'],
            'ta' => $validated['vision_ta'],
        ]);
        SiteContent::saveLocalized('about_mission', 'about', [
            'en' => $validated['mission_en'],
            'si' => $validated['mission_si'],
            'ta' => $validated['mission_ta'],
        ]);
        SiteContent::saveLocalized('about_intro', 'about', [
            'en' => $validated['intro_en'],
            'si' => $validated['intro_si'],
            'ta' => $validated['intro_ta'],
        ]);
        SiteContent::saveLocalized('about_objectives', 'about', [
            'en' => $validated['objectives_en'],
            'si' => $validated['objectives_si'],
            'ta' => $validated['objectives_ta'],
        ]);

        return back()->with('status', (string) d('admin.aboutSaved'));
    }

    public function updateHome(UpdateHomeContentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        foreach (SiteContent::homeFields() as $field => $key) {
            SiteContent::saveLocalized($key, 'home', [
                'en' => $validated[$field.'_en'],
                'si' => $validated[$field.'_si'],
                'ta' => $validated[$field.'_ta'],
            ]);
        }

        return back()->with('status', (string) d('admin.homeSaved'));
    }

    public function updateLegal(UpdateLegalContentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        foreach (SiteContent::legalFields() as $field => $key) {
            SiteContent::saveLocalized($key, 'legal', [
                'en' => $validated[$field.'_en'],
                'si' => $validated[$field.'_si'],
                'ta' => $validated[$field.'_ta'],
            ]);
        }

        return back()->with('status', (string) d('admin.legalSaved'));
    }

    public function updateIdentity(UpdateSiteIdentityRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        foreach ([
            'name' => $validated['name'],
            'short_name' => $validated['short_name'],
            'registration_no' => $validated['registration_no'],
            'street' => $validated['street'],
            'locality' => $validated['locality'],
            'region' => $validated['region'],
            'postal_code' => $validated['postal_code'],
            'phone_display' => $validated['phone_display'],
            'hotline_display' => $validated['hotline_display'],
            'email' => $validated['email'],
            'phone' => self::toTel($validated['phone_display']),
            'hotline' => self::toTel($validated['hotline_display']),
            'bank_name' => $validated['bank_name'],
            'bank_branch' => $validated['branch'],
            'bank_account_name' => $validated['account_name'],
            'bank_account_no' => $validated['account_no'],
            'bank_swift' => $validated['swift'] ?? '',
        ] as $key => $value) {
            SiteContent::saveIdentityValue($key, $value);
        }

        $mapQuery = rawurlencode($validated['street'].', '.$validated['locality'].', Sri Lanka');
        SiteContent::saveIdentityValue('map_embed', 'https://www.google.com/maps?q='.$mapQuery.'&output=embed');
        SiteContent::saveIdentityValue('map_link', 'https://www.google.com/maps/search/?api=1&query='.$mapQuery);

        return back()->with('status', (string) d('admin.identitySaved'));
    }

    public function storeFaq(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:50'],
            'question_en' => ['required', 'string', 'max:255'],
            'answer_en' => ['required', 'string'],
        ]);

        Faq::query()->create([
            ...$validated,
            'question_si' => $validated['question_en'],
            'question_ta' => $validated['question_en'],
            'answer_si' => $validated['answer_en'],
            'answer_ta' => $validated['answer_en'],
            'is_published' => true,
            'sort_order' => Faq::query()->count(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroyFaq(string $locale, Faq $faq): RedirectResponse
    {
        $faq->delete();

        return back()->with('status', (string) d('common.success'));
    }

    private static function toTel(string $display): string
    {
        $digits = preg_replace('/\D+/', '', $display) ?? '';

        if (str_starts_with($digits, '0')) {
            return '+94'.substr($digits, 1);
        }

        if (str_starts_with($digits, '94')) {
            return '+'.$digits;
        }

        return $display;
    }
}
