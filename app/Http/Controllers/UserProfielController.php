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
     * deze functie haalt de huidige gegevens op van de inggelogde gebruiker (zpper), van tabel "user".
     * de gegevens worden naar de "MijnProfiel" venster gestuurd om het te tonen.
     * dit zijn NAW gegevens, e-mail, telefoonnummer, kvknummer, btw-nummer, ibannummer, en bedrijfsnaam van tabel "user".
     * deze functie haalt ook de laatste ingediende uurtarief van de zpper in tabel "tarieven" op en stuurt het naar de "MijnProfiel" venster om het te tonen.
     *
     * @return \Illuminate\Http\Response
     */
    public function overzicht_profiel_gegevens(Request $request)
    {
        // haat de gegevens van de ingelogde gebruiker op
        $user = auth()->user();

        // haalt de laatste ingediende uurtatrief van ingelogde zpper op, van tabel "tarieven"
        $tarief = \Auth::user()->tarief()->latest()->first();

        // stuurt de opgehaalde data naar de "MijnProfiel" pagina (view of balde) om het te kunnen tonen
        return view('layouts.user.MijnProfiel',compact('user','request', 'tarief'))
            ->with('i', (request()->input('page', 1) - 1) * 4);

    }



    /**
     * deze functie toont de venster (view) waarin de gegevens van tabel user, van de ingelogde gebruiker(zpper) gewijzigd kunnen worden.
     * deze functie toont ook de huidige gegevens van de ingelogde gebruiker (zpper) in de "gegevens wijzigen" venster.
     *
     * @param \App\Models\UserProfiel $user
     * @return \Illuminate\Contracts\View\View
     */

    // haalt de gegevens op van de ingelogde gebruiker, via de "UserProfiel" model
    public function wijzigen(UserProfiel $user)
    {
        // opent de view "wijzigen" en stuurt de huidige gegevens van de ingelogde gebruiker naar view zodat het getoond kan worden.
        return view('layouts.user.functietoevoegen.profiel.wijzigen', compact('user'));
    }



    /**
     * deze functie slaat de gewijzigde gegevens van de gebruiker op in tabel "user".
     * deze functie vervangt de huidige data met de nieuwe (gewijzigde) data.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserProfiel $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function WijzigingOpslaan(Request $request, UserProfiel $user)
    {
        // haalt de ingevoerde data op van elke invoervak en controleert als ze wel of niet leeg mogen zijn.
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

        // alle data dat in de invoervaken staan worden opgehaald
        $data = $request->all();

        // de folder van de code waarin de logo of profiel foto wordt opgeslagen
        if($request->logo) {
            $imageName = time().'.'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('/uploads/logos'), $imageName);

            $data["logo"] = $imageName;
        }

        // alle nieuwe ingevoerde gegevens, zal de huidige gegevens van de account van de ingelogde gebruiker (zpper) vervangen in tabel "users"
        $user->update($data);

        // redirect de gebruiker terug naar de mijn profiel pagina als de gegevens zijn gewijzigd
        return redirect()->route('BProfiel.overzicht_profiel_gegevens')
            ->with('success', 'Gegevens zijn aangepast');
    }

}
