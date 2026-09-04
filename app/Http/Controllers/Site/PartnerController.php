<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function __invoke(): View
    {
        return view('site.partners', [
            'partners' => Partner::active()->get()->groupBy('tier'),
        ]);
    }
}
