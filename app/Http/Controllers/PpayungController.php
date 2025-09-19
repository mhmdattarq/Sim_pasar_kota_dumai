<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PpayungController extends Controller
{
    public function PP()
    {
        return view('frontend.pages.pulaupayung'); //view dari resource/view/home.blade.php
    }
}
