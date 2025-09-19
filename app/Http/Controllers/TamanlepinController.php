<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TamanlepinController extends Controller
{
    public function TL()
    {
        return view('frontend.pages.tamanlepin'); //view dari resource/view/home.blade.php
    }
}
