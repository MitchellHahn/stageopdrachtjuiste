<?php

namespace App\Http\Controllers;

use App\Models\Tijd;
use App\Models\User;
use App\Models\UserProfiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Auth;


class GebruikerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

//        $gebruiker = (user()->account_type == 0);
//        $admin = (user()->account_type == 1);

  //      $user = 0;



//        if $users = User::$account_type = value('0');
//        else


        $users = User::orderBy('name', 'ASC')->paginate(1000);

        return view('layouts.admin.Gebruikers',compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 4);


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
        $request->validate([
            //table tijd
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

        User::create($request->all());

        return redirect()->route('Gebruikers.index')
            ->with('success','gegevens zijn aangepast');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        return view('layouts.admin.gebruikers.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        return view('layouts.admin.gebruikers.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
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

        $user->update($request->all());

        return redirect()->route('Gebruikers.index')
            ->with('success', 'Gegevens zijn aangepast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('Gebruikers.index')
            ->with('success','Gebruiker verwijderd');

    }

    /**
     * impersonate user
     *
     * @return \Illuminate\Http\Response
     */
    public function impersonate($id)
    {
        $user = User::find($id);
        Auth::user()->impersonate($user);

        return redirect()->route('BProfiel.index')
            ->with('success','gebruiker overgenomen');

    }

    /**
     * impersonate user
     *
     * @return \Illuminate\Http\Response
     */
    public function impersonate_leave()
    {
        Auth::user()->leaveImpersonation();

        return redirect()->route('Gebruikers.index')
            ->with('success','uitgelogd van gebruiker');

    }


}
