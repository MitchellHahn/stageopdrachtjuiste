<?php

namespace App\Http\Controllers;

use App\Models\UserProfiel;
//use Auth;
use Illuminate\Http\Request;

class AdminProfielController extends Controller
{

    /**
     * deze functie haalt alle huidige gegevens op van de ingelogde gebruiker(Brouwers medewerker), van tabel "users"
     * en stuurt het naar de "profiel" pagina (view of balde) om het te tonen
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function overzicht_profiel_gegevens()
    {

        // haalt de huidige gegevens op van de ingelogde gebruiker van tabel "users", via de Auth middleware
        $user = auth()->user();

        // stuurt het naar de "profiel" pagina (view of balde) om het te tonen
        return view('layouts.admin.Profiel',compact('user'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }


    /**
     * deze functie toont de venster (view) waarin de gegevens van tabel user, van de ingelogde gebruiker gewijzigd kunnen worden.
     * deze functie toont ook de huidge gegevens van de ingelogde gebruiker in de "gegevens wijzigen" venster.
     *
     * @param \App\Models\UserProfiel $user
     * @return \Illuminate\Contracts\View\View
     */
    public function gegevens_wijzigen(UserProfiel $user)
    {
        // toont view "wijzigen" waarin de wijzigingen kunnen worden doorgegeven
        return view('layouts.admin.profiel.wijzigen', compact('user'));
    }

    /**
     * deze functie slaat de gewijzigde gegevens van de gebruiker op in tabel user.
     * deze functie vervangt de huidige data met de nieuwe (gewijzigde) data.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserProfiel $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function wijziging_opslaan(Request $request, UserProfiel $user)
    {

        // haalt de data op van elke invoer vak en controleert als ze wel of niet leeg mogen zijn.
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
            'kvknummer' => '',
            'btwnummer' => '',
            'ibannummer' => '',
            'bedrijfsnaam' => '',
            'logo' => 'image|mimes:gif,png,jpg,jpeg|max:2048'

        ]);

        // alle data dat in de invoervaken staan worden opgehaald
        $data = $request->all();

        if($request->logo) {
            $imageName = time().'.'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('/uploads/logos'), $imageName);

            $data["logo"] = $imageName;
        }

        // alle nieuwe ingevoerde gegevens, zal de huidige gegevens van de account van de ingelogde gebruiker vervangen in tabel "users"
        $user->update($data);

        return redirect()->route('AProfiel.profiel')
            ->with('success', 'Gegevens zijn aangepast');
    }
}
