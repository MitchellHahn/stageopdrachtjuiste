<?php

namespace App\Http\Controllers;

use App\Models\Tarief;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;

use App\Models\User;
use App\Models\UserProfiel;


class UserProfielController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $tarief = \Auth::user()->tarief()->latest()->first();

//        $user->user;

//        dd($tarief);

        return view('layouts.user.MijnProfiel',compact('user','request', 'tarief'))
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
            //table users
            'name' => 'required',
            'tussenvoegsel' => '',
            'achternaam' => 'required',
            'straat' => 'required',
            'huisnummer' => 'required',
            'toevoeging' => '',
            'postcode' => 'required',
            'stad' => 'required',
            'land' => 'required',
            'telefoonnumer' => '',
            'email' => 'required',
            'kvknummer' => 'required',
            'btwnummer' => 'required',
            'ibannummer' => '',
            'bedrijfsnaam' => '',

        ]);

        $user = UserProfiel::create($request->all());

        $user->id = Auth::user()->id;

        $user->save();

        return redirect()->route('BProfiel.index')
            ->with('success', 'user gegevens zijn opgeslagen');

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
     * @param \App\Models\UserProfiel $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(UserProfiel $user)
    {
        return view('layouts.user.functietoevoegen.profiel.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserProfiel $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, UserProfiel $user)
    {
        $request->validate([
            //tabel users
            'name' => 'required',
            'tussenvoegsel' => '',
            'achternaam' => 'required',
            'straat' => 'required',
            'huisnummer' => 'required',
            'toevoeging' => '',
            'postcode' => 'required',
            'stad' => 'required',
            'land' => 'required',
            'telefoonnumer' => '',
            'email' => 'required',
            'kvknummer' => 'required',
            'btwnummer' => 'required',
            'ibannummer' => '',
            'bedrijfsnaam' => '',
            'logo' => 'image|mimes:gif,png,jpg,jpeg|max:2048'
        ]);

        $data = $request->all();

        if($request->logo) {
            $imageName = time().'.'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('/uploads/logos'), $imageName);

            $data["logo"] = $imageName;
        }


//        dd($data);

        $user->update($data);



        return redirect()->route('BProfiel.index')
            ->with('success', 'Gegevens zijn aangepast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\UserProfiel $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(UserProfiel $user)
    {
        $user->delete();

        return redirect()->route('BProfiel.index')
            ->with('success', 'User is verwijderd');

    }
}
