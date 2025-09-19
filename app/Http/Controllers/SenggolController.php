<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SenggolController extends Controller
{
    public function senggol()
    {
        return view('frontend.pages.senggol'); //view dari resource/view/home.blade.php
    }
}
