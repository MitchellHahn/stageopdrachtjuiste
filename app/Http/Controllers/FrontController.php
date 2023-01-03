<?php

namespace App\Http\Controllers;

use App\Models\Tijd;
use App\Http\Controllers\TijdController;
use Illuminate\Http\Request;

class FrontController extends Controller

{

    /**
     * Controler voor (MijnProfiel, IngevoegdeUren, GemaakteFacturen, Toevoegen, Ingediende toeslag) navbar ZZPer
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function MijnProfiel()
    {
        return view('layouts.user.MijnProfiel');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function Klanten()
    {
        return view('layouts.user.Klanten');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function Factuur()
    {
        return view('layouts.user.Factuur');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function IngediendeToeslag()
    {
        return view('layouts.user.IngediendeToeslag');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

/**  public function Toevoegen()
    {
        ///mischeien verwijderen
        $tijden = Tijd::latest()->paginate(5);

        return view('layouts.user.Toevoegen',compact('tijden'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }*/

////////////////////////Nav paginas voor zpp admin///////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function Profiel()
    {
//        $user = auth()->user();

//        return view('layouts.admin.Profiel',compact('user'))
//            ->with('i', (request()->input('page', 1) - 1) * 4);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function Registratie()
    {
        return view('layouts.admin.Registratie');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function Gebruikers()
    {
        return view('layouts.admin.Gebruikers');
    }

}
