<?php

namespace App\Http\Controllers;

use App\Models\Bedrijf;
use App\Models\Tarief;
use App\Models\Tijd;
use App\Models\User;
use App\Models\Toeslag;
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
                                                                  $tijden = auth()->user()->tijden()->orderByDesc('datum')->get();

//        $tijden = Tijd::orderBy('datum','DESC');

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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            //table tijd
            'begintijd' => 'required',
            'eindtijd' => 'required',
            'toeslag_id' => '',
            'datum' => 'required',

            'bedrijf_id' => 'required',

        ]);
//// om toeslag_id automatisch op te slaan wanneer er een tijd wordt aangemaakt/gestoort
        $tijd = Tijd::create($request->all());

        $tijd->toeslag_id = Toeslag::where('user_id', auth()->user()->id)->latest('created_at')->first()->id;
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


        return view('layouts.user.functietoevoegen.show',compact('toeslag', 'tarieven'));
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
