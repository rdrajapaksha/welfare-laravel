<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DigitalIdController extends Controller
{
    public function index(): View
    {
        $member = request()->user()->member;
        abort_if($member === null, 403);

        return view('member.id', ['member' => $member]);
    }
}
