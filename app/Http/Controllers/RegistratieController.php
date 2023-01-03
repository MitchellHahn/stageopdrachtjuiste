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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('layouts.admin.Registratie');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
//       return view('layouts.admin.Registratie');

    }

//    public function sendInvite(Request $request): RedirectResponse {
//        $validated = $request->validate([
//            'name' => ['required', 'string', 'max:120'],
//            'email' => ['required', 'string', 'email:rfc,dns', 'unique:'.User::class],
//            'standnr' => ['nullable', 'max:10', 'unique:'.Exhibitor::class],
//        ]);
//
//        $exhibitor = new Exhibitor();
//        $exhibitor->name = $validated['name'];
//        $exhibitor->standnr = $validated['standnr'] ?? null;
//        $exhibitor->save();
//
//        $user = new User();
//        $user->email = $validated['email'];
//        $user->generateInviteToken();
//
//        $exhibitor->user()->save($user);
//
//        $user->notify(new InviteNotification());
//
//        return Redirect::route('admin.exhibitors.index');
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
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

        $user = User::create($request->all());

     // $user->id = Auth::user()->id;

        $user->save();

        Password::sendResetLink($request->only(['email']));


        return redirect()->route('Registratie.index')
            ->with('success', 'gebruiker is aangemaakt');
//        return view('layouts.admin.Registratie');

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
