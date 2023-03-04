<?php

namespace App\Http\Controllers;

use App\Http\Middleware\User;
use App\Models\Toeslag;
use Auth;
use Illuminate\Http\Request;
use App\Models\Tarief;

class TariefController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Models\Tarief  $tarief
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, User $user)
    {
//        $tarief = auth()->user()
//        ->latest('created_at')->first()->id;



//        $tarief = Toeslag::$toeslag->tarief_id
//        ->latest('created_at')->first()->id
//        ->where('user_id', auth()->user()->id);

        $tarief = \Auth::user()->tarief()->latest();


//            ->leftJoin('toeslagen', 'tarieven.id', '=', 'toeslagen.tarief_id')
//        ->where('toeslagen.user_id', auth()->user()->id)
//        ->get();

//        ->where('created_at')
//        ->latest();

//        \Auth::user()->tarief->id;

        return view('layouts.user.MijnProfiel',compact('user','request', 'tarief' ))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }

    /**
     * Show the form for creating a new resource.
     * @param  \App\Models\Tarief $tarief
     * @return \Illuminate\Http\Response
     */
    public function create(Tarief $tarief)
    {
        //toon laatste tarief bij venster om een nieuwe tarief te maken
        $tarief = \Auth::user()->tarief()->latest()->first();


        return view('layouts.user.functietoevoegen.tarief.create', compact('tarief'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            //table tijd
            'bedrag' => 'required',
            'user_id' => '',

        ]);

        $tarief = Tarief::create($request->all());

        $tarief->user_id = Auth::user()->id;


//        $tijd->toeslag_id = Toeslag::where('user_id', auth()->user()->id)->latest('created_at')->first()->id;

        $tarief->save();
///////////////new toeslag maken voor nieuwe tarief//////////////////
    ///    $toeslag->user_id = Auth::user()->id;

        $toeslag = \Auth::user()->toeslagen()->latest()->first();

        if($toeslag) {
            $newToeslag = $toeslag->replicate();
            $newToeslag->created_at = now();
        } else {
            $newToeslag = new Toeslag();
            $newToeslag->tarief_id = Tarief::where('user_id', auth()->user()->id)->latest('created_at')->first()->id;

        }
//       $toeslag = Toeslag::find(1);

        $newToeslag->datum = now();
        //       $newID = $new->id;
        $newToeslag->tarief_id = Tarief::where('user_id', auth()->user()->id)->latest('created_at')->first()->id;

        $newToeslag->save();
   //     dd($newToeslag);
/////////////////////////////////
        return redirect()->route('BProfiel.overzicht_profiel_gegevens')
            ->with('success','Tarief is aangepast');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
