<?php

namespace App\Http\Controllers;

use App\Models\Tijd;
use App\Http\Controllers\TijdController;
use Illuminate\Http\Request;

class FrontController extends Controller

{

    ////////////////////////Nav paginas voor zpper module///////////////

    /**
     * Controler voor (MijnProfiel, IngevoegdeUren, GemaakteFacturen, Toevoegen, Ingediende toeslag) navbar ZZPer
     */

    /**
     * Navbar link voor mijnprofiel pagina
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function MijnProfiel()
    {
        // toont in de front-end de "MijnProfiel" blade
        return view('layouts.user.MijnProfiel');
    }

    /**
     * Navbar link voor Klanten pagina
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function Klanten()
    {
        // toont in de front-end de "Klanten" blade
        return view('layouts.user.Klanten');
    }

    /**
     * Navbar link voor Factuur pagina
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function Factuur()
    {
        // toont in de front-end de "Factuur" blade
        return view('layouts.user.Factuur');
    }

    /**
     * Navbar link voor IngediendeToeslag pagina
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function IngediendeToeslag()
    {
        // toont in de front-end de "IngediendeToeslag" blade
        return view('layouts.user.IngediendeToeslag');
    }


////////////////////////Nav paginas voor mederwker module///////////////
    /**
     * Navbar link voor Profiel pagina
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function Profiel()
    {
        // toont in de front-end de "Profiel" blade
        return view('layouts.admin.Profiel');

    }

    /**
     * Navbar link voor Registratie pagina
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function Registratie()
    {
        // toont in de front-end de "Registratie" blade

        return view('layouts.admin.Registratie');
    }
    /**
     * Navbar link voor Gebruikers pagina
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function Gebruikers()
    {
        // toont in de front-end de "Gebruikers" blade
        return view('layouts.admin.Gebruikers');
    }

    /**
     * Navbar link voor Toeslag pagina
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function Toeslag()
    {
        // toont in de front-end de "toeslagen" blade
        return view('layouts.admin.Toeslagen');
    }

}
