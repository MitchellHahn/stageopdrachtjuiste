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

        $tijden = DB::table('tijden')->leftJoin('toeslagen', 'tijden.toeslag_id', '=', 'toeslagen.id')
            ->leftJoin('bedrijven', 'tijden.bedrijf_id', '=', 'bedrijven.id')

            /////////////datum invoer controleren bij tabel tijden////////////
            ->whereBetween('tijden.datum', [$sdate, $fdate])

            /////////////bedrijf invoer controleren////////////
            ->where('tijden.bedrijf_id', [$bedrijf->id])
            /////////////bedrijf invoer filteren op user////////////
            ->where('bedrijven.user_id', auth()->user()->id)

            /////////tijden zoeken bij toeslagen van de gebruiker/////////
            ->where('toeslagen.user_id', auth()->user()->id)
            ////////datum van tabel tijden en toeslagen onderscheiden////////
            ->get(['tijden.datum AS tijden_datum', 'toeslagen.datum AS toeslagen_datum', 'toeslagen.*', 'tijden.*']);
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
//        $fdate = $request->fdate;
//        $sdate = $request->sdate;
        $user = auth()->user();
        $bedrijf = $factuur->bedrijf;

//        $bedrijven = auth()->user()->bedrijven;
        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();

        //////////////////////////
        //   $brouwerscontacten = auth()->user()->brouwerscontacten;

        //////////////////////////
//        $year = $request->year;
//        $month = $request->month;

//        dd($request->year, $request->month);

//        $sdate = Carbon::createFromDate($year, $month)->startOfMonth();
//        $fdate = Carbon::createFromDate($year, $month)->endOfMonth();
        $sdate = $factuur->startdatum;
        $fdate = $factuur->einddatum;

        $tijden = Tijd::selectRaw('tijden.datum AS tijden_datum, toeslagen.datum AS toeslagen_datum, toeslagen.*, tijden.*, TIMESTAMPDIFF(HOUR, begintijd, eindtijd) as uren')
            ->leftJoin('toeslagen', 'tijden.toeslag_id', '=', 'toeslagen.id')
            ->leftJoin('bedrijven', 'tijden.bedrijf_id', '=', 'bedrijven.id')

            //            tarief voor tijd en toeslag
            ->leftJoin('tarieven', 'toeslagen.tarief_id', '=', 'tarieven.id')

            //            user info voor tijd en toeslag
            ->leftJoin('users', 'toeslagen.user_id', '=', 'users.id')

            ->whereBetween('tijden.datum', [$sdate, $fdate])

            ->where('tijden.bedrijf_id', [$bedrijf->id])
            ->where('bedrijven.user_id', auth()->user()->id)

            ->where('toeslagen.user_id', auth()->user()->id)

            //            tarief voor user
            ->where('tarieven.user_id', auth()->user()->id)
            //              userinfo
            ->where('users.id', auth()->user()->id)

            ->get();
        //////////////////////////////////////////////////////
        $brouwerscontacten = DB::table('brouwerscontacten')


//            ->leftJoin('users', 'brouwerscontacten.user_id', '=', 'user.id')
            //       ->where('brouwerscontacten.user_id', [$user->id])

//        $brouwerscontacten = Brouwerscontact::where('user_id', auth()->user()->id)->get()

//            ->where('brouwerscontacten.user_id', [$brouwerscontact->id])

            ->where('brouwerscontacten.user_id', auth()->user()->id)
            ->get();
        //////////////////////////////////////////////////////


//        dd($tijden, \Auth::user()->id, $sdate->format('Y-m-d'), $fdate->format('Y-m-d'));
//        $tijden = Tijd::whereBetween('datum', [$request->fdate, $request->sdate])->get();
        $maanduitbetaling = 0;
        $maandbtw = 0;
        $maandTotaalBedrag = 0;
        $totaalToeslagBedrag = 0;
        $totaalstandaardBedrag = 0;
        $uren = 0;
        $toeslaguren = 0;
        $toonuren = 0;
        $toontoeslaguren = 0;

        foreach($tijden as $tijd) {
            $toeslag = Toeslag::selectRaw('*, TIMESTAMPDIFF(HOUR, toeslagbegintijd, toeslageindtijd) as toeslagauren')->where('id', $tijd->toeslag_id)
                ->where('toeslagen.user_id', auth()->user()->id)
                ->first();

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

//            $tijd->btw += $tijd->totaalBedrag * 0.21;
//            $tijd->btw = round($tijd->btw, 2);

//            $tijd->uitbetaling += $tijd->btw + $tijd->totaalBedrag;
//            $tijd->uitbetaling = round($tijd->uitbetaling, 2);

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



        $pdf = PDF::loadView('layouts.user.functietoevoegen.factuur.pdf', compact( 'fdate', 'sdate', 'tijden', 'request', 'uren', 'toeslaguren', 'maandTotaalBedrag', 'totaalToeslagBedrag', 'totaalstandaardBedrag', 'toeslag', 'toonuren', 'toontoeslaguren', 'bedrijf', 'bedrijven', 'brouwerscontacten',  'user', 'maandbtw', 'maanduitbetaling', 'factuur'));
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
//        $fdate = $request->fdate;
//        $sdate = $request->sdate;
        $user = auth()->user();
        $bedrijf = $factuur->bedrijf;

//        $bedrijven = auth()->user()->bedrijven;
        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();

//        dd($request->year, $request->month);

        $sdate = $factuur->startdatum;
        $fdate = $factuur->einddatum;

        $tijden = Tijd::selectRaw('tijden.datum AS tijden_datum, toeslagen.datum AS toeslagen_datum, toeslagen.*, tijden.*, TIMESTAMPDIFF(HOUR, begintijd, eindtijd) as uren')
            ->leftJoin('toeslagen', 'tijden.toeslag_id', '=', 'toeslagen.id')
            ->leftJoin('bedrijven', 'tijden.bedrijf_id', '=', 'bedrijven.id')

            //            tarief voor tijd en toeslag
            ->leftJoin('tarieven', 'toeslagen.tarief_id', '=', 'tarieven.id')
            //            user info voor tijd en toeslag
            ->leftJoin('users', 'toeslagen.user_id', '=', 'users.id')
//            ->leftJoin('users', 'tarieven.user_id', '=', 'users.id')


            ->whereBetween('tijden.datum', [$sdate, $fdate])

            ->where('tijden.bedrijf_id', [$bedrijf->id])
            ->where('bedrijven.user_id', auth()->user()->id)

            ->where('toeslagen.user_id', auth()->user()->id)

            //            tarief voor user
            ->where('tarieven.user_id', auth()->user()->id)
            //              userinfoz
            ->where('users.id', auth()->user()->id)

            ->get();

//        dd($tijden, \Auth::user()->id, $sdate->format('Y-m-d'), $fdate->format('Y-m-d'));
//        $tijden = Tijd::whereBetween('datum', [$request->fdate, $request->sdate])->get();
        $maanduitbetaling = 0;
        $maandbtw = 0;
        $maandTotaalBedrag = 0;
        $totaalToeslagBedrag = 0;
        $totaalstandaardBedrag = 0;
        $uren = 0;
        $toeslaguren = 0;
        $toonuren = 0;
        $toontoeslaguren = 0;

        foreach($tijden as $tijd) {
            $toeslag = Toeslag::selectRaw('*, TIMESTAMPDIFF(HOUR, toeslagbegintijd, toeslageindtijd) as toeslagauren')->where('id', $tijd->toeslag_id)
                ->where('toeslagen.user_id', auth()->user()->id)
                ->first();

//            tarief per tijd en toeslag
            $tarief = \Auth::user()->tarief()
                ->where('id', $toeslag->tarief_id)
                ->where('tarieven.user_id', auth()->user()->id)
//                ->where('tarieven.user_id', auth()->user()->id)
                ->first();

//            user per tijd en toeslag
//            $user = \Auth::user()
//                ->where('id', $toeslag->user_id)
//                ->where('id', $tarief->user_id)
//                ->where('tarieven.user_id', auth()->user()->id)
//                ->where('toeslagen.user_id', auth()->user()->id)
//                ->first();

//if ('tijden.datum') == Carbon::getWeekendDays())
//            ->whereBetween('tijden.datum', [$sdate, $fdate])
//
//
//  if ($tijden->datum == Carbon::getWeekendDays()
//            ->whereBetween('tijden.datum', [$sdate, $fdate]);


//            if ($tijden->datum->isWeeknd == Carbon::getWeekendDays()
//            ->whereBetween('tijden.datum', [$sdate, $fdate]);

//            dd($tijd->tijden_datum.' '.$tijd->begintijd);


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

////////      Bedragen voor het maand
            $maandTotaalBedrag += $tijd->totaalBedrag;
            $maandbtw += $tijd->btw;
            $maanduitbetaling += $tijd->uitbetaling;
        }

//        download pdf naam
        $downloadpdfnaam = "Factuur-".$factuur->naam.".pdf";


        //$pdf = PDF::loadView('layouts.user.functietoevoegen.factuur.pdf', compact( 'fdate', 'sdate', 'tijden', 'request'));
        $pdf = PDF::loadView('layouts.user.functietoevoegen.factuur.pdf', compact( 'fdate', 'sdate', 'tijden', 'request', 'uren', 'toeslaguren', 'maandTotaalBedrag', 'totaalToeslagBedrag', 'totaalstandaardBedrag', 'toonuren', 'toontoeslaguren', 'bedrijf', 'bedrijven', 'user', 'maandbtw', 'maanduitbetaling', 'factuur'));
        $pdf->setPaper('a4');

//        dd($tijden);
        return $pdf->stream($downloadpdfnaam);


    }
}
