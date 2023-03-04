<?php


namespace App\Http\Controllers;

use App\Models\Tarief;
use App\Models\Tijd;
use App\Models\User;
use App\Models\Toeslag;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;

class ToeslagController extends Controller
{

    /**
     *
     * deze functie toont alle toeslagen gegevens op van de ingelogde gebruiker(Brouwers medewerker), van tabel "users".
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function overzicht_van_alle_toeslagen_van_zpper()
    {

$toeslagen = Toeslag::where('user_id', \Auth::user()->id)
    ->orderBy('id', 'DESC')
    ->get();

      //aantal uren tonen per toeslag
        foreach ($toeslagen as $toeslag){
            $starttoe = new Carbon($toeslag->toeslagbegintijd);
            $endtoe = new Carbon($toeslag->toeslageindtijd);

            $toeslag->toeslaguren = $starttoe->diffInHours($endtoe);
        }

        return view('layouts.user.IngediendeToeslag', compact('toeslagen','toeslag'))
            ->with('i', (request()->input('page', 1) - 1) * 4);

    }

}
