<?php

namespace App\Http\Controllers;

use App\Models\Bedrijf;
use App\Models\Tarief;
use App\Models\Tijd;
use App\Models\User;
use App\Models\Toeslag;
use App\Models\Feestdag;
use Carbon\Carbon;
use DASPRiD\EnumTest\WeekDay;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;

class TijdController extends Controller
{

    /**
     * Deze functie toont de uren of gewerkte dagen dat de zpper heeft ingediend
     *
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function overzicht_van_alle_gewerkte_dagen_van_zpper()
    {

        ////toont de uren de dat zpper heeft ingediend, in een lijst (van oudste naar neiuweste datum)///
        $tijden = Tijd::where('user_id', \Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->get();

        //////toont het klant (bedrijf) van elke gewerkte dag/////
        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();

        ////berekent en toont de totaal uren van elke gewerkte dag///
foreach ($tijden as $tijd){
        $start = new Carbon($tijd->begintijd);
        $end = new Carbon($tijd->eindtijd);

        $tijd->uren = $start->diffInHours($end);
    }

        return view('layouts.user.UrenToevoegen',compact('tijden', 'bedrijven'))
           ->with('i', (request()->input('page', 1) - 1) * 4);
    }


    /**
     * Deze functie toont het venster waarin er een gewerkte dag of uren wordt geregistreerd.
     *
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Contracts\View\View
     */
    //maakt gebruikt van model "tijd"
    public function aanmaken(Tijd $tijd)
    {

        // stuurt alle klanten (bedrijven) dat zpper heeft geregistreerd mee, zodat ze geselecteerd kunnen worden wanneer de
        // gewerkte dag wordt aangemaakt
        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();

        return view('layouts.user.functietoevoegen.aanmaken', compact('bedrijven'));
    }


    /**
     * Deze functie slaat ingegvulde gegevens van de gewerkte dag op in tabel "tijden".
     * Deze detecteerd en selecteert automatisch de juiste toeslag dat gekoppelt moet worden, en vult het in de "toeslag_idochtend", "toeslag_idavond", "toeslag_idnacht" vreemde sleutel
     * Deze functie vult ook automtiasch de "user_id" en "bedrijf_id" vreemde sleutel in
     *
    *@param  \App\Models\Toeslag $toeslag
    *@param  \App\Models\Feestdag $feestdag
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function opslaan(Request $request, Toeslag $toeslag, Feestdag $feestdag)
    {
        // controleert als alle invoervakken zijn ingevuld
        // haalt ook de ingevuld gegevens op
        $request->validate([
            //table tijd
            'begintijd' => 'required',
            'eindtijd' => 'required',
            'toeslag_idochtend' => '',
            'toeslag_idavond' => '',
            'toeslag_idnacht' => '',
            'datum' => 'required',
            'user_id' => '',
            'bedrijf_id' => 'required',

        ]);

        // via model "Tijd" wordt alvast een werkte dag aangemaakt
        $tijd = Tijd::create($request->all());



///////////////code om de juiste toeslag_id automatisch op te slaan wanneer er een tijd wordt registreert (automatisering)///////////

        // carbon voor doorgegeven datum, zodat het kan worden gebruikt
        $datum = new Carbon($tijd->datum);

        // alle geregistreerde feestdagen ophalen zodat de functie weet wat de vakantie dagen zijn.
        $feestdagen = Feestdag::all('datum')->pluck('datum')->toArray();

        // carbon voor het doorgegeven begin en eindtijd van het dag, zodat het kan worden gebruikt
        $dagbegintijd = new Carbon($tijd->begintijd);
        $dageindtijd = new Carbon($tijd->eindtijd);


        /////////////////////////////////////weekdag en weektoeslagen/////////////////////////////
/////id, begintijd en eindtijd van de meest recente week toeslagen ophalen/////
        // van de meeste recente toeslagen (ochtend, avond en nacht) van een weekdag, de "begintijd" ophalen
        $toeslagweekochtendbegintijd = Toeslag::where('soort', '1')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;
        $toeslagweekavondbegintijd = Toeslag::where('soort', '2')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;
        $toeslagweeknachtbegintijd = Toeslag::where('soort', '3')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;

        // van de meeste recente toeslagen (ochtend, avond en nacht) van een weekdag, de "eindtijd" ophalen
        $toeslagweekochtendeindtijd = Toeslag::where('soort', '1')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;
        $toeslagweekavondeindtijd = Toeslag::where('soort', '2')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;
        $toeslagweeknachteindtijd = Toeslag::where('soort', '3')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;

        // van de meeste recente toeslagen (ochtend, avond en nacht) van een weekdag, de "id" ophalen
        $toeslagweekochtendid = Toeslag::where('soort', '1')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweekavondid = Toeslag::where('soort', '2')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweeknachtid = Toeslag::where('soort', '3')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;


/////als geregistreerde "begintijd" van weektoeslag binnen de begintijd en eindtijd van de doorgegeven weekdag valt./////
        // carbon voor het begintijd van de ochtendtoeslag, avondtoesslag en nachttoeslag van een weekdag, zodat het gebruikt kan worden
        $carbontoeslagweekochtendbegintijd = new Carbon($toeslagweekochtendbegintijd);
        $carbontoeslagweekavondbegintijd = new Carbon($toeslagweekavondbegintijd);
        $carbontoeslagweeknachtbegintijd = new Carbon($toeslagweeknachtbegintijd);

        // conditie maken voor: als de begintijd van de ochtendtoeslag, avondtoeslag en nachttoeslag van een weekdag, binnen de begintijd en eindtijd van de doorgegeven dag ligt.
        $weekochtendbegin = $carbontoeslagweekochtendbegintijd->isBetween($dagbegintijd, $dageindtijd);
        $weekavondbegin = $carbontoeslagweekavondbegintijd->isBetween($dagbegintijd, $dageindtijd);
        $weeknachtbegin = $carbontoeslagweeknachtbegintijd->isBetween($dagbegintijd, $dageindtijd);

////als geregistreerde "eindtijd" van de toeslag binnen de tijd week valt. eindtijd van weektoeslag////
        // carbon voor het eindtijd van de ochtendtoeslag, avondtoesslag en nachttoeslag van een weekdag, zodat het gebruikt kan worden
        $carbontoeslagweekochtendeindtijd = new Carbon($toeslagweekochtendeindtijd);
        $carbontoeslagweekavondeindtijd = new Carbon($toeslagweekavondeindtijd);
        $carbontoeslagweeknachteindtijd = new Carbon($toeslagweeknachteindtijd);

        // conditie maken voor: als de eindtijd van de ochtendtoeslag, avondtoeslag en nachttoeslag van een weekdag, binnen de begintijd en eindtijd van de doorgegeven dag ligt.
        $weekochtendeind = $carbontoeslagweekochtendeindtijd->isBetween($dagbegintijd, $dageindtijd);
        $weekavondeind = $carbontoeslagweekavondeindtijd->isBetween($dagbegintijd, $dageindtijd);
        $weeknachteind = $carbontoeslagweeknachteindtijd->isBetween($dagbegintijd, $dageindtijd);

////conditie maken voor: als geregistreerde begintijd van de doorgegeven dag binnen de begintijd en eindtijd van de weektoeslagen valt/////
        $weekochtendbegintijd = $dagbegintijd->isBetween($carbontoeslagweekochtendbegintijd, $carbontoeslagweekochtendeindtijd);
        $weekavondbegintijd = $dagbegintijd->isBetween($carbontoeslagweekavondbegintijd, $carbontoeslagweekavondeindtijd);
        $weeknachtbegintijd = $dagbegintijd->isBetween($carbontoeslagweeknachtbegintijd, $carbontoeslagweeknachteindtijd);


        ////////////////////////////weekenddag en weekendtoeslagen//////////////////////////
////id, begintijd en eindtijd van de meest recente weekend toeslagen ophalen/////
        // van de meest recente toeslagen (ochtend, avond en nacht) voor een weekenddag, de begintijd ophalen
        $toeslagweekendochtendbegintijd = Toeslag::where('soort', '4')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;
        $toeslagweekendavondbegintijd = Toeslag::where('soort', '5')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;
        $toeslagweekendnachtbegintijd = Toeslag::where('soort', '6')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;

        // van de meest recente toeslagen (ochtend, avond en nacht) voor een weekenddag, de eindtijd ophalen
        $toeslagweekendochtendeindtijd = Toeslag::where('soort', '4')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;
        $toeslagweekendavondeindtijd = Toeslag::where('soort', '5')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;
        $toeslagweekendnachteindtijd = Toeslag::where('soort', '6')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;

        // van de meest recente toeslagen (ochtend, avond en nacht) voor een weekenddag, de "id" ophalen
        $toeslagweekendochtendid = Toeslag::where('soort', '4')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweekendavondid = Toeslag::where('soort', '5')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweekendnachtid = Toeslag::where('soort', '6')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;


/////als geregistreerde begintijd van weekendtoeslag binnen de tijd weekend valt. begintijd van weekend toeslag////
        // carbon voor het "begintijd" van de ochtendtoeslag, avondtoesslag en nachttoeslag van een weekenddag, zodat het gebruikt kan worden
        $carbontoeslagweekendochtendbegintijd = new Carbon($toeslagweekendochtendbegintijd);
        $carbontoeslagweekendavondbegintijd = new Carbon($toeslagweekendavondbegintijd);
        $carbontoeslagweekendnachtbegintijd = new Carbon($toeslagweekendnachtbegintijd);

        // conditie maken voor: als de "begintijd" van de ochtendtoeslag, avondtoeslag en nachttoeslag van een weekenddag, binnen de begintijd en eindtijd van de doorgegeven dag ligt.
        $weekendochtendbegin = $carbontoeslagweekendochtendbegintijd->isBetween($dagbegintijd, $dageindtijd);
        $weekendavondbegin = $carbontoeslagweekendavondbegintijd->isBetween($dagbegintijd, $dageindtijd);
        $weekendnachtbegin = $carbontoeslagweekendnachtbegintijd->isBetween($dagbegintijd, $dageindtijd);

/////als geregistreerde eindtijd van weekendtoeslag binnen de tijd weekend valt. eindtijd van weekend toeslag////
        // carbon voor het "eindtijd" van de ochtendtoeslag, avondtoesslag en nachttoeslag van een "weekenddag", zodat het gebruikt kan worden
        $carbontoeslagweekendochtendeindtijd = new Carbon($toeslagweekendochtendeindtijd);
        $carbontoeslagweekendavondeindtijd = new Carbon($toeslagweekendavondeindtijd);
        $carbontoeslagweekendnachteindtijd = new Carbon($toeslagweekendnachteindtijd);

        // conditie maken voor: als de "eindtijd" van de ochtendtoeslag, avondtoeslag en nachttoeslag van een "weekenddag", binnen de begintijd en eindtijd van de doorgegeven dag ligt.
        $weekendochtendeind = $carbontoeslagweekendochtendeindtijd->isBetween($dagbegintijd, $dageindtijd);
        $weekendavondeind = $carbontoeslagweekendavondeindtijd->isBetween($dagbegintijd, $dageindtijd);
        $weekendnachteind = $carbontoeslagweekendnachteindtijd->isBetween($dagbegintijd, $dageindtijd);

////conditie maken voor: als geregistreerde begintijd van de doorgegeven dag binnen de begintijd en eindtijd van de weektoeslagen valt/////
        $weekendochtendbegintijd = $dagbegintijd->isBetween($carbontoeslagweekendochtendbegintijd, $carbontoeslagweekendochtendeindtijd);
        $weekendavondbegintijd = $dagbegintijd->isBetween($carbontoeslagweekendavondbegintijd, $carbontoeslagweekendavondeindtijd);
        $weekendnachtbegintijd = $dagbegintijd->isBetween($carbontoeslagweekendnachtbegintijd, $carbontoeslagweekendnachteindtijd);



//// if statements voor het automatisch invullen van de ochtend, avond en nachttoeslag vreemde sleutels van een geregistreerde dag

        // als de "datum" van de geregistreerde dag in tabel "feestdagen" is geregistreerd voert het de rest van deze statment uit.(weekend toeslagen wordt gebruikt)
        if(in_array($datum->format('Y-m-d'), $feestdagen)) {

          // als de begintijd van de geregistreerde dag binnen de begintijd en eindtijd van de meeste recente ochtendtoeslag van een weekenddag valt,
          // wordt de "id" van de meeste recente ochtendtoeslag van een weekenddag, ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
          if ($weekendochtendbegin) {
              $tijd->toeslag_idochtend = $toeslagweekendochtendid;

          // als de eindtijd van de ochtendtoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente ochtendtoeslag van een weekenddag, ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
          } elseif ($weekendochtendeind) {
              $tijd->toeslag_idochtend = $toeslagweekendochtendid;

          // als de begintijd van de ochtendtoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente ochtendtoeslag van een weekenddag, ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
          } elseif ($weekendochtendbegintijd){
              $tijd->toeslag_idochtend = $toeslagweekendochtendid;

          // als geen van de boven staande condities van deze if statement zijn gekozen , wordt "null" ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
          } else {
              $tijd->toeslag_idochtend = null;
          }


          // als de begintijd van de geregistreerde dag binnen de begintijd en eindtijd van de meeste recente avondtoeslag van een weekenddag valt,
          // wordt de "id" van de meeste recente avondtoeslag van een weekenddag, ingevuld in de "toeslag_idavond" vreemde sleutel van de geregistreerde dag.
          if ($weekendavondbegin) {
              $tijd->toeslag_idavond = $toeslagweekendavondid;

          // als de eindtijd van de avondtoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente avondtoeslag van een weekenddag, ingevuld in de "toeslag_idavond" vreemde sleutel van de geregistreerde dag.
          } elseif ($weekendavondeind){
              $tijd->toeslag_idavond = $toeslagweekendavondid;

          // als de begintijd van de avondtoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente avondtoeslag van een weekenddag, ingevuld in de "toeslag_idavond" vreemde sleutel van de geregistreerde dag.
          } elseif ($weekendavondbegintijd){
              $tijd->toeslag_idavond = $toeslagweekendavondid;

          // als geen van de boven staande condities van deze if statement zijn gekozen, wordt "null" ingevuld in de "toeslag_idavond" vreemde sleutel van de geregistreerde dag.
          } else {
              $tijd->toeslag_idavond = null;
          }


          // als de begintijd van de geregistreerde dag binnen de begintijd en eindtijd van de meeste recente nachttoeslag van een weekenddag valt,
          // wordt de "id" van de meeste recente nachttoeslag van een weekenddag, ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
          if ($weekendnachtbegin) {
              $tijd->toeslag_idnacht = $toeslagweekendnachtid;

          // als de eindtijd van de nachttoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente nachttoeslag van een weekenddag, ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
          } elseif ($weekendnachteind){
              $tijd->toeslag_idnacht = $toeslagweekendnachtid;

          // als de begintijd van de nachttoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente nachttoeslag van een weekenddag, ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
          } elseif ($weekendnachtbegintijd){
              $tijd->toeslag_idnacht = $toeslagweekendnachtid;

          // als geen van de bovenstaande condities van deze if statement zijn gekozen, wordt "null" ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
          } else {
              $tijd->toeslag_idnacht = null;
          }


          //////////////controleren als het datum een weekenddag is, en weekendtoeslag koppelen///////////////////

        // als de "datum" van de geregistreerde dag een weekenddag is, voert het de rest van deze statement uit.(weekend toeslagen wordt gebruikt)
        } elseif ($datum->isWeekend()) {

            // als de begintijd van de geregistreerde dag binnen de begintijd en eindtijd van de meeste recente ochtendtoeslag van een weekenddag valt,
            // wordt de "id" van de meeste recente ochtendtoeslag van een weekenddag, ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
            if ($weekendochtendbegin) {
                $tijd->toeslag_idochtend = $toeslagweekendochtendid;

            // als de eindtijd van de ochtendtoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
            // wordt de "id" van de meeste recente ochtendtoeslag van een weekenddag, ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
            } elseif ($weekendochtendeind) {
                $tijd->toeslag_idochtend = $toeslagweekendochtendid;

            // als de begintijd van de ochtendtoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
            // wordt de "id" van de meeste recente ochtendtoeslag van een weekenddag, ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
            } elseif ($weekendochtendbegintijd){
                $tijd->toeslag_idochtend = $toeslagweekendochtendid;

            // als geen van de bovenstaande condities van deze if statement zijn gekozen, wordt "null" ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
            } else {
                $tijd->toeslag_idochtend = null;
            }


            // als de begintijd van de geregistreerde dag binnen de begintijd en eindtijd van de meeste recente avondtoeslag van een weekenddag valt,
            // wordt de "id" van de meeste recente avondtoeslag van een weekenddag, ingevuld in de "toeslag_idavond" vreemde sleutel van de geregistreerde dag.
            if ($weekendavondbegin) {
                $tijd->toeslag_idavond = $toeslagweekendavondid;

            // als de eindtijd van de avondtoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
            // wordt de "id" van de meeste recente avondtoeslag van een weekenddag, ingevuld in de "toeslag_idavond" vreemde sleutel van de geregistreerde dag.
            } elseif ($weekendavondeind){
                $tijd->toeslag_idavond = $toeslagweekendavondid;

            // als de begintijd van de avondtoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
            // wordt de "id" van de meeste recente avondtoeslag van een weekenddag, ingevuld in de "toeslag_idavond" vreemde sleutel van de geregistreerde dag.
            } elseif ($weekendavondbegintijd){
                $tijd->toeslag_idavond = $toeslagweekendavondid;

            // als geen van de boven staande condities van deze if statement zijn gekozen , wordt "null" ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
            } else {
                $tijd->toeslag_idavond = null;
            }


            // als de begintijd van de geregistreerde dag binnen de begintijd en eindtijd van de meeste recente nachttoeslag van een weekenddag valt,
            // wordt de "id" van de meeste recente nachttoeslag van een weekenddag, ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
            if ($weekendnachtbegin) {
                $tijd->toeslag_idnacht = $toeslagweekendnachtid;

            // als de eindtijd van de nachttoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
            // wordt de "id" van de meeste recente nachttoeslag van een weekenddag, ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
            } elseif ($weekendnachteind){
                $tijd->toeslag_idnacht = $toeslagweekendnachtid;

            // als de begintijd van de nachttoeslag van een weekenddag binnen de begintijd en eindtijd van de geregistreerde dag valt,
            // wordt de "id" van de meeste recente nachttoeslag van een weekenddag, ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
            } elseif ($weekendnachtbegintijd){
                $tijd->toeslag_idnacht = $toeslagweekendnachtid;

            // als geen van de boven staande condities van deze if statement zijn gekozen , wordt "null" ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
            } else {
                $tijd->toeslag_idnacht = null;
            }


            //////////////controleren als het datum een weekdag is en weektoeslag koppelen///////////////////

          // als de "datum" van de geregistreerde dag een weekdag is, voert het de rest van deze statement uit.(week toeslagen wordt gebruikt)
        } elseif ($datum->isWeekday ()) {

          // als de begintijd van de geregistreerde dag binnen de begintijd en eindtijd van de meeste recente ochtendtoeslag van een weekdag valt,
          // wordt de "id" van de meeste recente ochtendtoeslag van een weekdag, ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
          if ($weekochtendbegin) {
              $tijd->toeslag_idochtend = $toeslagweekochtendid;

          // als de eindtijd van de ochtendtoeslag van een weekdag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente ochtendtoeslag van een weekdag, ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
          } elseif ($weekochtendeind){
              $tijd->toeslag_idochtend = $toeslagweekochtendid;

          // als de begintijd van de ochtendtoeslag van een weekdag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente ochtendtoeslag van een weekdag, ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
          } elseif ($weekochtendbegintijd){
              $tijd->toeslag_idochtend = $toeslagweekochtendid;

          // als geen van de bovenstaande condities van deze if statement zijn gekozen, wordt "null" ingevuld in de "toeslag_idochtend" vreemde sleutel van de geregistreerde dag.
          } else {
              $tijd->toeslag_idochtend = null;
          }


          // als de begintijd van de geregistreerde dag binnen de begintijd en eindtijd van de meeste recente avondtoeslag van een weekdag valt,
          // wordt de "id" van de meeste recente avondtoeslag van een weekdag, ingevuld in de "toeslag_idavond" vreemde sleutel van de geregistreerde dag.
          if ($weekavondbegin) {
              $tijd->toeslag_idavond = $toeslagweekavondid;

          // als de eindtijd van de avondtoeslag van een weekdag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente avondtoeslag van een weekdag, ingevuld in de "toeslag_idavond" vreemde sleutel van de geregistreerde dag.
          } elseif ($weekavondeind){
              $tijd->toeslag_idavond = $toeslagweekavondid;

          // als de begintijd van de avondtoeslag van een weekdag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente avondtoeslag van een weekdag, ingevuld in de "toeslag_idavond" vreemde sleutel van de geregistreerde dag.
          } elseif($weekavondbegintijd) {
              $tijd->toeslag_idavond = $toeslagweekavondid;

          // als geen van de boven staande condities van deze if statement zijn gekozen , wordt "null" ingevuld in de "toeslag_idavond" vreemde sleutel van de geregistreerde dag.
          }  else {
              $tijd->toeslag_idavond = null;
          }


          // als de begintijd van de geregistreerde dag binnen de begintijd en eindtijd van de meeste recente nachttoeslag van een weekdag valt,
          // wordt de "id" van de meeste recente nachttoeslag van een weekdag, ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
          if ($weeknachtbegin) {
              $tijd->toeslag_idnacht = $toeslagweeknachtid;

          // als de eindtijd van de nachttoeslag van een weekdag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente nachttoeslag van een weekdag, ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
          } elseif($weeknachteind) {
              $tijd->toeslag_idnacht = $toeslagweeknachtid;

          // als de begintijd van de nachttoeslag van een weekdag binnen de begintijd en eindtijd van de geregistreerde dag valt,
          // wordt de "id" van de meeste recente nachttoeslag van een weekdag, ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
          } elseif($weeknachtbegintijd) {
              $tijd->toeslag_idnacht = $toeslagweeknachtid;

          // als geen van de boven staande condities van deze if statement zijn gekozen , wordt "null" ingevuld in de "toeslag_idnacht" vreemde sleutel van de geregistreerde dag.
          } else {
              $tijd->toeslag_idnacht = null;
          }

      }
        // einde if statement

        // vult de "id" van de ingelogde gebruiker automatisch in "user_id" vreemde sleutel van de geregistreerde dag.
        $tijd->user_id = Auth::user()->id;

        // vult de "id" van de meest recente uurtarief, automatisch in "tarief_id" vreemde sleutel van de geregistreerde dag.
        $tijd->tarief_id = Tarief::where('user_id', auth()->user()->id)->latest('created_at')->first()->id;

        // slaat geregisrtreerde dag op in tabel "tijden"
        $tijd->save();

         return redirect()->route('UToevoegen.overzicht_gewerkte_dagen')
             ->with('success','Uren zijn opgeslagen');
    }

    /**
     * Deze functie toont de toeslagen dat gekoppeld zijn aan de geregistreerde dag.
     * Stuur de gegevens om naar de "tonen" venster om het te tonen.
     *
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Contracts\View\View
     */
    public function tonen(Tijd $tijd)
    {

       // toeslageb van dat gekoppeld zijn aan de geselecteerd dag, worden meer gestuurd
        $toeslagochtend = $tijd->toeslag_idochtend;
        $toeslagavond = $tijd->toeslag_idavond;
        $toeslagnacht = $tijd->toeslag_idnacht;

        $toeslagen = Tijd::where('toeslag_idnacht', \Auth::user()->id)
            ->where('toeslag_idavond' , \Auth::user()->id)
            ->where('toeslag_idochtend' , \Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('layouts.user.functietoevoegen.tonen',compact( 'toeslagen', 'toeslagochtend', 'toeslagavond', 'toeslagnacht',  'tijd'));
    }


    /**
     * Deze functoe toont de venster waarin de geregistreerde dag wordt gewijzigt.
     * Suurt ook alle klanten (bedrijven) van de zpper naar de ventser zodat ze kunnen worden geselecteerd.
     *
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Contracts\View\View
     */
    public function wijzigen(Tijd  $tijd)
    {
        // toont alle klant dat de zpper heeft registreert
        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();

        return view('layouts.user.functietoevoegen.wijzigen',compact('tijd','bedrijven'));
    }

    /**
     * Deze functie vervangt de huidige gegevens met de nieuwe gewijzgde gegevens van geregistreerde dag.
     * De gegevens worden in tabel "tijden opgeslagen"
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Http\RedirectResponse
     */
    public function WijzigingOpslaan(Request $request, Tijd $tijd)
    {
       // controleert als all invoer vakken zijn gevuld.
       // halt de ingevoerd gegevens op
        $validated = $request->validate([
            //table tijd
            'begintijd' => 'required',
            'eindtijd' => 'required',
            'toeslag_idochtend' => '',
            'toeslag_idavond' => '',
            'toeslag_idnacht' => '',
            'datum' => 'required',
            'user_id' => '',
            'bedrijf_id' => 'required',
        ]);

        // slaat de ingevoerde gegevens op in tabel "tijden"
        // de ingevoerde gegevens vervangen huidge gegevens
        $tijd->update($validated);

           return redirect()->route('UToevoegen.overzicht_gewerkte_dagen')
            ->with('success','Uren zijn aangepast');
    }

    /**
     * Deze functie verwijdert de geregistreerde dagen
     * Rijen van tabel "tijden" worden verwijderd.
     *
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verwijderen(Tijd $tijd)
    {
        // via de model "tijden" worden geregistreerde dagen van tabel "tijden" verwijdert
        $tijd->delete();

        return redirect()->route('UToevoegen.overzicht_gewerkte_dagen')
            ->with('success','Uren zijn verwijderd');

    }

}
