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
     * controller voor het indienen van uren en toeslag. gekoppeld aan Toevoegen.blade
     */
    /**
     * /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
       //    $toeslagen = Toeslag::latest()->paginate(5);

        //   return view('layouts.user.Toevoegen',compact('tijden'))
        //       ->with('i', (request()->input('page', 1) - 1) * 5);
//////////////////////////////
//        $toeslagen = Toeslag::with('tijden')->get();


////////// toon toeslagen voor ingelogde user////////////
//        $toeslagen = auth()->user()->toeslagen;
//        $toeslagen->orderBy('id','DESC');
//        $toeslagen = Toeslag::orderBy('id', 'DESC')->get();

//        $toeslagen = Toeslag::orderBy('created_at', 'desc')->get();
//        $toeslagen->user_id = Auth::user()->id;

//        $toeslagen->created_at->orderBy('DESC')->get();
$toeslagen = Toeslag::where('user_id', \Auth::user()?->id)
    ->orderBy('id', 'DESC')
    ->get();


// tarief tonen per toeslag
        $tarieven = Tarief::where('user_id', auth()->user()->id)->get();

      //aantal uren tonen per toeslag
        foreach ($toeslagen as $toeslag){
            $starttoe = new Carbon($toeslag->toeslagbegintijd);
            $endtoe = new Carbon($toeslag->toeslageindtijd);

            $toeslag->toeslaguren = $starttoe->diffInHours($endtoe);
        }

        return view('layouts.user.IngediendeToeslag', compact('toeslagen','tarieven', 'toeslag'))
            ->with('i', (request()->input('page', 1) - 1) * 4);

        //      $users = Auth::users()->load('tijden');
        //      return view('layouts.user.Toevoegen', ['users' => $users]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('layouts.user.functietoevoegen.toeslag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            //table tijd
            'datum' => '',
            'toeslagbegintijd' => 'required',
            'toeslageindtijd' => 'required',
            'toeslagsoort' => 'required',
//            'soort' => 'required',
            'toeslagpercentage' => 'required',

            'tarief_id' => '',
            'user_id' => '',
           // 'tijd_id' => 'required',

        ]);

        $toeslag = Toeslag::create($request->all());

        $toeslag->user_id = Auth::user()->id;

        $toeslag->tarief_id = Tarief::where('user_id', auth()->user()->id)->latest('created_at')->first()->id;

        $toeslag->save();

////////////////berekende toeslaguren per toeslag//voor factuur///////////////
//        Toeslag::selectRaw("id, toeslagbegintijd, toeslageindtijd, TIMESTAMPDIFF(HOUR, toeslagbegintijd, toeslageindtijd) as toeslaguren")->get();
//////////////////////////////////////////////////////////////////////////////


        ///// toon toevoegen begin scherm nadat tijd en toeslagen zijn opgeslagem
        return redirect()->route('UToevoegenToeslag.index')
            ->with('success', 'Uren en toeslag zijn opgeslagen');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Toeslag $toeslag
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Toeslag $toeslag)
    {

       // $toeslag->toeslag_id = Toeslag::where('user_id', auth()->user()->id);
       // $toeslag->toeslag_id = Auth::user()->id;

      //   $toeslag = auth()->user()->toeslag;
       //  $toeslag->id = auth()->user()->id;

     //   $toeslag = Toeslag::tijden()->user()->id;
//        $tijden = auth()->user()->toeslagen->tijden;

        $tijden = $toeslag->tijden;

   //   dd(toeslagen);


        return view('layouts.user.functietoevoegen.toeslag.show', compact('tijden'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Toeslag $toeslag
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Toeslag $toeslag)
    {
        return view('layouts.user.functietoevoegen.toeslag.edit', compact('toeslag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Toeslag $toeslag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Toeslag $toeslag)
    {
        $request->validate([
            //tabel toeslag
            'datum' => '',
            'toeslagbegintijd' => 'required',
            'toeslageindtijd' => 'required',
            'toeslagsoort' => 'required',
//            'soort' => 'required',
            'toeslagpercentage' => 'required',
//            'uurtarief' => '',

         //   'user_id' => '',
            //'tijd_id' => 'required',

        ]);

        $toeslag->update($request->all());

        return redirect()->route('UToevoegenToeslag.index')
            ->with('success', 'Toeslag is aangepast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Toeslag $toeslag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Toeslag $toeslag)
    {
        $toeslag->delete();

        return redirect()->route('UToevoegenToeslag.index')
            ->with('success', 'Uren en toeslag zijn verwijderd');

    }

}
