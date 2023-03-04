<?php

namespace App\Http\Controllers;

use App\Models\Tijd;
use App\Models\Toeslag;
use App\Models\User;
use App\Models\UserProfiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Auth;


class GebruikerController extends Controller
{

///////////////////////functies voor gebruikers pagina van medewerker module///////////////////////

    /**
     * deze functie haalt alle gebruikers en administrators op van tabel "users"
     * toont via de "gebruikers" view (blade) alle gebruikers en administrators op van tabel "users"
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function overzicht_van_alle_gebruikers()
    {

        // toont via de "User" model, alle gebruikers en administrators van tabel users
        // sorteert alle gebruikers en administrators op alphabetische volgorde
        $users = User::orderBy('name', 'ASC')->paginate(1000);

        return view('layouts.admin.Gebruikers',compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }



    /**
     * deze functie toont de huidigegevens van de geselecteerde gebruiker via de "tonen" view (blade)
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    // via de model "User" stuurt deze functie alle gegevens van de geselecteerde gebruiker die in tabel user staat
    public function gegevens_tonen(User $user)
    {
        // toont view (blade) "tonen" om de huidige gegevens van de geselecteerde gebruiker te bekijken
        return view('layouts.admin.gebruikers.tonen',compact('user'));
    }


    /**
     * deze functie toont de venster (view) waarin de gegevens van tabel "user", van de geselecteerde gebruiker of administrator gewijzigd kunnen worden.
     * deze functie toont ook de huidige gegevens van de geselecteerde gebruiker of administrator in de "gegevens wijzigen" venster
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function gegevens_wijzigen(User $user)
    {
        // toont view "wijzigen" waarin de wijzigingen van de gebruikers gegevens kunnen worden doorgegeven
        return view('layouts.admin.gebruikers.wijzigen',compact('user'));
    }



    /**
     * deze functie slaat de gewijzigde gegevens van de gelecteerde gebruiker of administrator op in tabel user.
     * deze functie vervangt de huidige data met de nieuwe (gewijzigde) data.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function wijziging_opslaan(Request $request, User $user)
    {
        // haalt de data op van elke invoer vak en controleert als ze wel of niet leeg mogen zijn.
        $request->validate([
            //tabel users
            'name' => 'required',
            'tussenvoegsel' => '',
            'achternaam' => 'required',
            'straat' => 'required',
            'huisnummer' => 'required',
            'toevoeging' => 'required',
            'postcode' => 'required',
            'stad' => 'required',
            'land' => 'required',
            'telefoonnumer' => '',
            'email' => 'required',
            'account_type' => 'required',

        ]);

        // alle data dat in de invoervaken staan worden opgehaald
        // alle nieuwe ingevoerde gegevens, zal de huidige gegevens van de geselecteerde gebruiker of administrator vervangen
        $user->update($request->all());

        return redirect()->route('Gebruikers.overzicht')
            ->with('success', 'Gegevens zijn aangepast');
    }


    /**
     * deze functie verwijdert de gelecteerde gebruiker of administrator van tabel "user"
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    // maakt gebruik van model "user"
    public function gebruiker_verwijderen(User $user)
    {
        // verwijdert de gelecteerde gebruiker of administrator
        $user->delete();

        return redirect()->route('Gebruikers.overzicht')
            ->with('success','Gebruiker verwijderd');

    }


    /**
     * deze functie neemt de account over van de geselecteerde zppers (standaard gebruikers account)
     *
     * @return \Illuminate\Http\Response
     */
    public function gebruiker_overnemen($id)
    {
       // zoekt via mia de model "User" naar de account van de geselecteerde gebruiker
        $user = User::find($id);

       // neemt de account van de geselecteerde gebruiker over via de impersonate functie van de "AUTH" middleware.
        Auth::user()->impersonate($user);

       // redirect naar de profiel pagina van de zpper als de account is overgenomen.
        return redirect()->route('BProfiel.overzicht_profiel_gegevens')
            ->with('success','gebruiker overgenomen');

    }


    /**
     * deze functie verbreekt de verbinding van de overname van geselecteerde zppers (standaard gebruikers account)
     *
     * @return \Illuminate\Http\Response
     */
    public function overname_stoppen()
    {
        // verbreekt de verbinding van de overname van de geselecteerde gebruiker, via de leaveImpersonation functie van de "AUTH" middleware.
        Auth::user()->leaveImpersonation();

        // redirect naar de pagina "gebruikers" van de medewerkers module nadat de overname is verbroken.
        return redirect()->route('Gebruikers.overzicht')
            ->with('success','uitgelogd van gebruiker');

    }


///////////////////////functies voor toeslag pagina van medewerker module///////////////////////

    /**
     * deze functie toont via de "toeslagen" pagina van de medewerkers module, een overzicht van alle zppers
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function overzicht_van_alle_zppers(Request $request, User $user)
    {

        // toont via de "User" model, alleen zppers (gebruikers dat "0" hebben als account_type)
        // sorteert de namen van alle zppers op alphabetische volgorde
        $users = User::orderBy('name', 'ASC')
            ->where('account_type', '0')
            ->paginate(1000);

        return view('layouts.admin.Toeslagen',compact('request','users', 'user'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }


    /**
     * deze functie toont de venster waarin de toeslagen voor zppers kunnen worden aangemaakt
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function toeslagaanmaken(User $user)
    {
        // de knop "aanmaken" wordt gedrukt, wordt de view (blade) "aanmaken" getoond
        return view('layouts.admin.toeslagen.aanmaken',compact('user'));
    }


    /**
     * deze functie registreert een toeslag aan een zpper.
     * Maakt een nieuwe rij aan in tabel "toeslagen".
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @param  \App\Models\Toeslag $toeslag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function gebruikerstoeslagopslaan(Request $request, User $user, Toeslag $toeslag)
    {

        // haalt de ingevulde data op van alle invoer vakken van de "toeslag aanmaken" venster
        // controleert als de "required" vakken ingevuld zijn
        $request->validate([
            //tabel toeslagen
            'datum' => '',
            'toeslagbegintijd' => 'required',
            'toeslageindtijd' => 'required',
            'toeslagsoort' => '',
            'toeslagpercentage' => 'required',
            'soort' => 'required',

            'user_id' => '',

        ]);

        // maakt een nieuwe toeslag aan van de doorgeven gegevens
        $toeslag = Toeslag::create($request->all());

        // voegt de id van de ingelogd zpper automatisch in de "user_id" vreemde sleutel van tabel "toeslagen"
        $toeslag->user_id = $user->id;

        // slaat de nieuwe toeslag op met de doorgegeven gegevens op in table "toeslagen"
        // maakt gebruik van de model "Toeslag"
        $toeslag->save();

        // als de toeslag is geregistreerd, redirect het systeem weer naar de "toeslag" pagina van de medewerkers module (Toeslagen.blade.php)
        return redirect()->route('Toeslagen.zppers',compact('toeslag', 'user'))
            ->with('success', 'Gegevens zijn aangepast');
    }

}
