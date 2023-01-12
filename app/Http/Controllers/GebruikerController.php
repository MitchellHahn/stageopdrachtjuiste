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

/////////////////VOOR TOESLAGEN/////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function toeslagenindex(Request $request, User $user)
    {

        $users = User::orderBy('name', 'ASC')
            ->where('account_type', '0')
            ->paginate(1000);

        return view('layouts.admin.Toeslagen',compact('request','users', 'user'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }

    /**
     * Show the form for creating a new resource.
     * @param  \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function createtoeslag(User $user)
    {
//        dd($user->id);
        return view('layouts.admin.toeslagen.create',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @param  \App\Models\Toeslag $toeslag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toeslagenuserstore(Request $request, User $user, Toeslag $toeslag)
    {

        $request->validate([
            //tabel users
            'datum' => '',
            'toeslagbegintijd' => 'required',
            'toeslageindtijd' => 'required',
            'toeslagsoort' => '',
//            'soort' => 'required',
            'toeslagpercentage' => 'required',
            'soort' => 'required',

//            'tarief_id' => '',
            'user_id' => '',
//            'account_type' => 'required',

        ]);

        $toeslag = Toeslag::create($request->all());

        $toeslag->user_id = $user->id;

        $toeslag->save();

        return redirect()->route('Toeslagen.index',compact('toeslag', 'user'))
            ->with('success', 'Gegevens zijn aangepast');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toeslagenuserupdate(Request $request, User $user)
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
//            'account_type' => 'required',

        ]);

        $user->update($request->all());

        return redirect()->route('Gebruikers.index')
            ->with('success', 'Gegevens zijn aangepast');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Toeslag $toeslag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toeslagenuserdestroy(Toeslag $toeslag)
    {
        $toeslag->delete();

        return redirect()->route('Toeslagen.destroy')
            ->with('success', 'Uren en toeslag zijn verwijderd');

    }
}
