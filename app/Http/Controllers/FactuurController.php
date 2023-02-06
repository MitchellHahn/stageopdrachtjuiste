<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Bedrijf;
use App\Models\Brouwerscontact;
use App\Models\Factuur;
use App\Models\Tarief;
use App\Models\Tijd;
use App\Models\Toeslag;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PDF;
use DB;

class FactuurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Bedrijf  $bedrijf
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function index(Bedrijf $bedrijf)
    {

//        $tijden = auth()->user()->tijden;
//        return view('layouts.user.Factuur', compact('tijden'));
        return view('layouts.user.Factuur', compact('bedrijf'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $bedrijfId = $request->bedrijf;
        return view('layouts.user.functietoevoegen.factuur.edit', compact('bedrijfId'));
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
            //tabel brouwerscontacten
            'email' => 'required',
            //   'user_id' => '',

        ]);

        $brouwerscontact = new Brouwerscontact($request->all());

        Auth::user()->brouwerscontact()->save($brouwerscontact);

        return redirect()->route('Factuurmaand.select', ['brouwerscontact' => $brouwerscontact, 'bedrijf' => $request->bedrijf])
            ->with('success', 'Brouwers contact info is aangepast');
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

//////////////////Brouwers CC: email/////BEGIN////////////////
    /**
     * Show the form for editing the specified resource.
     * @param  Brouwerscontact $brouwerscontact
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Brouwerscontact $brouwerscontact)
    {
        $bedrijfId = $request->bedrijf;


        return view('layouts.user.functietoevoegen.factuur.edit', compact('brouwerscontact', 'bedrijfId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brouwerscontact $brouwerscontact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Brouwerscontact $brouwerscontact)
    {
        $request->validate([
            //tabel brouwerscontacten
            'email' => 'required',
            //   'user_id' => '',

        ]);

        \Auth::user()->brouwerscontact->id;
        $brouwerscontact->update($request->all());

        return redirect()->route('Factuurmaand.select', ['brouwerscontact' => $brouwerscontact, 'bedrijf' => $request->bedrijf])
            ->with('success', 'Brouwers contact info is aangepast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brouwerscontact  $brouwerscontact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Brouwerscontact  $brouwerscontact)
    {
        $brouwerscontact->delete();

        return redirect()->route('Factuuremail.destroy', [$brouwerscontact])
            ->with('success', 'Brouwers contact info is verwijderd');
    }
/////////////////////////Brouwers CC: email///////END///////////////////////////

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getBedrijf(Request $request, Bedrijf $bedrijf)
    {
        ///////////////////facturen voor gekozen bedrijf zoeken/////////////
//        $bedrijven = auth()->user()->bedrijven;
//
//
//        $bedrijf = $request->bedrijf;

//        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();


        $facturen = DB::table('facturen')->leftJoin('bedrijven', 'facturen.bedrijf_id', '=', 'bedrijven.id')
            ->where('facturen.bedrijf_id', [$bedrijf->id])
            ->where('bedrijven.user_id', auth()->user()->id)
            ->get();
//dd($facturen);
        return view('layouts.user.functietoevoegen.factuur.maandenjaar', compact('facturen', 'bedrijf'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getDate(Request $request, Bedrijf $bedrijf)
    {
//        $fdate = $request->fdate;
//        $sdate = $request->sdate;
        ///////////////////uren voor gekozen maand en bedrijf zoeken/////////////

/////////////bedrijven zoeken voor ingelogde user//////////////
        $bedrijven = auth()->user()->bedrijven;


        $year = $request->year;
        $month = $request->month;


        $sdate = Carbon::createFromDate($year, $month)->startOfMonth();
        $fdate = Carbon::createFromDate($year, $month)->endOfMonth();

//        dd($sdate, $fdate, auth()->user()->id);

        $tijden = DB::table('tijden')
            //////////tijden leftjoinen met de drie toeslagen, zodat de gekoppelde toeslag gebruikt kan worden. conditie "NULL" en "NOT NULL"//////////
            ->leftJoin('toeslagen as toeslagochtend', function(\Illuminate\Database\Query\JoinClause $join) {
                $join->on('tijden.toeslag_idochtend', '=', 'toeslagochtend.id');
                $join->on('toeslagochtend.user_id', '=', 'tijden.user_id');
            })
            ->leftJoin('toeslagen as toeslagavond', function(\Illuminate\Database\Query\JoinClause$join) {
                $join->on('tijden.toeslag_idavond', '=', 'toeslagavond.id');
                $join->on('toeslagavond.user_id', '=', 'tijden.user_id');
            })
            ->leftJoin('toeslagen as toeslagnacht', function(\Illuminate\Database\Query\JoinClause$join) {
                $join->on('tijden.toeslag_idnacht', '=', 'toeslagnacht.id');
                $join->on('toeslagnacht.user_id', '=', 'tijden.user_id');
            })

//            ->leftJoin('toeslagen as toeslagochtend', 'tijden.toeslag_idochtend', '=', 'toeslagochtend.id')
//            ->leftJoin('toeslagen as toeslagavond', 'tijden.toeslag_idavond', '=', 'toeslagavond.id')
//            ->leftJoin('toeslagen as toeslagnacht', 'tijden.toeslag_idnacht', '=', 'toeslagnacht.id')

            ->leftJoin('bedrijven', 'tijden.bedrijf_id', '=', 'bedrijven.id')

            /////////////datum invoer controleren bij tabel tijden////////////
            ->whereBetween('tijden.datum', [$sdate, $fdate])

            /////////////bedrijf invoer controleren////////////
            ->where('tijden.bedrijf_id', [$bedrijf->id])
            /////////////bedrijf invoer filteren op user////////////
            ->where('bedrijven.user_id', auth()->user()->id)

            /////////tijden zoeken bij toeslagen van de gebruiker/////////
//            ->where('toeslagochtend.user_id', auth()->user()->id)
//            ->where('toeslagavond.user_id', auth()->user()->id)
//            ->where('toeslagnacht.user_id', auth()->user()->id)
            ////////datum van tabel tijden en toeslagen onderscheiden////////
//            ->get(['tijden.datum AS tijden_datum', 'toeslagen.datum AS toeslagen_datum', 'toeslagen.*', 'tijden.*']);
            ->get(['tijden.datum AS tijden_datum', 'toeslagochtend.datum AS toeslagochtend_datum', 'toeslagavond.datum AS toeslagavond_datum', 'toeslagnacht.datum AS toeslagnacht_datum', 'toeslagochtend.*', 'toeslagavond.*', 'toeslagnacht.*', 'tijden.*']);
        // ->get();

        /////////////maand en jaar in tabel factuur doorgeven wanneer knop wordt gedrukt////////////
        if(count($tijden) >= 1) {
            $user_id = auth()->user()->id;
            $startDatum = Carbon::createFromDate($year, $month, 1);
            $eindDatum = Carbon::createFromDate($year, $month)->endOfMonth();

            $currentYear = $startDatum->format('Y');

            $laatsteFactuur = Factuur::whereRaw('YEAR(startdatum) = ?', $currentYear)
                ->where('user_id', '=', Auth::user()->id)
                ->orderByRaw('LENGTH(naam) DESC')
                ->orderByDesc('naam')
                ->first();

            if($laatsteFactuur) {
                $latestInvoiceId = $laatsteFactuur->naam;
                $latestNr = substr($latestInvoiceId, strpos($latestInvoiceId, '-') + 1);
                $name = $currentYear.'-'.sprintf('%04d', ((int)$latestNr + 1));
            } else {
                $name = $currentYear.'-0001';
            }

            $factuur = new Factuur();
            $factuur->bedrijf_id = $bedrijf->id;
            $factuur->startdatum = $startDatum;
            $factuur->einddatum = $eindDatum;
            $factuur->naam = $name;
            $factuur->user_id = Auth::user()->id;
            $factuur->save();
//            Factuur::insertOrIgnore([
//                "bedrijf_id" => $bedrijf->id,
//                "startdatum" => $startDatum,
//                "einddatum" => $eindDatum,
////                "naam" => "Factuur-{$year}-{$month}_{$bedrijf->bedrijfsnaam}-
//                "naam" => $name,
//                "user_id" => Auth::user()->id,
//
//            ]);
        }
        /*

        */

//        dd(Auth::user()->id);




        return view('layouts.user.functietoevoegen.factuur.result', compact('tijden', 'fdate', 'sdate', 'year', 'month', 'bedrijven', 'bedrijf', 'factuur'));
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendPDF(Request $request, Factuur $factuur)
    {
        $user = auth()->user();
        $bedrijf = $factuur->bedrijf;

        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();

        $sdate = $factuur->startdatum;
        $fdate = $factuur->einddatum;

        $tijden = Tijd::selectRaw('tijden.datum AS tijden_datum, toeslagochtend.datum AS toeslagochtend_datum, toeslagavond.datum AS toeslagavond_datum, toeslagnacht.datum AS toeslagnacht_datum, toeslagochtend.*, toeslagavond.*, toeslagnacht.*, tijden.*, TIMESTAMPDIFF(HOUR, begintijd, eindtijd) as uren')
//        $tijden = Tijd::selectRaw('tijden.datum AS tijden_datum, tijden.*, TIMESTAMPDIFF(HOUR, begintijd, eindtijd) as uren')

            ->leftJoin('toeslagen as toeslagochtend', function(\Illuminate\Database\Query\JoinClause $join) {
                $join->on('tijden.toeslag_idochtend', '=', 'toeslagochtend.id');
                $join->on('toeslagochtend.user_id', '=', 'tijden.user_id');
            })
            ->leftJoin('toeslagen as toeslagavond', function(\Illuminate\Database\Query\JoinClause$join) {
                $join->on('tijden.toeslag_idavond', '=', 'toeslagavond.id');
                $join->on('toeslagavond.user_id', '=', 'tijden.user_id');
            })
            ->leftJoin('toeslagen as toeslagnacht', function(\Illuminate\Database\Query\JoinClause$join) {
                $join->on('tijden.toeslag_idnacht', '=', 'toeslagnacht.id');
                $join->on('toeslagnacht.user_id', '=', 'tijden.user_id');
            })
//            ->leftJoin('toeslagen as toeslagochtend', 'tijden.toeslag_idochtend', '=', 'toeslagochtend.id')
//            ->leftJoin('toeslagen as toeslagavond', 'tijden.toeslag_idavond', '=', 'toeslagavond.id')
//            ->leftJoin('toeslagen as toeslagnacht', 'tijden.toeslag_idnacht', '=', 'toeslagnacht.id')

            ->leftJoin('bedrijven', 'tijden.bedrijf_id', '=', 'bedrijven.id')

            //            tarief voor tijd en toeslag
            ->leftJoin('tarieven', 'tijden.tarief_id', '=', 'tarieven.id')
            //            user info voor tijd en toeslag
            ->leftJoin('users', 'tijden.user_id', '=', 'users.id')

//            ->leftJoin('users', 'tarieven.user_id', '=', 'users.id')


            ->whereBetween('tijden.datum', [$sdate, $fdate])

            ->where('tijden.bedrijf_id', [$bedrijf->id])
            ->where('bedrijven.user_id', auth()->user()->id)

//            ->where('toeslagochtend.user_id', auth()->user()->id)
//            ->where('toeslagavond.user_id', auth()->user()->id)
//            ->where('toeslagnacht.user_id', auth()->user()->id)

            //            tarief voor user
            ->where('tarieven.user_id', auth()->user()->id)
            //              userinfoz
            ->where('users.id', auth()->user()->id)

            ->get();

        $brouwerscontacten = DB::table('brouwerscontacten')
            ->where('brouwerscontacten.user_id', auth()->user()->id)
            ->get();

        $maanduitbetaling = 0;
        $maandbtw = 0;
        $maandTotaalBedrag = 0;

        $totaalOchtendToeslagBedrag = 0;
        $totaalAvondToeslagBedrag = 0;
        $totaalNachtToeslagBedrag = 0;

        $totaalstandaardBedrag = 0;

        /////////variable voor alle minuten van het hele dag// tussen begin en eindtijd/////
        $uren = 0;

        $ochtendtoeslaguren = 0;
        $avondtoeslaguren = 0;
        $nachttoeslaguren = 0;

        $toonuren = 0;
        $toontoeslaguren = 0;

        /////////variable voor het hele dag// tussen begin en eind tijd/////
        $dag = new Carbon();
//dd($tijden);
        foreach($tijden as $tijd) {
            $toeslag = Toeslag::selectRaw('*, TIMESTAMPDIFF(HOUR, toeslagbegintijd, toeslageindtijd) as toeslagauren')->where('id', $tijd->toeslag_idochtend)
                ->where('id', $tijd->toeslag_idavond)
                ->where('id', $tijd->toeslag_idnacht)

                ->where('toeslagen.user_id', auth()->user()->id)
                ///////////////////aparte queries maken voor elke toeslag//////////////////////
//                ->where('toeslagochtend.user_id', auth()->user()->id)
//                ->where('toeslagavond.user_id', auth()->user()->id)
//                ->where('toeslagnacht.user_id', auth()->user()->id)
                ->first();

//            tarief per tijd en toeslag
            $tarief = \Auth::user()->tarief()
                ->where('id', $tijd->tarief_id)
                ->where('tarieven.user_id', auth()->user()->id)
//                ->where('tarieven.user_id', auth()->user()->id)
                ->first();

///////////////////////////////////////////////////////gebruiken voor nieuwe berekening/////////////////14-12-2022///////////////////////////
//            $tijdBeginDatum = Carbon::createFromFormat('Y-m-d H:i:s', $tijd->tijden_datum.' '.$tijd->begintijd);
//            $tijdEindDatum = Carbon::createFromFormat('Y-m-d H:i:s', $tijd->tijden_datum.' '.$tijd->eindtijd);
//
//            $startAvond = Carbon::createFromFormat('Y-m-d H:i:s', $tijd->tijden_datum.' 18:00:00');
//
//            if() { // Toeslang niet bestaat
//                 100%
//            } elseif($tijdBeginDatum->isWeekend()) {
//                 weekend tarief
//            } else {
//
//                 dagtarief = verschil tussen $tijdBeginDatum en $startAvond
//                 avondtarief = verschil tussen $startAvond en $tijdEindDatum
//
//            }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////uren in minuten berekenen/////////////////////
            $beginvandag = new Carbon($tijd->begintijd);
            $eindvandag = new Carbon($tijd->eindtijd);

            ////////////alle minuten van een ingediende dag////////////
            $tijd->uren = $beginvandag->diffInMinutes($eindvandag);



//////////////////uren in uren tonen/////////////////////
//            $tijd->toonuren = $start->diffInHours($end);

//////////////////toeslaguren in minuten berekenen/////////////////////
//            $starttoe = new Carbon($toeslag->toeslagbegintijd);
//            $endtoe = new Carbon($toeslag->toeslageindtijd);

//            $tijd->toeslaguren = $starttoe->diffInMinutes($endtoe);


            /////////carbon voor het begin en eindtijd van alle drie toeslagen. wordt gebruikt in berekening/////////////





            ///////alle minuten van elk verschillend toeslag (die door de Brouwers medewerker is ingesteld)/////

            ///////////tussen begin en eind tijd van de ingediende dag////////////
//            $geregistreerdedag = $dag->isBetween($start, $end);

            //////////////////////////vergelijking die in de if statement voor bet berkenen van elke toeslag wordt gebruikt.////////////
            ///////////als de begin en eindtijd van toeslagochtend binnen het geregistreerde dag is/////////////


            ///////////als de begin en eindtijd van toeslagavond binnen het geregistreerde dag is/////////////


            ///////////als de begin en eindtijd van toeslagnacht binnen het geregistreerde dag is/////////////


            ///////////////////vergelijking die in de if statement voor bet berkenen van elke toeslag wordt gebruikt.////////////
            ///////////als de begin en eindtijd van het dag binnen het begin en eindtijd van ochtendtoeslag is geregistreerd/////////////


            ///////////als de begin en eindtijd van het dag binnen het begin en eindtijd van avondtoeslag is geregistreerd/////////////


            ///////////als de begin en eindtijd van het dag binnen het begin en eindtijd van nachttoeslag is geregistreerd/////////////



///////////////////vergelijking die in de if statement voor bet berkenen van elke toeslag wordt gebruikt.////////////
///////////als alleen het begin van het dag binnen het begin en eindtijd van ochtendtoeslag is geregistreerd/////////////

///////////als alleen het begin van het dag binnen het begin en eindtijd van avondtoeslag is geregistreerd/////////////

///////////als alleen het begin van het dag binnen het begin en eindtijd van nachttoeslag is geregistreerd/////////////


///////////////////vergelijking die in de if statement voor bet berkenen van elke toeslag wordt gebruikt.////////////
///////////als alleen het begin van het dag binnen het begin en eindtijd van ochtendtoeslag is geregistreerd/////////////

///////////als alleen het begin van het dag binnen het begin en eindtijd van avondtoeslag is geregistreerd/////////////

///////////als alleen het begin van het dag binnen het begin en eindtijd van nachttoeslag is geregistreerd/////////////

//////////////////berekening voor elk dag van de gekozen maand. factuur berekening///////////////////



            /////////////toeslagen voor elke dag berekenen//////////////
            ///////////////////////berekenen van avondtoeslag voor elke dag////////////////////////////////////

            if (!$tijd->toeslagochtend){
                $tijd->totaalOchtendToeslagBedrag = null;

            } else {

                $beginvantoeslagochtend = new Carbon($tijd->toeslagochtend->toeslagbegintijd);
                $eindvantoeslagochtend = new Carbon($tijd->toeslagochtend->toeslageindtijd);

                $tijd->ochtendtoeslaguren = $beginvantoeslagochtend->diffInMinutes($eindvantoeslagochtend);

                $BeginVanToeslagochtendIsInDag = $beginvantoeslagochtend->isBetween($beginvandag, $eindvandag);
                $EindVanToeslagochtendIsInDag = $eindvantoeslagochtend->isBetween($beginvandag, $eindvandag);

                $BeginVanDagIsInOchtendtoeslag =  $beginvandag->isBetween($beginvantoeslagochtend, $eindvantoeslagochtend);
                $EindVanDagIsInOchtendtoeslag =  $eindvandag->isBetween($beginvantoeslagochtend, $eindvantoeslagochtend);

                $tijd->BeginVanOchtendtoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagochtend);

                $tijd->EindVanOchtendtoeslagurenIsIncompleet = $eindvandag->diffInMinutes($beginvantoeslagochtend);

                ///////////als begin en eindtijd van ochtendtoeslag binnen de ingediende tijd valt, gebruikt het de volle tijd van het ingestelde toeslag//////////
                if ( $BeginVanToeslagochtendIsInDag && $EindVanToeslagochtendIsInDag) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->ochtendtoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                } elseif ($BeginVanDagIsInOchtendtoeslag && $EindVanDagIsInOchtendtoeslag) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));//


                } elseif ( $BeginVanDagIsInOchtendtoeslag ) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->BeginVanOchtendtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                } elseif ( $EindVanDagIsInOchtendtoeslag ) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->EindVanOchtendtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                } else {
                    $tijd->totaalOchtendToeslagBedrag = null;
                }
            }

            ///////////////////////berekenen van avondtoeslag voor elke dag//////////////////////

            if (!$tijd->toeslagavond){
                $tijd->totaalAvondToeslagBedrag = null;

            } else {

                $beginvantoeslagavond = new Carbon($tijd->toeslagavond->toeslagbegintijd);
                $eindvantoeslagavond = new Carbon($tijd->toeslagavond->toeslageindtijd);

                $tijd->avondtoeslaguren = $beginvantoeslagavond->diffInMinutes($eindvantoeslagavond);

                $BeginVanToeslagavondIsInDag = $beginvantoeslagavond->isBetween($beginvandag, $eindvandag);
                $EindVanToeslagavondIsInDag = $eindvantoeslagavond->isBetween($beginvandag, $eindvandag);

                $BeginVanDagIsInAvondtoeslag =  $beginvandag->isBetween($beginvantoeslagavond, $eindvantoeslagavond);
                $EindVanDagIsInAvondtoeslag =  $eindvandag->isBetween($beginvantoeslagavond, $eindvantoeslagavond);

                $tijd->BeginVanAvondtoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagavond);

                $tijd->EindVanAvondtoeslagurenIsIncompleet = $eindvandag->diffInMinutes($beginvantoeslagavond);


                ///////////als begin en eindtijd van avondtoeslag binnen de ingediende tijd valt, gebruikt het de volle tijd van het ingestelde toeslag//////////
                if ($BeginVanToeslagavondIsInDag && $EindVanToeslagavondIsInDag) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->avondtoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                } elseif ( $BeginVanDagIsInAvondtoeslag && $EindVanDagIsInAvondtoeslag) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                } elseif ( $BeginVanDagIsInAvondtoeslag ) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->BeginVanAvondtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                } elseif ( $EindVanDagIsInAvondtoeslag ) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->EindVanAvondtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                } else {
                    $tijd->totaalAvondToeslagBedrag = null;
                }
            }

            ///////////////////////berekenen van nachttoeslag bedrag voor elke dag////////////////////////////////////
            if (!$tijd->toeslagnacht){
                $tijd->totaalNachtToeslagBedrag = null;

            } else {
                $beginvantoeslagnacht = new Carbon($tijd->toeslagnacht->toeslagbegintijd);
                $eindvantoeslagnacht = new Carbon($tijd->toeslagnacht->toeslageindtijd);

                $tijd->nachttoeslaguren = $beginvantoeslagnacht->diffInMinutes($eindvantoeslagnacht);

                $BeginVanToeslagnachtsInDag = $beginvantoeslagnacht->isBetween($beginvandag, $eindvandag);
                $EindVanToeslagnachtIsInDag = $eindvantoeslagnacht->isBetween($beginvandag, $eindvandag);

                $BeginVanDagIsInNachttoeslag =  $beginvandag->isBetween($beginvantoeslagnacht, $eindvantoeslagnacht);
                $EindVanDagIsInNachttoeslag =  $eindvandag->isBetween($beginvantoeslagnacht, $eindvantoeslagnacht);

                $tijd->BeginVanNachttoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagnacht);

                $tijd->EindVanNachttoeslagurenIsIncompleet =$beginvantoeslagnacht->diffInMinutes($eindvandag);

                ///////////als begin en eindtijd van nachttoeslag binnen de ingediende tijd valt, gebruikt het de volle tijd van het ingestelde toeslag//////////
                if ( $BeginVanToeslagnachtsInDag && $EindVanToeslagnachtIsInDag) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->nachttoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                } elseif ( $BeginVanDagIsInNachttoeslag && $EindVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                } elseif ( $BeginVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->BeginVanNachttoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                } elseif ( $EindVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->EindVanNachttoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                } else {
                    $tijd->totaalNachtToeslagBedrag = null;
                }
            }

            //////////////standaard bedrag (bedrag dat geen toeslag heeft) berekenen//////////////
//            $tijd->totaalstandaardBedrag += ($tarief->bedrag / 60) * ($tijd->uren - $tijd->ochtendtoeslaguren - $tijd->avondtoeslaguren - $tijd->nachttoeslaguren);

            /////waarde van tijd bepalen als er een toeslag wel of niet aanwezig is.
            if ( !$tijd->totaalNachtToeslagBedrag ) {
                $tijd->NachtToelsagTijd = null;
            } else {
                $tijd->NachtToelsagTijd = $tijd->totaalNachtToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagnacht->toeslagpercentage / 100);
            }

            if ( !$tijd->totaalAvondToeslagBedrag ) {
                $tijd->AvondToelsagTijd = null;
            } else {
                $tijd->AvondToelsagTijd = $tijd->totaalAvondToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagavond->toeslagpercentage / 100);
            }

            if ( !$tijd->totaalOchtendToeslagBedrag ) {
                $tijd->OchtendToelsagTijd = null;
            } else {
                $tijd->OchtendToelsagTijd = $tijd->totaalOchtendToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagochtend->toeslagpercentage / 100);
            }



            $tijd->totaalstandaardBedrag += ($tarief->bedrag / 60) * ($tijd->uren - $tijd->NachtToelsagTijd - $tijd->AvondToelsagTijd - $tijd->OchtendToelsagTijd );



            $tijd->totaalBedrag += $tijd->totaalOchtendToeslagBedrag + $tijd->totaalAvondToeslagBedrag + $tijd->totaalNachtToeslagBedrag + $tijd->totaalstandaardBedrag;

            $tijd->btw += $tijd->totaalBedrag * 0.21;

            $tijd->uitbetaling += $tijd->btw + $tijd->totaalBedrag;

////////      Bedragen voor het maand
            $maandTotaalBedrag += $tijd->totaalBedrag;
            $maandbtw += $tijd->btw;
            $maanduitbetaling += $tijd->uitbetaling;
        }


//////////////factuur mailen naar//////////////////////////////////////////////////////////////
        //  $bedrijven = auth()->user()->bedrijven;
        // $brouwerscontacten = auth()->user()->brouwerscontacten;
///////////////////////////////////////////////////////////////////////////////////////////////

        //$pdf = PDF::loadView('layouts.user.functietoevoegen.factuur.pdf', compact( 'fdate', 'sdate', 'tijden', 'request'));
        $data["email"] = "gijs@thedarecompany.com";
        $data["title"] = "From ItSolutionStuff.com";
        $data["body"] = "This is Demo";

///////////////////wordt gebruikt voor het verzenden van de factuur////////////////////
//        sturen naar klant email
        $email = $bedrijf->email;
//        sturen naar CC: e-mail(brouwers)
        $bemail = \Auth::user()->brouwerscontact->email;
//        subject
        $subject = "Factuur van {$bedrijf->user->name} {$bedrijf->user->tussenvoegsel} {$bedrijf->user->achternaam} voor de periode {$factuur->startdatum->format('d-m-Y')} t/m {$factuur->einddatum->format('d-m-Y')}";
//        sendPDF name
        $sendpdfnaam = "Factuur-".$factuur->naam.".pdf";
//        invoice maand
        $invoicemaand = "{$factuur->startdatum->format('d-m-Y')} t/m {$factuur->einddatum->format('d-m-Y')}";
//        sender
        $sender = "{$user->name} {$user->tussenvoegsel} {$user->achternaam}";
//        ontvanger
        $ontvanger = $bedrijf->contactpersoon;



        $pdf = PDF::loadView('layouts.user.functietoevoegen.factuur.pdf', compact( 'fdate', 'sdate', 'tijden', 'request', 'uren', 'ochtendtoeslaguren', 'avondtoeslaguren', 'nachttoeslaguren', 'maandTotaalBedrag', 'totaalOchtendToeslagBedrag', 'totaalAvondToeslagBedrag', 'totaalNachtToeslagBedrag', 'totaalstandaardBedrag', 'toeslag', 'toonuren', 'toontoeslaguren', 'bedrijf', 'bedrijven', 'brouwerscontacten',  'user', 'maandbtw', 'maanduitbetaling', 'factuur'));
        $pdf->setPaper('a4');

        Mail::send(new InvoiceMail($email, $bemail, $subject, $sendpdfnaam, $invoicemaand, $sender, $ontvanger, $pdf->output()));
//        $subject,

//        Mail::send(['layouts.user.functietoevoegen.factuur.pdf', compact( 'fdate', 'sdate', 'tijden', 'request', 'uren', 'toeslaguren', 'totaalBedrag', 'totaalToeslagBedrag', 'totaalstandaardBedrag', 'toeslag', 'toonuren', 'toontoeslaguren', 'bedrijf', 'bedrijven')], $data, function($message)use($data, $pdf) {
//            $message->to($data["email"], $data["email"])
//
//                ->subject($data["title"])
//
//                ->attachData($pdf->output(), "invoice.pdf");
//
//        });


        //      dd('factuur is verzonden');
//        dd($brouwerscontact);
//      return $pdf->stream('invoice.pdf');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function downloadPDF(Request $request, Factuur $factuur)
    {

        $user = auth()->user();
        $bedrijf = $factuur->bedrijf;

        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();

        $sdate = $factuur->startdatum;
        $fdate = $factuur->einddatum;

        $tijden = Tijd::selectRaw('tijden.datum AS tijden_datum, toeslagochtend.datum AS toeslagochtend_datum, toeslagavond.datum AS toeslagavond_datum, toeslagnacht.datum AS toeslagnacht_datum, toeslagochtend.*, toeslagavond.*, toeslagnacht.*, tijden.*, TIMESTAMPDIFF(HOUR, begintijd, eindtijd) as uren')
//        $tijden = Tijd::selectRaw('tijden.datum AS tijden_datum, tijden.*, TIMESTAMPDIFF(HOUR, begintijd, eindtijd) as uren')

            ->leftJoin('toeslagen as toeslagochtend', function(\Illuminate\Database\Query\JoinClause $join) {
                $join->on('tijden.toeslag_idochtend', '=', 'toeslagochtend.id');
                $join->on('toeslagochtend.user_id', '=', 'tijden.user_id');
            })
            ->leftJoin('toeslagen as toeslagavond', function(\Illuminate\Database\Query\JoinClause$join) {
                $join->on('tijden.toeslag_idavond', '=', 'toeslagavond.id');
                $join->on('toeslagavond.user_id', '=', 'tijden.user_id');
            })
            ->leftJoin('toeslagen as toeslagnacht', function(\Illuminate\Database\Query\JoinClause$join) {
                $join->on('tijden.toeslag_idnacht', '=', 'toeslagnacht.id');
                $join->on('toeslagnacht.user_id', '=', 'tijden.user_id');
            })
//            ->leftJoin('toeslagen as toeslagochtend', 'tijden.toeslag_idochtend', '=', 'toeslagochtend.id')
//            ->leftJoin('toeslagen as toeslagavond', 'tijden.toeslag_idavond', '=', 'toeslagavond.id')
//            ->leftJoin('toeslagen as toeslagnacht', 'tijden.toeslag_idnacht', '=', 'toeslagnacht.id')

            ->leftJoin('bedrijven', 'tijden.bedrijf_id', '=', 'bedrijven.id')

            //            tarief voor tijd en toeslag
            ->leftJoin('tarieven', 'tijden.tarief_id', '=', 'tarieven.id')
            //            user info voor tijd en toeslag
            ->leftJoin('users', 'tijden.user_id', '=', 'users.id')

//            ->leftJoin('users', 'tarieven.user_id', '=', 'users.id')


            ->whereBetween('tijden.datum', [$sdate, $fdate])

            ->where('tijden.bedrijf_id', [$bedrijf->id])
            ->where('bedrijven.user_id', auth()->user()->id)

//            ->where('toeslagochtend.user_id', auth()->user()->id)
//            ->where('toeslagavond.user_id', auth()->user()->id)
//            ->where('toeslagnacht.user_id', auth()->user()->id)

            //            tarief voor user
            ->where('tarieven.user_id', auth()->user()->id)
            //              userinfoz
            ->where('users.id', auth()->user()->id)

            ->get();

        $maanduitbetaling = 0;
        $maandbtw = 0;
        $maandTotaalBedrag = 0;

        $totaalOchtendToeslagBedrag = 0;
        $totaalAvondToeslagBedrag = 0;
        $totaalNachtToeslagBedrag = 0;

        $totaalstandaardBedrag = 0;

        /////////variable voor alle minuten van het hele dag// tussen begin en eindtijd/////
        $uren = 0;

        $ochtendtoeslaguren = 0;
        $avondtoeslaguren = 0;
        $nachttoeslaguren = 0;

        $toonuren = 0;
        $toontoeslaguren = 0;

        /////////variable voor het hele dag// tussen begin en eind tijd/////
        $dag = new Carbon();
//dd($tijden);
        foreach($tijden as $tijd) {
            $toeslag = Toeslag::selectRaw('*, TIMESTAMPDIFF(HOUR, toeslagbegintijd, toeslageindtijd) as toeslagauren')->where('id', $tijd->toeslag_idochtend)
                ->where('id', $tijd->toeslag_idavond)
                ->where('id', $tijd->toeslag_idnacht)

                ->where('toeslagen.user_id', auth()->user()->id)
                ///////////////////aparte queries maken voor elke toeslag//////////////////////
//                ->where('toeslagochtend.user_id', auth()->user()->id)
//                ->where('toeslagavond.user_id', auth()->user()->id)
//                ->where('toeslagnacht.user_id', auth()->user()->id)
                ->first();

//            tarief per tijd en toeslag
            $tarief = \Auth::user()->tarief()
                ->where('id', $tijd->tarief_id)
                ->where('tarieven.user_id', auth()->user()->id)
//                ->where('tarieven.user_id', auth()->user()->id)
                ->first();

///////////////////////////////////////////////////////gebruiken voor nieuwe berekening/////////////////14-12-2022///////////////////////////
//            $tijdBeginDatum = Carbon::createFromFormat('Y-m-d H:i:s', $tijd->tijden_datum.' '.$tijd->begintijd);
//            $tijdEindDatum = Carbon::createFromFormat('Y-m-d H:i:s', $tijd->tijden_datum.' '.$tijd->eindtijd);
//
//            $startAvond = Carbon::createFromFormat('Y-m-d H:i:s', $tijd->tijden_datum.' 18:00:00');
//
//            if() { // Toeslang niet bestaat
//                 100%
//            } elseif($tijdBeginDatum->isWeekend()) {
//                 weekend tarief
//            } else {
//
//                 dagtarief = verschil tussen $tijdBeginDatum en $startAvond
//                 avondtarief = verschil tussen $startAvond en $tijdEindDatum
//
//            }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////uren in minuten berekenen/////////////////////
            $beginvandag = new Carbon($tijd->begintijd);
            $eindvandag = new Carbon($tijd->eindtijd);

            ////////////alle minuten van een ingediende dag////////////
            $tijd->uren = $beginvandag->diffInMinutes($eindvandag);



//////////////////uren in uren tonen/////////////////////
//            $tijd->toonuren = $start->diffInHours($end);

//////////////////toeslaguren in minuten berekenen/////////////////////
//            $starttoe = new Carbon($toeslag->toeslagbegintijd);
//            $endtoe = new Carbon($toeslag->toeslageindtijd);

//            $tijd->toeslaguren = $starttoe->diffInMinutes($endtoe);


            /////////carbon voor het begin en eindtijd van alle drie toeslagen. wordt gebruikt in berekening/////////////





           ///////alle minuten van elk verschillend toeslag (die door de Brouwers medewerker is ingesteld)/////

            ///////////tussen begin en eind tijd van de ingediende dag////////////
//            $geregistreerdedag = $dag->isBetween($start, $end);

 //////////////////////////vergelijking die in de if statement voor bet berkenen van elke toeslag wordt gebruikt.////////////
            ///////////als de begin en eindtijd van toeslagochtend binnen het geregistreerde dag is/////////////


            ///////////als de begin en eindtijd van toeslagavond binnen het geregistreerde dag is/////////////


            ///////////als de begin en eindtijd van toeslagnacht binnen het geregistreerde dag is/////////////


 ///////////////////vergelijking die in de if statement voor bet berkenen van elke toeslag wordt gebruikt.////////////
            ///////////als de begin en eindtijd van het dag binnen het begin en eindtijd van ochtendtoeslag is geregistreerd/////////////


            ///////////als de begin en eindtijd van het dag binnen het begin en eindtijd van avondtoeslag is geregistreerd/////////////


            ///////////als de begin en eindtijd van het dag binnen het begin en eindtijd van nachttoeslag is geregistreerd/////////////



///////////////////vergelijking die in de if statement voor bet berkenen van elke toeslag wordt gebruikt.////////////
///////////als alleen het begin van het dag binnen het begin en eindtijd van ochtendtoeslag is geregistreerd/////////////

///////////als alleen het begin van het dag binnen het begin en eindtijd van avondtoeslag is geregistreerd/////////////

///////////als alleen het begin van het dag binnen het begin en eindtijd van nachttoeslag is geregistreerd/////////////


///////////////////vergelijking die in de if statement voor bet berkenen van elke toeslag wordt gebruikt.////////////
///////////als alleen het begin van het dag binnen het begin en eindtijd van ochtendtoeslag is geregistreerd/////////////

///////////als alleen het begin van het dag binnen het begin en eindtijd van avondtoeslag is geregistreerd/////////////

///////////als alleen het begin van het dag binnen het begin en eindtijd van nachttoeslag is geregistreerd/////////////

//////////////////berekening voor elk dag van de gekozen maand. factuur berekening///////////////////



            /////////////toeslagen voor elke dag berekenen//////////////
            ///////////////////////berekenen van avondtoeslag voor elke dag////////////////////////////////////

          if (!$tijd->toeslagochtend){
              $tijd->totaalOchtendToeslagBedrag = null;

          } else {

              $beginvantoeslagochtend = new Carbon($tijd->toeslagochtend->toeslagbegintijd);
              $eindvantoeslagochtend = new Carbon($tijd->toeslagochtend->toeslageindtijd);

              $tijd->ochtendtoeslaguren = $beginvantoeslagochtend->diffInMinutes($eindvantoeslagochtend);

              $BeginVanToeslagochtendIsInDag = $beginvantoeslagochtend->isBetween($beginvandag, $eindvandag);
              $EindVanToeslagochtendIsInDag = $eindvantoeslagochtend->isBetween($beginvandag, $eindvandag);

              $BeginVanDagIsInOchtendtoeslag =  $beginvandag->isBetween($beginvantoeslagochtend, $eindvantoeslagochtend);
              $EindVanDagIsInOchtendtoeslag =  $eindvandag->isBetween($beginvantoeslagochtend, $eindvantoeslagochtend);

              $tijd->BeginVanOchtendtoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagochtend);

              $tijd->EindVanOchtendtoeslagurenIsIncompleet = $eindvandag->diffInMinutes($beginvantoeslagochtend);

              ///////////als begin en eindtijd van ochtendtoeslag binnen de ingediende tijd valt, gebruikt het de volle tijd van het ingestelde toeslag//////////
                if ( $BeginVanToeslagochtendIsInDag && $EindVanToeslagochtendIsInDag) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->ochtendtoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                } elseif ($BeginVanDagIsInOchtendtoeslag && $EindVanDagIsInOchtendtoeslag) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));//


                } elseif ( $BeginVanDagIsInOchtendtoeslag ) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->BeginVanOchtendtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                } elseif ( $EindVanDagIsInOchtendtoeslag ) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->EindVanOchtendtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                } else {
                    $tijd->totaalOchtendToeslagBedrag = null;
                }
          }

            ///////////////////////berekenen van avondtoeslag voor elke dag//////////////////////

            if (!$tijd->toeslagavond){
                $tijd->totaalAvondToeslagBedrag = null;

            } else {

                $beginvantoeslagavond = new Carbon($tijd->toeslagavond->toeslagbegintijd);
                $eindvantoeslagavond = new Carbon($tijd->toeslagavond->toeslageindtijd);

                $tijd->avondtoeslaguren = $beginvantoeslagavond->diffInMinutes($eindvantoeslagavond);

                $BeginVanToeslagavondIsInDag = $beginvantoeslagavond->isBetween($beginvandag, $eindvandag);
                $EindVanToeslagavondIsInDag = $eindvantoeslagavond->isBetween($beginvandag, $eindvandag);

                $BeginVanDagIsInAvondtoeslag =  $beginvandag->isBetween($beginvantoeslagavond, $eindvantoeslagavond);
                $EindVanDagIsInAvondtoeslag =  $eindvandag->isBetween($beginvantoeslagavond, $eindvantoeslagavond);

                $tijd->BeginVanAvondtoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagavond);

                $tijd->EindVanAvondtoeslagurenIsIncompleet = $eindvandag->diffInMinutes($beginvantoeslagavond);


                ///////////als begin en eindtijd van avondtoeslag binnen de ingediende tijd valt, gebruikt het de volle tijd van het ingestelde toeslag//////////
                if ($BeginVanToeslagavondIsInDag && $EindVanToeslagavondIsInDag) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->avondtoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                } elseif ( $BeginVanDagIsInAvondtoeslag && $EindVanDagIsInAvondtoeslag) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                } elseif ( $BeginVanDagIsInAvondtoeslag ) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->BeginVanAvondtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                } elseif ( $EindVanDagIsInAvondtoeslag ) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->EindVanAvondtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                } else {
                    $tijd->totaalAvondToeslagBedrag = null;
                }
            }

            ///////////////////////berekenen van nachttoeslag bedrag voor elke dag////////////////////////////////////
            if (!$tijd->toeslagnacht){
                $tijd->totaalNachtToeslagBedrag = null;

            } else {
                $beginvantoeslagnacht = new Carbon($tijd->toeslagnacht->toeslagbegintijd);
                $eindvantoeslagnacht = new Carbon($tijd->toeslagnacht->toeslageindtijd);

                $tijd->nachttoeslaguren = $beginvantoeslagnacht->diffInMinutes($eindvantoeslagnacht);

                $BeginVanToeslagnachtsInDag = $beginvantoeslagnacht->isBetween($beginvandag, $eindvandag);
                $EindVanToeslagnachtIsInDag = $eindvantoeslagnacht->isBetween($beginvandag, $eindvandag);

                $BeginVanDagIsInNachttoeslag =  $beginvandag->isBetween($beginvantoeslagnacht, $eindvantoeslagnacht);
                $EindVanDagIsInNachttoeslag =  $eindvandag->isBetween($beginvantoeslagnacht, $eindvantoeslagnacht);

                $tijd->BeginVanNachttoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagnacht);

                $tijd->EindVanNachttoeslagurenIsIncompleet =$beginvantoeslagnacht->diffInMinutes($eindvandag);

                ///////////als begin en eindtijd van nachttoeslag binnen de ingediende tijd valt, gebruikt het de volle tijd van het ingestelde toeslag//////////
                if ( $BeginVanToeslagnachtsInDag && $EindVanToeslagnachtIsInDag) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->nachttoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                } elseif ( $BeginVanDagIsInNachttoeslag && $EindVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                } elseif ( $BeginVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->BeginVanNachttoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                } elseif ( $EindVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->EindVanNachttoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                } else {
                    $tijd->totaalNachtToeslagBedrag = null;
                }
            }

            //////////////standaard bedrag (bedrag dat geen toeslag heeft) berekenen//////////////
//            $tijd->totaalstandaardBedrag += ($tarief->bedrag / 60) * ($tijd->uren - $tijd->ochtendtoeslaguren - $tijd->avondtoeslaguren - $tijd->nachttoeslaguren);

            /////waarde van tijd bepalen als er een toeslag wel of niet aanwezig is.
           if ( !$tijd->totaalNachtToeslagBedrag ) {
                $tijd->NachtToelsagTijd = null;
           } else {
               $tijd->NachtToelsagTijd = $tijd->totaalNachtToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagnacht->toeslagpercentage / 100);
           }

            if ( !$tijd->totaalAvondToeslagBedrag ) {
                $tijd->AvondToelsagTijd = null;
            } else {
                $tijd->AvondToelsagTijd = $tijd->totaalAvondToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagavond->toeslagpercentage / 100);
            }

            if ( !$tijd->totaalOchtendToeslagBedrag ) {
                $tijd->OchtendToelsagTijd = null;
            } else {
                $tijd->OchtendToelsagTijd = $tijd->totaalOchtendToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagochtend->toeslagpercentage / 100);
            }



            $tijd->totaalstandaardBedrag += ($tarief->bedrag / 60) * ($tijd->uren - $tijd->NachtToelsagTijd - $tijd->AvondToelsagTijd - $tijd->OchtendToelsagTijd );



            $tijd->totaalBedrag += $tijd->totaalOchtendToeslagBedrag + $tijd->totaalAvondToeslagBedrag + $tijd->totaalNachtToeslagBedrag + $tijd->totaalstandaardBedrag;

            $tijd->btw += $tijd->totaalBedrag * 0.21;

            $tijd->uitbetaling += $tijd->btw + $tijd->totaalBedrag;

////////      Bedragen voor het maand
            $maandTotaalBedrag += $tijd->totaalBedrag;
            $maandbtw += $tijd->btw;
            $maanduitbetaling += $tijd->uitbetaling;
        }

//        dd( $tijd->totaalstandaardBedrag);
//        download pdf naam
        $downloadpdfnaam = "Factuur-".$factuur->naam.".pdf";

;
        //$pdf = PDF::loadView('layouts.user.functietoevoegen.factuur.pdf', compact( 'fdate', 'sdate', 'tijden', 'request'));
        $pdf = PDF::loadView('layouts.user.functietoevoegen.factuur.pdf', compact( 'fdate', 'sdate', 'tijden', 'request', 'uren', 'ochtendtoeslaguren', 'avondtoeslaguren', 'nachttoeslaguren','maandTotaalBedrag', 'totaalOchtendToeslagBedrag', 'totaalAvondToeslagBedrag', 'totaalNachtToeslagBedrag', 'totaalstandaardBedrag', 'toonuren', 'bedrijf', 'bedrijven', 'user', 'maandbtw', 'maanduitbetaling', 'factuur' ));
        $pdf->setPaper('a4');

//        dd($tijden);
        return $pdf->stream($downloadpdfnaam);


    }

}
