<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegulasiController extends Controller
{
    public function regulasi()
    {
        return view('frontend.pages.regulasi'); //view dari resource/view/home.blade.php
    }
}
