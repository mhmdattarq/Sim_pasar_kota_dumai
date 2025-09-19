<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function tarif()
    {
        return view('frontend.pages.tarif'); //view dari resource/view/home.blade.php
    }
}
