<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComingSoonController extends Controller
{
    public function CS()
    {
        return view('backend_pedagang.pages.comingsoon'); //view dari resource/view/home.blade.php
    }
}
