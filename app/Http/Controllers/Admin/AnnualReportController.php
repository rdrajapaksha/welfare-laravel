<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnualReport;
use App\Support\PhotoStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnualReportController extends Controller
{
    public function index(): View
    {
        return view('admin.reports', [
            'reports' => AnnualReport::query()->orderByDesc('year')->orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:2100', 'unique:annual_reports,year'],
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string', 'max:2000'],
            'file' => PhotoStore::pdfRules(required: true),
            'total_income' => ['required', 'integer', 'min:0'],
            'total_expenditure' => ['required', 'integer', 'min:0'],
            'welfare_spend' => ['nullable', 'integer', 'min:0'],
            'admin_spend' => ['nullable', 'integer', 'min:0'],
        ]);

        $file = $request->file('file');

        AnnualReport::query()->create([
            'year' => $validated['year'],
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_en' => $validated['summary_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'file_url' => PhotoStore::store($file, 'reports'),
            'file_size_kb' => PhotoStore::kilobytes($file),
            'total_income' => $validated['total_income'],
            'total_expenditure' => $validated['total_expenditure'],
            'welfare_spend' => $validated['welfare_spend'] ?? 0,
            'project_spend' => 0,
            'admin_spend' => $validated['admin_spend'] ?? 0,
            'is_published' => true,
            'published_at' => now(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, AnnualReport $report, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:2100', 'unique:annual_reports,year,'.$report->id],
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string', 'max:2000'],
            'file' => PhotoStore::pdfRules(),
            'total_income' => ['required', 'integer', 'min:0'],
            'total_expenditure' => ['required', 'integer', 'min:0'],
            'welfare_spend' => ['nullable', 'integer', 'min:0'],
            'admin_spend' => ['nullable', 'integer', 'min:0'],
        ]);

        $file = $request->file('file');

        $report->update([
            'year' => $validated['year'],
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_en' => $validated['summary_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'file_url' => PhotoStore::store($file, 'reports', $report->file_url),
            'file_size_kb' => $file ? PhotoStore::kilobytes($file) : $report->file_size_kb,
            'total_income' => $validated['total_income'],
            'total_expenditure' => $validated['total_expenditure'],
            'welfare_spend' => $validated['welfare_spend'] ?? 0,
            'admin_spend' => $validated['admin_spend'] ?? 0,
            'is_published' => $request->boolean('is_published'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, AnnualReport $report): RedirectResponse
    {
        PhotoStore::delete($report->file_url);
        $report->delete();

        return back()->with('status', (string) d('common.success'));
    }
}
