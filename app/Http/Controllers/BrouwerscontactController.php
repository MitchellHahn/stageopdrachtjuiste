<?php

namespace App\Http\Controllers;

use App\Models\Brouwerscontact;
use Illuminate\Http\Request;

class BrouwerscontactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Brouwerscontact $brouwerscontact
     * @return \Illuminate\Http\Response
     */
    public function edit(Brouwerscontact $brouwerscontact)
    {

        return view('layouts.user.functietoevoegen.factuur.result', compact('brouwerscontact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brouwerscontact $brouwerscontact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Brouwerscontact $brouwerscontact)
    {
        $request->validate([
            //tabel brouwerscontacten
            'email' => 'required',
            //   'user_id' => '',

        ]);

//        Auth::user()->brouwerscontact->id;
        $brouwerscontact->update($request->all());

        return redirect()->route('Factuuremail.update')
            ->with('success', 'Brouwers contact info is aangepast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brouwerscontact  $brouwerscontact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Brouwerscontact  $brouwerscontact)
    {
        $brouwerscontact->delete();

        return redirect()->route('Factuuremail.destroy')
            ->with('success', 'Brouwers contact info is verwijderd');
    }
}
