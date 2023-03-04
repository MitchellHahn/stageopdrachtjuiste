<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\InviteNotification;
use Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class RegistratieController extends Controller
{



    /**
     * deze functie toont de registratie forumulier (pagina 'registratie') waarin accounts kunnn worden aangemaakt
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function registratie_formulier()
    {
      // toont de view (blade bestand) "registratie"
        return view('layouts.admin.Registratie');
    }


    /**
     * deze functie slaat de ingevoerde gegevens van de registratie formulier (pagina registratie van de medewerkers module) op in tabel user.
     * deze functie maakt een gebruikers of administrators account aan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function gebruiker_registreren(Request $request)
    {
        // de gegevens van alle invoervakken ophalen en ook contoleren als ze wel of niet zijn ingevuld
        $request->validate([
            //table users
            'name' => 'required',
            'tussenvoegsel' => '',
            'achternaam' => '',
            'straat' => '',
            'huisnummer' => '',
            'toevoeging' => '',
            'postcode' => '',
            'stad' => '',
            'land' => '',
            'telefoonnumer' => '',
            'email' => 'required',
            'account_type' => 'required',
            'password' => '',

        ]);

        // nieuwe gebruiker aanmaken en met de ingevoerd gegevens erbij
        // hier wordt model "User" gebruikt
        $user = User::create($request->all());

        // slaat de nieuwe gebruiker met de ingevoerd gegevens op in tabel "user" van de database
        $user->save();

        // stuurt een link naar de ingevoerd e-mailadres om hun wachtwoord te resetten en account bevestigen.
        Password::sendResetLink($request->only(['email']));


        return redirect()->route('Registratie.registratie_formulier')
            ->with('success', 'gebruiker is aangemaakt');

    }

}
