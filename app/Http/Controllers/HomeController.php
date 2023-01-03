<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * controler voor home van admin en gebruiker
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('sessions.home');
    }

    public function admin()
    {
        return view('sessions.admin');
    }

}
