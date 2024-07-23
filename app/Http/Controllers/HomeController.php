<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $title = "beranda";

        return view('back.pages.home', compact('title'));
    }
}
