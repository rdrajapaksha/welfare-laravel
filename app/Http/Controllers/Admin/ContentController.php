<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        return view('admin.content', [
            'faqs' => Faq::query()->orderBy('sort_order')->get(),
        ]);
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
}
