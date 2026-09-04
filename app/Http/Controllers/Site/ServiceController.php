<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->string('category')->toString();

        $programmes = Programme::active()
            ->when($category !== '', fn ($query) => $query->where('category', $category))
            ->get();

        return view('site.services.index', [
            'programmes' => $programmes,
            'category' => $category,
        ]);
    }

    public function show(string $locale, Programme $programme): View
    {
        abort_unless($programme->is_active, 404);

        return view('site.services.show', [
            'programme' => $programme,
            'related' => Programme::active()->where('id', '!=', $programme->id)->take(3)->get(),
        ]);
    }
}
