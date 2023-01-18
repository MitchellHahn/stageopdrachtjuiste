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
     * controller voor het indienen van uren en toeslag. gekoppeld aan Toevoegen.blade
     */
    /**
    * /**
     * Display a listing of the resource.
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

     //   $tijden = Tijd::latest()->paginate(5);

     //   return view('layouts.user.Toevoegen',compact('tijden'))
     //       ->with('i', (request()->input('page', 1) - 1) * 5);
//////////////////////////////
//        $tijden = Tijd::with('toeslagen')->get();

////////// toon tijden voor ingelogde user////////////
//                                                                  $tijden = auth()->user()->tijden()->orderByDesc('datum')->get();

        $tijden = Tijd::orderBy('datum','DESC');

//        dd($tijden);

// $btijd = Tijd::begintijd('H:i');

//                                                $tijden = Tijd::where('bedrijf_id', \DB::table('bedrijven')?->id)->leftJoin('bedrijven', 'bedrijven.user_id', '=', 'user.id')
//
//                                                    ->where('bedrijven.user_id', auth()->user()->id)
//                                                    ->orderBy('id', 'DESC')
//                                                    ->get();


                                                                            $bedrijven = auth()->user()->bedrijven;
//        dd($bedrijven);

//        $bedrijf = $tijd->bedrijf;


        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();

//        $tijden->bedrijf_id = $bedrijf;


       // $tijd = Tijd::where('user_id', auth()->user()->id)->get();

//        $tijd->bedrijf_id = Bedrijf::where('user_id', auth()->user()->id)->get;

        //$bedrijf = Bedrijf::Class;
        //$bedrijf = $tijden->$bedrijf;

       // $tijden = $bedrijf->tijden;
    //    $bedrijf = auth()->user()->bedrijf;

     //       $tijd = $bedrijf->tijd;

//    Bedrijf::begintijd()
//    ->format('%H:%I:%S');
//
//        Bedrijf::eindtijd()
//            ->format('%H:%I:%S');
foreach ($tijden as $tijd){
        $start = new Carbon($tijd->begintijd);
        $end = new Carbon($tijd->eindtijd);

        $tijd->uren = $start->diffInHours($end);
    }

        return view('layouts.user.UrenToevoegen',compact('tijden', 'bedrijven'))
           ->with('i', (request()->input('page', 1) - 1) * 4);

  //      $users = Auth::users()->load('tijden');
  //      return view('layouts.user.Toevoegen', ['users' => $users]);

    }

    /**
     * Show the form for creating a new resource.
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Tijd $tijd)
    {
        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();



        return view('layouts.user.functietoevoegen.create', compact('bedrijven'));
    }

    /**
     * Store a newly created resource in storage.

    *@param  \App\Models\Toeslag $toeslag
    *@param  \App\Models\Feestdag $feestdag
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Toeslag $toeslag, Feestdag $feestdag)
    {

        $request->validate([
            //table tijd
            'begintijd' => 'required',
            'eindtijd' => 'required',
            'toeslag_idochtend' => '',
            'toeslag_idavond' => '',
            'toeslag_idnacht' => '',
            'datum' => 'required',

            'bedrijf_id' => 'required',

        ]);
//// om toeslag_id automatisch op te slaan wanneer er een tijd wordt aangemaakt/gestoort
        $tijd = Tijd::create($request->all());


///////////////////////////////////carbon voor datum///////////////////////////
        $datum = new Carbon($tijd->datum);

        $feestdagen = Feestdag::all('datum')->pluck('datum')->toArray();


///////////////carbon voor begin en eindtijd van dag///////////////
        $dagbegintijd = new Carbon($tijd->begintijd);
        $dageindtijd = new Carbon($tijd->eindtijd);

////////////////////////////////////////////////////////week//////////////////////////////////////////
        ////////(begintijd)meeste recente toeslagen voor weekdagen(ochtend, avond en nacht)/////////////
        $toeslagweekochtendbegintijd = Toeslag::where('soort', '1')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;
        $toeslagweekavondbegintijd = Toeslag::where('soort', '2')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;
        $toeslagweeknachtbegintijd = Toeslag::where('soort', '3')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;

        ////////(eindtijd)meeste recente toeslagen voor weekdagen(ochtend, avond en nacht)/////////////
        $toeslagweekochtendeindtijd = Toeslag::where('soort', '1')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;
        $toeslagweekavondeindtijd = Toeslag::where('soort', '2')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;
        $toeslagweeknachteindtijd = Toeslag::where('soort', '3')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;


        ////////(id)meeste recente toeslagen voor weekdagen(ochtend, avond en nacht)/////////////
        $toeslagweekochtendid = Toeslag::where('soort', '1')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweekavondid = Toeslag::where('soort', '2')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweeknachtid = Toeslag::where('soort', '3')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;


/////////////////////////////////////////////weekend////////////////////////////////////////////////////////
        ////////(begintijd)meeste recente toeslagen voor weekenddagen(ochtend, avond en nacht)/////////////
        $toeslagweekendochtendbegintijd = Toeslag::where('soort', '4')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;
        $toeslagweekendavondbegintijd = Toeslag::where('soort', '5')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;
        $toeslagweekendnachtbegintijd = Toeslag::where('soort', '6')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslagbegintijd;

        ////////(eindtijd)meeste recente toeslagen voor weekenddagen(ochtend, avond en nacht)/////////////
        $toeslagweekendochtendeindtijd = Toeslag::where('soort', '4')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;
        $toeslagweekendavondeindtijd = Toeslag::where('soort', '5')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;
        $toeslagweekendnachteindtijd = Toeslag::where('soort', '6')->where('user_id', auth()->user()->id)->latest('created_at')->first()->toeslageindtijd;

        ////////(id)meeste recente toeslagen voor weekdagen(ochtend, avond en nacht)/////////////
        $toeslagweekendochtendid = Toeslag::where('soort', '4')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweekendavondid = Toeslag::where('soort', '5')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweekendnachtid = Toeslag::where('soort', '6')->where('user_id', auth()->user()->id)->latest('created_at')->first()->id;

/////////////////////////////////////////////weekdag///////////////////////////////////////////////////////////////////////////
////////////////als geregistreerde begintijd van weektoeslag binnen de tijd week valt. begintijd van week toeslag///////////////////////////////////
        $carbontoeslagweekochtendbegintijd = new Carbon($toeslagweekochtendbegintijd);
        $carbontoeslagweekavondbegintijd = new Carbon($toeslagweekavondbegintijd);
        $carbontoeslagweeknachtbegintijd = new Carbon($toeslagweeknachtbegintijd);

        $weekochtendbegin = $carbontoeslagweekochtendbegintijd->isBetween($dagbegintijd, $dageindtijd);
        $weekavondbegin = $carbontoeslagweekavondbegintijd->isBetween($dagbegintijd, $dageindtijd);
        $weeknachtbegin = $carbontoeslagweeknachtbegintijd->isBetween($dagbegintijd, $dageindtijd);
////////////////als geregistreerde eind tijd van de toeslag binnen de tijd week valt. eindtijd van weektoeslag///////////////////////////////////
        $carbontoeslagweekochtendeindtijd = new Carbon($toeslagweekochtendeindtijd);
        $carbontoeslagweekavondeindtijd = new Carbon($toeslagweekavondeindtijd);
        $carbontoeslagweeknachteindtijd = new Carbon($toeslagweeknachteindtijd);

        $weekochtendeind = $carbontoeslagweekochtendeindtijd->isBetween($dagbegintijd, $dageindtijd);
        $weekavondeind = $carbontoeslagweekavondeindtijd->isBetween($dagbegintijd, $dageindtijd);
        $weeknachteind = $carbontoeslagweeknachteindtijd->isBetween($dagbegintijd, $dageindtijd);
//////////als geregistreerde tijd binnen de toeslag week valt. begintijd////////////////
        $weekochtendbegintijd = $dagbegintijd->isBetween($carbontoeslagweekochtendbegintijd, $carbontoeslagweekochtendeindtijd);
        $weekavondbegintijd = $dagbegintijd->isBetween($carbontoeslagweekavondbegintijd, $carbontoeslagweekavondeindtijd);
        $weeknachtbegintijd = $dagbegintijd->isBetween($carbontoeslagweeknachtbegintijd, $carbontoeslagweeknachteindtijd);

/////////////////////////////////////////////weekenddag/////////////////////////////////////////////////////////////////////////////////
////////////////als geregistreerde begintijd van weekendtoeslag binnen de tijd weekend valt. begintijd van weekend toeslag///////////////////////////////////
        $carbontoeslagweekendochtendbegintijd = new Carbon($toeslagweekendochtendbegintijd);
        $carbontoeslagweekendavondbegintijd = new Carbon($toeslagweekendavondbegintijd);
        $carbontoeslagweekendnachtbegintijd = new Carbon($toeslagweekendnachtbegintijd);

        $weekendochtendbegin = $carbontoeslagweekendochtendbegintijd->isBetween($dagbegintijd, $dageindtijd);
        $weekendavondbegin = $carbontoeslagweekendavondbegintijd->isBetween($dagbegintijd, $dageindtijd);
        $weekendnachtbegin = $carbontoeslagweekendnachtbegintijd->isBetween($dagbegintijd, $dageindtijd);
////////////////als geregistreerde eindtijd van weekendtoeslag binnen de tijd weekend valt. eindtijd van weekend toeslag///////////////////////////////////
        $carbontoeslagweekendochtendeindtijd = new Carbon($toeslagweekendochtendeindtijd);
        $carbontoeslagweekendavondeindtijd = new Carbon($toeslagweekendavondeindtijd);
        $carbontoeslagweekendnachteindtijd = new Carbon($toeslagweekendnachteindtijd);

        $weekendochtendeind = $carbontoeslagweekendochtendeindtijd->isBetween($dagbegintijd, $dageindtijd);
        $weekendavondeind = $carbontoeslagweekendavondeindtijd->isBetween($dagbegintijd, $dageindtijd);
        $weekendnachteind = $carbontoeslagweekendnachteindtijd->isBetween($dagbegintijd, $dageindtijd);
//////////als geregistreerde tijd binnen de toeslag week valt. begintijd////////////////
        $weekendochtendbegintijd = $dagbegintijd->isBetween($carbontoeslagweekochtendbegintijd, $carbontoeslagweekochtendeindtijd);
        $weekendavondbegintijd = $dagbegintijd->isBetween($carbontoeslagweekavondbegintijd, $carbontoeslagweekavondeindtijd);
        $weekendnachtbegintijd = $dagbegintijd->isBetween($carbontoeslagweeknachtbegintijd, $carbontoeslagweeknachteindtijd);


        //////////////controleren als het datum een feestdag is en weekendtoeslag koppelen///////////////////
        if(in_array($datum->format('Y-m-d'), $feestdagen)) {

          if ($toeslagweekendochtendbegintijd = $weekendochtendbegin) {
              $tijd->toeslag_idochtend = $toeslagweekendochtendid;
          } elseif ($toeslagweekendochtendeindtijd = $weekendochtendeind) {
              $tijd->toeslag_idochtend = $toeslagweekendochtendid;
          } elseif ($dagbegintijd = $weekendochtendbegintijd){
              $tijd->toeslag_idochtend = $toeslagweekendochtendid;
          } else {
              $tijd->toeslag_idochtend = null;
          }

          if ($toeslagweekendavondbegintijd = $weekendavondbegin) {
              $tijd->toeslag_idavond = $toeslagweekendavondid;
          } elseif ($toeslagweekendavondeindtijd = $weekendavondeind){
              $tijd->toeslag_idavond = $toeslagweekendavondid;
          } elseif ($dagbegintijd = $weekendavondbegintijd){
              $tijd->toeslag_idavond = $toeslagweekendavondid;
          } else {
              $tijd->toeslag_idavond = null;
          }

          if ($toeslagweekendnachtbegintijd = $weekendnachtbegin) {
              $tijd->toeslag_idnacht = $toeslagweekendnachtid;
          } elseif ($toeslagweekendnachteindtijd = $weekendnachteind){
              $tijd->toeslag_idnacht = $toeslagweekendnachtid;
          } elseif ($dagbegintijd = $weekendnachtbegintijd){
              $tijd->toeslag_idnacht = $toeslagweekendnachtid;
          } else {
              $tijd->toeslag_idnacht = null;
          }

          //////////////controleren als het datum een weekenddag is en weekendtoeslag koppelen///////////////////

      } elseif ($datum->isWeekend()) {

            if ($toeslagweekendochtendbegintijd = $weekendochtendbegin) {
                $tijd->toeslag_idochtend = $toeslagweekendochtendid;
            } elseif ($toeslagweekendochtendeindtijd = $weekendochtendeind) {
                $tijd->toeslag_idochtend = $toeslagweekendochtendid;
            } elseif ($dagbegintijd = $weekendochtendbegintijd){
                $tijd->toeslag_idochtend = $toeslagweekendochtendid;
            } else {
                $tijd->toeslag_idochtend = null;
            }

            if ($toeslagweekendavondbegintijd = $weekendavondbegin) {
                $tijd->toeslag_idavond = $toeslagweekendavondid;
            } elseif ($toeslagweekendavondeindtijd = $weekendavondeind){
                $tijd->toeslag_idavond = $toeslagweekendavondid;
            } elseif ($dagbegintijd = $weekendavondbegintijd){
                $tijd->toeslag_idavond = $toeslagweekendavondid;
            } else {
                $tijd->toeslag_idavond = null;
            }

            if ($toeslagweekendnachtbegintijd = $weekendnachtbegin) {
                $tijd->toeslag_idnacht = $toeslagweekendnachtid;
            } elseif ($toeslagweekendnachteindtijd = $weekendnachteind){
                $tijd->toeslag_idnacht = $toeslagweekendnachtid;
            } elseif ($dagbegintijd = $weekendnachtbegintijd){
                $tijd->toeslag_idnacht = $toeslagweekendnachtid;
            } else {
                $tijd->toeslag_idnacht = null;
            }

            //////////////controleren als het datum een weekdag is en weektoeslag koppelen///////////////////
      } elseif ($datum->isWeekday ()) {

          if ($toeslagweekochtendbegintijd = $weekochtendbegin) {
              $tijd->toeslag_idochtend = $toeslagweekochtendid;
          } elseif ($toeslagweekochtendeindtijd = $weekochtendeind){
              $tijd->toeslag_idochtend = $toeslagweekochtendid;
          } elseif ($dagbegintijd = $weekochtendbegintijd){
              $tijd->toeslag_idochtend = $toeslagweekochtendid;
          } else {
              $tijd->toeslag_idochtend = null;
          }

          if ($toeslagweekochtendbegintijd = $weekavondbegin) {
              $tijd->toeslag_idavond = $toeslagweekavondid;
          } elseif ($toeslagweekavondeindtijd = $weekavondeind){
              $tijd->toeslag_idavond = $toeslagweekavondid;
          } elseif($dagbegintijd = $weekavondbegintijd) {
              $tijd->toeslag_idavond = $toeslagweekavondid;
          }  else {
              $tijd->toeslag_idavond = null;
          }

          if ($toeslagweekochtendbegintijd = $weeknachtbegin) {
              $tijd->toeslag_idnacht = $toeslagweeknachtid;
          } elseif($toeslagweeknachteindtijd = $weeknachteind) {
              $tijd->toeslag_idnacht = $toeslagweeknachtid;
          } elseif($dagbegintijd = $weeknachtbegintijd) {
              $tijd->toeslag_idnacht = $toeslagweeknachtid;
          } else {
              $tijd->toeslag_idnacht = null;
          }

      }

        $tijd->save();


////////berekende uren per tijd(dag)//voor factuur////////////////
//       Tijd::selectRaw("id, begintijd, eindtijd, TIMESTAMPDIFF(HOUR, begintijd, eindtijd) as uren")->get();
//////////////////////////////////////////////////////////////////

        ///////directen naar de blade om toeslag in te dienen////
         return redirect()->route('UToevoegen.index')
             ->with('success','Uren zijn opgeslagen');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Tijd $tijd)
    {

        $toeslag = $tijd->toeslag;
        $tarieven = Tarief::where('user_id', auth()->user()->id)->get();


        $totaalToeslagBedrag = 0;
        $totaalstandaardBedrag = 0;
        $uren = 0;
        $toeslaguren = 0;
        $toonuren = 0;
        $toontoeslaguren = 0;


//            tarief per tijd en toeslag
            $tarief = \Auth::user()->tarief()
                ->where('id', $toeslag->tarief_id)
                ->where('tarieven.user_id', auth()->user()->id)
//                ->where('tarieven.user_id', auth()->user()->id)
                ->first();

//////////////////uren in minuten berekenen/////////////////////
            $start = new Carbon($tijd->begintijd);
            $end = new Carbon($tijd->eindtijd);

            $tijd->uren = $start->diffInMinutes($end);
//////////////////uren in uren tonen/////////////////////
            $tijd->toonuren = $start->diffInHours($end);

//////////////////toeslaguren in minuten berekenen/////////////////////
            $starttoe = new Carbon($toeslag->toeslagbegintijd);
            $endtoe = new Carbon($toeslag->toeslageindtijd);
            $tijd->toeslaguren = $starttoe->diffInMinutes($endtoe);

//////////////////toeslaguren in uren tonen/////////////////////
//            $toonstarttoe = new Carbon($toeslag->toeslagbegintijd);
//            $toonendtoe = new Carbon($toeslag->toeslageindtijd);
            $tijd->toontoeslaguren = $starttoe->diffInHours($endtoe);

//            $tijd->toeslaguren = $starttoe->diff($endtoe)->format('%H:%i:%s');

            $tijd->totaalToeslagBedrag += $tijd->toeslaguren * (($tarief->bedrag / 60) * ($toeslag->toeslagpercentage / 100));
//            $tijd->totaalToeslagBedrag = round($tijd->totaalToeslagBedrag, 2);

            $tijd->totaalstandaardBedrag += ($tarief->bedrag / 60) * ($tijd->uren - $tijd->toeslaguren);
//            $tijd->totaalstandaardBedrag = round($tijd->totaalstandaardBedrag, 2);

            $tijd->totaalBedrag += $tijd->totaalToeslagBedrag + $tijd->totaalstandaardBedrag;
//            $tijd->totaalBedrag = round($tijd->totaalBedrag, 2);

            $tijd->btw += $tijd->totaalBedrag * 0.21;
//            $tijd->btw = round($tijd->btw, 2);

            $tijd->uitbetaling += $tijd->btw + $tijd->totaalBedrag;
//            $tijd->uitbetaling = round($tijd->uitbetaling, 2);



        return view('layouts.user.functietoevoegen.show',compact('toeslag', 'tarieven', 'tijd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Tijd  $tijd)
    {
        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();

        return view('layouts.user.functietoevoegen.edit',compact('tijd','bedrijven'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tijd $tijd)
    {
        $validated = $request->validate([
            //table tijd
            'begintijd' => 'required',
            'eindtijd' => 'required',
//            'toeslag_id' => '',
            'datum' => 'required',
            'bedrijf_id' => 'required',

        ]);

        $tijd->update($validated);


           return redirect()->route('UToevoegen.index')
            ->with('success','Uren zijn aangepast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tijd  $tijd
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tijd $tijd)
    {
        $tijd->delete();

        return redirect()->route('UToevoegen.index')
            ->with('success','Uren en toeslag zijn verwijderd');

    }

}
