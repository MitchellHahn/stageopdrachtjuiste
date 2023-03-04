<?php

namespace App\Http\Controllers;

use App\Http\Middleware\User;
use App\Models\Toeslag;
use Auth;
use Illuminate\Http\Request;
use App\Models\Tarief;

class TariefController extends Controller
{

    /**
     * deze functie toont de meeste recente uurtarief van de gebruiker
     * dit is de laatste uurtarief van de zpper in tabel "tarieven"
     *
     * @param  \App\Models\Tarief  $tarief
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    // gebruiket via eleqount in de "Model" om de tarieven van de zpper te vinden
    public function meest_recente_uurtarief_tonen(Request $request, User $user)
    {

        // stuurt de laatste registreerde uurtarief naar de frontend "profiel pagina" om het te tonen
        $tarief = \Auth::user()->tarief()->latest();


        return view('layouts.user.MijnProfiel',compact('user','request', 'tarief' ))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }


    /**
     * deze functie toont de venster waarin de uurtarief wordt aangemaakt.
     * hierin wordt ook de meest recente uurtarief getoont.
     *
     * @param  \App\Models\Tarief $tarief
     * @return \Illuminate\Http\Response
     */
    public function aanmaken(Tarief $tarief)
    {

        //toont de laatste geregistreerde tarief in de venster ("tarief aanmaken" venster)  waat een nieuwe tarief wordt aangemaakt
        $tarief = \Auth::user()->tarief()->latest()->first();


        return view('layouts.user.functietoevoegen.tarief.aanmaken', compact('tarief'));
    }




    /**
     * deze functie slaat de doorgeven bedrag van de uurtarief op in tabel "tarieven".
     * hier wordt de "id" van de ingelogde gebruiker ook opgeslagen in gemaakte uurtarief.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function opslaan(Request $request)
    {
       // haalt de data van de ingevulde ingevulde tarief op
        $request->validate([
            //table tijd
            'bedrag' => 'required',
            'user_id' => '',

        ]);

        // via de model "tarief" wordt er een traief aangemaakt van ingevoerde gegevens
        $tarief = Tarief::create($request->all());

        // pakt de "userid" van de ingelogde gebruiker en vult in, in de "user_id" vreemde sleutel van de gemaakt tarief
        $tarief->user_id = Auth::user()->id;

        // slaat de gemaakte tarief op in tabel "tarieven"
        $tarief->save();

        return redirect()->route('BProfiel.overzicht_profiel_gegevens')
            ->with('success','Tarief is aangepast');
    }

}
