<?php

namespace App\Http\Controllers;

use App\Models\Bedrijf;
use App\Models\Tarief;
use App\Models\Tijd;
use App\Models\User;
use App\Models\Toeslag;
use Carbon\Carbon;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Toeslag $toeslag)
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


//////////////////////////////////toeslagen foreign key invullen///////////////////////////
        $date = $tijd->datum;

//        $datumweek = Carbon::getWeekEndsAt($tijd->datum)->;
//        $datumweek = Carbon::getWeekdays($tijd->datum)->;

//        $datumweekend = Carbon::getWeekendDays($date);
//        $datumweek = Carbon::getWeekDays($date);

//        $datumweek = Carbon::now($tijd->datum)->dayOfWeek;
//        $datumweekend = Carbon::now($tijd->datum)->dayOfWeekIso;

        $datumweekend = Carbon::now()->isWeekend();
        $datumweek = Carbon::now()->isWeekday();

//        $datumweek = Carbon::isWeekday();
//        $datumweekend = Carbon::isWeekend();

        $dagbegintijd = new Carbon($tijd->begintijd);
        $dageindtijd = new Carbon($tijd->eindtijd);

        ////////meeste recente toeslagen voor weekdagen(ochtend, avond en nacht)/////////////
        $toeslagweekochtend = Toeslag::where('soort', '1', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweekavond = Toeslag::where('soort', '2', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweeknacht = Toeslag::where('soort', '3', auth()->user()->id)->latest('created_at')->first()->id;

        ////////meeste recente toeslagen voor weekenddagen(ochtend, avond en nacht)/////////////
        $toeslagweekendochtend = Toeslag::where('soort', '4', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweekendavond = Toeslag::where('soort', '5', auth()->user()->id)->latest('created_at')->first()->id;
        $toeslagweekendnacht = Toeslag::where('soort', '6', auth()->user()->id)->latest('created_at')->first()->id;

        ////////meeste recente toeslagen voor weekdagen(ochtend, avond en nacht)/////////////
        $toeslagweekochtendbegintijd = Toeslag::where('soort', '1', auth()->user()->id)->latest('created_at')->first()->id->get('toeslagbegintijd');
//        $toeslagweekochtendbegintijd = Carbon::createFromTimestamp($dagbegintijd, $dageindtijd);

        $toeslagweekavondbegintijd = new Carbon($toeslag->toeslagbegintijd->where('soort', '2', auth()->user()->id)->latest('created_at')->first()->id);
        $toeslagweeknachtbegintijd = new Carbon($toeslag->toeslagbegintijd->where('soort', '3', auth()->user()->id)->latest('created_at')->first()->id);

        ////////meeste recente toeslagen voor weekdagen(ochtend, avond en nacht)/////////////
        $toeslagweekendochtendbegintijd = new Carbon($toeslag->toeslagbegintijd->where('soort', '4', auth()->user()->id)->latest('created_at')->first());
        $toeslagweekendavondbegintijd = new Carbon($toeslag->toeslagbegintijd->where('soort', '5', auth()->user()->id)->latest('created_at')->first());
        $toeslagweekendnachtbegintijd = new Carbon($toeslag->toeslagbegintijd->where('soort', '6', auth()->user()->id)->latest('created_at')->first());

        $toeslag = Toeslag::selectRaw('*, TIMESTAMPDIFF(HOUR, toeslagbegintijd, toeslageindtijd) as toeslagauren')->where('id', $tijd->toeslag_id)
            ->where('toeslagen.user_id', auth()->user()->id)
            ->first();

        if ($tijd->datum == $datumweek) {
          {
                if ($toeslagweekochtendbegintijd = Carbon::now()->between($dagbegintijd, $dageindtijd, true)) {
                    $tijd->toeslag_idochtend = $toeslagweekochtend->get('id');
                } else {
                    $tijd->toeslag_idochtend = 'NULL';
                }
                if ($toeslagweekavondbegintijd = Carbon::now()->between($dagbegintijd, $dageindtijd, true)) {
                    $tijd->toeslag_idavond = $toeslagweekavond->get('id');
                } else {
                    $tijd->toeslag_idavond = 'NULL';
                }
                if ($toeslagweeknachtbegintijd = Carbon::now()->between($dagbegintijd, $dageindtijd, true)) {
                    $tijd->toeslag_idnacht = $toeslagweeknacht->get('id');
                } else {
                    $tijd->toeslag_idnacht = 'NULL';
                }
            };

        }else{
           {
                if ($toeslagweekendochtend->begintijd = Carbon::now()->between($dagbegintijd, $dageindtijd, true)) {
                    $tijd->toeslag_idochtend = $toeslagweekendochtend->get('id');
                } else {
                    $tijd->toeslag_idochtend = 'NULL';
                }
                if ($toeslagweekendavond->begintijd = Carbon::now()->between($dagbegintijd, $dageindtijd, true)) {
                    $tijd->toeslag_idavond = $toeslagweekendavond->get('id');
                } else {
                    $tijd->toeslag_idavond = 'NULL';
                }
                if ($toeslagweekendnacht->begintijd = Carbon::now()->between($dagbegintijd, $dageindtijd, true)) {
                    $tijd->toeslag_idnacht = $toeslagweekendnacht->get('id');
                } else {
                    $tijd->toeslag_idnacht = 'NULL';
                }
            };
        }


//        $tijd->toeslag_idochtend = Toeslag::where('user_id', auth()->user()->id)->latest('created_at')->first()->id;
//        $tijd->toeslag_idavond = Toeslag::where('user_id', auth()->user()->id)->latest('created_at')->first()->id;
//        $tijd->toeslag_idnacht = Toeslag::where('user_id', auth()->user()->id)->latest('created_at')->first()->id;


                   //             ->isRelation(key: 'user_id', string: 'user');
  //      $tijd->datum = Toeslag::where('datum', auth()->user()->id)->latest('created_at')->first()->datum;

       // $tijd->uren = Tijd::where();

//        $to = Carbon::createFromFormat('Y-m-d H:i:s', $tijd->begintijd);
//        $from = Carbon::createFromFormat('Y-m-d H:i:s', $tijd->eindtijd);
//        $tijd->uren = $to->diffInDays($from);

//        $startTime = Carbon::parse('begintijd');
//        $endTime = Carbon::parse('eindtijd');

//        $tijd->uren =  $startTime->diff($endTime)->format('%H:%I:%S')." Hours";
//        dd($totalDuration);

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
