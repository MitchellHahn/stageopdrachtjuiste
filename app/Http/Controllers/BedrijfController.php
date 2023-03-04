<?php

namespace App\Http\Controllers;

use App\Models\Bedrijf;
use Auth;
use Illuminate\Http\Request;

class BedrijfController extends Controller
{
    /**
     * Deze functie toont de voorpagina.
     * Dit is een overzicht van alle klanten
     *
     * @return \Illuminate\Http\Response
     */
    public function overzicht_van_alle_klanten()
    {

        // stuur alle klanten dat de ingelogde gebruiker heeft aangemaakt naar pagina "klanten" om het te tonen
        $bedrijven = Bedrijf::where('user_id', \Auth::user()->id)
            ->orderBy('bedrijfsnaam', 'ASC')
            ->get();

        return view('layouts.user.Klanten',compact('bedrijven'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }


    /**
     * Deze functie toont de venster waarin klant geregistreerd kan worden.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function aanmaken()
    {
        // toont de venster waarin de klant (bedrijf) wordt aangemaakt
        return view('layouts.user.functietoevoegen.bedrijf.aanmaken');
    }


    /**
     * Deze functie slaat de ingevoerde gegevens d0at in het klanten aanmaken venster zijn ingevoerd,
     * op in tabel bedrijven van de database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function opslaan(Request $request)
    {
        // haalt de ingevoerd gegevens op en controleert als alle invoer vakken zin ingevuld
        $request->validate([
            //table tijd
            'bedrijfsnaam' => 'required',
            'debnummer' => 'required',
            'straat' => 'required',
            'huisnummer' => 'required',
            'toevoeging' => '',
            'postcode' => 'required',
            'stad' => 'required',
            'land' => 'required',
            'email' => 'required',

            'user_id' => '',
            'contactpersoon' => '',

        ]);

        // maakt via de model "bedrijf" een nieuwe klant aan
        $bedrijf = Bedrijf::create($request->all());

        // vult de "user id" van de gebruiker in de "userd_id" foreign key van tabel bedrijven.
        $bedrijf->user_id = Auth::user()->id;

        // slaat de ingevoerd gegevens op in tabel "bedrijven"
        $bedrijf->save();

        // toon toevoegen begin scherm nadat tijd en toeslagen zijn opgeslagem
        return redirect()->route('Klanten.overzicht_alle_klanten')
            ->with('success', 'Bedrijf is geregistreerd');

    }


    /**
     * Deze functie toont de gegevens van de gekozen klant (bedrijf).
     *
     * @param  \App\Models\Bedrijf  $bedrijf
     * @return \Illuminate\Contracts\View\View
     */
    public function tonen(Bedrijf $bedrijf)
    {
        // stuurt de gegegvens van de gekozen klant (bedrijf) naar de front-end om het te tonen
        $bedrijf = $bedrijf;
        return view('layouts.user.functietoevoegen.bedrijf.tonen', compact('bedrijf'));
    }


    /**
     * Deze functie toont de venster waarin de gekozen klant gewijzigd kan worden.
     *
     * @param  \App\Models\Bedrijf  $bedrijf
     * @return \Illuminate\Contracts\View\View
     */
    // stuurt via de "bedrijf" model de gegevens van de gekozen klant (bedrijf) naar de venster om te tonen
    public function wijzigen(Bedrijf  $bedrijf)
    {
        return view('layouts.user.functietoevoegen.bedrijf.wijzigen', compact('bedrijf'));
    }


    /**
     * Deze functie slaat de gewijzigde gegevens die ingevoerd zijn in de wijzigingsvenster, op ion tabel bedrijven.
     * De nieuwe doorgegeven gegevens vervangen de huidige gegevens
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bedrijf  $bedrijf
     * @return \Illuminate\Http\RedirectResponse
     */
    public function WijzigingOpslaan(Request $request, Bedrijf $bedrijf)
    {
        // haalt de ingevoerd gegevens en cotroleert als alle velden zijn ingevuld
        $request->validate([
            //tabel toeslag
            'bedrijfsnaam' => 'required',
            'debnummer' => 'required',
            'straat' => 'required',
            'huisnummer' => 'required',
            'toevoeging' => '',
            'postcode' => 'required',
            'stad' => 'required',
            'land' => 'required',
            'email' => 'required',
            //   'user_id' => '',
            'contactpersoon' => '',


        ]);

        // vervangt de huidige gegevens met de nieuwe doorgegeven gegevens
        $bedrijf->update($request->all());

        return redirect()->route('Klanten.overzicht_alle_klanten')
            ->with('success', 'Klant info is aangepast');
    }


    /**
     * Deze functie verwijdert de gekozen klant van tabel "bedrijven"
     *
     * @param  \App\Models\Bedrijf  $bedrijf
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verwijderen(Bedrijf  $bedrijf)
    {
        // verwijdert een klant van tabel "bedrijven"
        $bedrijf->delete();

        // toont weer de overzicht van alle klanten
        return redirect()->route('Klanten.overzicht_alle_klanten')
            ->with('success', 'Klant is verwijderd');
    }
}
