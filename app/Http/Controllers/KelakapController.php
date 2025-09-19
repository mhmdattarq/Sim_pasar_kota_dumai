<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelakapController extends Controller
{
    public function kelakap()
    {
        return view('frontend.pages.kelakap'); //view dari resource/view/home.blade.php
    }
}
