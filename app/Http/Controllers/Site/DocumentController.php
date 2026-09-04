<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function __invoke(): View
    {
        return view('site.documents', [
            'documents' => Document::published()->where('members_only', false)->get()->groupBy('category'),
        ]);
    }
}
