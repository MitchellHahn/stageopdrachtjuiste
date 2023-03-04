<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\False_;
use function PHPUnit\Framework\isFalse;

class  SessionController
{

    // maakt een sessie aan wanneer er wordt ingelogd
    public function create()
    {
       return view ('sessions.create');
    }

    // inlog controleren
    public function store()
    {
        // ingevoerde inlog gegevens ophalen
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'

        ]);

        // statement uitvoeren als de gebruiker op inloggen heeft gedrukt

        // als de gebruiker met een zpper account inlogt, toont het systeem de home pagina van de zpper mpdule
        if (auth()->attempt($attributes)){
            if(auth()->user()->account_type == 1) {
                return redirect('user/')->with('welcome','you do have admin access');

            // als de gebruiker met een b-medewerkers account inlogt, toont het systeem de home pagina van de zpper mpdule
            } else {
                return redirect('user/bprofiel')->with('','');

            }

            //  fout melding tonen als er met de verkeerde gegevens zijn ingelogd
            return back()
                ->withInput()
                ->withErrors(['email' => 'your provided credentials could not be verified']);

        }}


        // verbinding verbreken wanneer er wordt uitgelogd
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('sucess','Goodbye');
    }

}
