<?php

namespace App\Http\Controllers;

use App\Models\Bedrijf;
use Auth;
use Illuminate\Http\Request;

class BedrijfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return view('layouts.user.Bedrijven');

//        $bedrijven = auth()->user()->bedrijven;

        $bedrijven = Bedrijf::where('user_id', \Auth::user()?->id)
            ->orderBy('bedrijfsnaam', 'ASC')
            ->get();


        return view('layouts.user.Klanten',compact('bedrijven'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('layouts.user.functietoevoegen.bedrijf.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
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

        $bedrijf = Bedrijf::create($request->all());

        $bedrijf->user_id = Auth::user()->id;

        $bedrijf->save();

        ///// toon toevoegen begin scherm nadat tijd en toeslagen zijn opgeslagem
        return redirect()->route('Klanten.index')
            ->with('success', 'Bedrijf is geregistreerd');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bedrijf  $bedrijf
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Bedrijf $bedrijf)
    {
        $bedrijf = $bedrijf;
        return view('layouts.user.functietoevoegen.bedrijf.show', compact('bedrijf'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bedrijf  $bedrijf
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Bedrijf  $bedrijf)
    {
        return view('layouts.user.functietoevoegen.bedrijf.edit', compact('bedrijf'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bedrijf  $bedrijf
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Bedrijf $bedrijf)
    {
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

        $bedrijf->update($request->all());

        return redirect()->route('Klanten.index')
            ->with('success', 'Klant info is aangepast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bedrijf  $bedrijf
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Bedrijf  $bedrijf)
    {
        $bedrijf->delete();

        return redirect()->route('Klanten.index')
            ->with('success', 'Klant is verwijderd');
    }
}
