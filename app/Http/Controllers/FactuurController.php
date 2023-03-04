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
     * Deze toont de venster waarin de e-mailadress van de brouwers contactpseroon wordt aangemaakt, wanneer een factuur wordt verzonden.
     * Dit wordt opgeslagen in tabel "Brouwers contacten"
     *
     * @return \Illuminate\Http\Response
     */
    public function CC_aanmaken(Request $request) {

        // stuurt de klant (bedrijf) mee omdat de factuur voor de klant is aangemaakt
        $bedrijfId = $request->bedrijf;

        return view('layouts.user.functietoevoegen.factuur.cc_e-mail_doorgeven', compact('bedrijfId'));
    }


    /**
     * Deze functie slaat de gegevens in de "Brouwers contactpersoon aanmaken" venster zijn ingevoert, op in tabel "brouwers contacten"
     * De e-mailadres van deze persoon zal in de CC staan van elke e-mail dat wordt gestuurd.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CC_opslaan(Request $request)
    {
        // haalt de ingevoerde gegevens van de Brouwers contactpersoon op
        $request->validate([
            //tabel brouwerscontacten
            'email' => 'required',

        ]);

        // maakt een nieuwe brouwers contactpersoon aan met de registreerde gegevens
        $brouwerscontact = new Brouwerscontact($request->all());

        // slaat de brouwers contactpersoon op en verbindt het met de ingelogde gebruiker
        Auth::user()->brouwerscontact()->save($brouwerscontact);

        return redirect()->route('Factuurmaand.uren_van_maand_tonen', ['brouwerscontact' => $brouwerscontact, 'bedrijf' => $request->bedrijf])
            ->with('success', 'Brouwers contact info is aangepast');
    }


    /**
     * Deze toont de venster waarin de e-mailadres van de brouwers contactpseroon wordt aangepast.
     *
     * @param  Brouwerscontact $brouwerscontact
     * @return \Illuminate\Http\Response
     */
    public function CC_wijzigen(Request $request, Brouwerscontact $brouwerscontact)
    {
        // stuurt de klant (bedrijf) mee omdat de factuur voor de klant is aangemaakt
        $bedrijfId = $request->bedrijf;


        return view('layouts.user.functietoevoegen.factuur.cc_e-mail_doorgeven', compact('brouwerscontact', 'bedrijfId'));
    }


    /**
     * Deze functie slaat de  nieuwe gegevens dat in de "Brouwers contactpersoon aanmaken" venster zijn ingevoert, op in tabel "brouwers contacten"
     * De nieuwe ingevoerde gegevens zullen de huidige gegevens vervangen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brouwerscontact $brouwerscontact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function CC_wijziging_opslaan(Request $request, Brouwerscontact $brouwerscontact)
    {
        // haalt de ingevoerde gegevens van de Brouwers contactpersoon op
        $request->validate([
            //tabel brouwerscontacten
            'email' => 'required',

        ]);

        // vervangt de huidige gegevens van de Brouwers contactpersoon met de nieuwe gegevens
        \Auth::user()->brouwerscontact->id;
        $brouwerscontact->update($request->all());

        return redirect()->route('Factuurmaand.uren_van_maand_tonen', ['brouwerscontact' => $brouwerscontact, 'bedrijf' => $request->bedrijf])
            ->with('success', 'Brouwers contact info is aangepast');
    }


    /**
     * Deze functie verwijdert de e-maildres van de Brouwers contact persoon.
     *
     * @param  \App\Models\Brouwerscontact  $brouwerscontact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function CC_verwijderen(Brouwerscontact  $brouwerscontact)
    {
        // verwijder de e-maildres van de Brouwers contactpersoon van tabel "Brouwers contacten"
        $brouwerscontact->delete();

        return redirect()->route('Factuuremail.destroy', [$brouwerscontact])
            ->with('success', 'Brouwers contact info is verwijderd');
    }
/////////////////////////Brouwers CC: email///////END///////////////////////////

    /**
     * Deze functie toont de gemaakt facturen dat voor de gekozen klant is gemaakt.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function gemaakte_facturen_van_klant_tonen(Request $request, Bedrijf $bedrijf)
    {
        //de gemaakte facturen dat voor de gekozen klant zijn aangemaakt, zoeken en tonen
        $facturen = DB::table('facturen')->leftJoin('bedrijven', 'facturen.bedrijf_id', '=', 'bedrijven.id')
            ->where('facturen.bedrijf_id', [$bedrijf->id])
            ->where('bedrijven.user_id', auth()->user()->id)
            ->get();

        //venster voor het doorgeven van maand en jaar, tonen
        return view('layouts.user.functietoevoegen.factuur.maand_en_jaar_doorgeven', compact('facturen', 'bedrijf'));

    }


    /**
     * Deze functie toont alle geregistreerde facuteren voor de gekozen klant.
     * Slaat de gegevens van de factuur op in tabel (facturen) van de periode dat is geslecteeerd
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function uren_van_maand_tonen(Request $request, Bedrijf $bedrijf)
    {

        ///////////////////uren voor gekozen maand en bedrijf zoeken/////////////

        //klant (bedrijf) gegevens opsturen zodat de gewerkte dagen van deze bedrijf gebruikt kan worden
        $bedrijven = auth()->user()->bedrijven;

        // haalt de ingevoerd maand en jaar op
        $year = $request->year;
        $month = $request->month;

        // carbon variable maken voor het periode van de factuur zodat er binnen deze periode naar de gewerkte dagen kan worden gezogd
        $sdate = Carbon::createFromDate($year, $month)->startOfMonth();
        $fdate = Carbon::createFromDate($year, $month)->endOfMonth();


        // gegevens ophalen van tabel tijden
        $tijden = DB::table('tijden')

            // tabel tijden leftjoinen met de drie toeslagen (vreemde sleutels), zodat de gekoppelde toeslag gebruikt kan worden.
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

            // tijd verbinden met de bedrijf
            ->leftJoin('bedrijven', 'tijden.bedrijf_id', '=', 'bedrijven.id')

            // zoeken naar de datum van alle gegiregistreerde dagen voor de doorgegeven periode
            ->whereBetween('tijden.datum', [$sdate, $fdate])

            //tijden op zoeken dat gekopplt zijn aan het bedrijf
            ->where('tijden.bedrijf_id', [$bedrijf->id])

            // bedrijf zoeken dat gekoppelt is aan de gebruiker
            ->where('bedrijven.user_id', auth()->user()->id)

            ->get(['tijden.datum AS tijden_datum', 'toeslagochtend.datum AS toeslagochtend_datum', 'toeslagavond.datum AS toeslagavond_datum', 'toeslagnacht.datum AS toeslagnacht_datum', 'toeslagochtend.*', 'toeslagavond.*', 'toeslagnacht.*', 'tijden.*']);


        /////////////maand en jaar in tabel "factuur" opslaan wanneer knop wordt gedrukt////////////

        if(count($tijden) >= 1) {

            // in de "user_id" vreemde sleutel van tabel "tijden", naar de "id" van de gebruiker
            $user_id = auth()->user()->id;

            // all gewerkte tijden op zoeken in het begin van en periode en aan het eind van de periode
            $startDatum = Carbon::createFromDate($year, $month, 1);
            $eindDatum = Carbon::createFromDate($year, $month)->endOfMonth();

            // gewerkte tijden opzoeken voor de gekozen jaar
            $currentYear = $startDatum->format('Y');

            // factuur naam
            $laatsteFactuur = Factuur::whereRaw('YEAR(startdatum) = ?', $currentYear)
                ->where('user_id', '=', Auth::user()->id)
                ->orderByRaw('LENGTH(naam) DESC')
                ->orderByDesc('naam')
                ->first();

            // de factuur nummer wordt met 1 verhoogd wanneer er een niwue factuur wordt gemaakt voor de zelfde klant
            if($laatsteFactuur) {
                $latestInvoiceId = $laatsteFactuur->naam;
                $latestNr = substr($latestInvoiceId, strpos($latestInvoiceId, '-') + 1);
                $name = $currentYear.'-'.sprintf('%04d', ((int)$latestNr + 1));
            } else {
                $name = $currentYear.'-0001';
            }

            // factuur gegevens opslaan in tabel "facturen" voor de gekozen periode en klant
            // dit is een soort log dat gebruiker kan zien voor elke maand dat hij een factuur heeft gemaakt voor de klant
            $factuur = new Factuur();
            $factuur->bedrijf_id = $bedrijf->id;
            $factuur->startdatum = $startDatum;
            $factuur->einddatum = $eindDatum;
            $factuur->naam = $name;
            $factuur->user_id = Auth::user()->id;
            $factuur->save();

        }


        return view('layouts.user.functietoevoegen.factuur.factuur_opties', compact('tijden', 'fdate', 'sdate', 'year', 'month', 'bedrijven', 'bedrijf', 'factuur'));
    }




    /**
     * Deze functie maakt een factuur aan en toont het in een PFD bestand.
     * Daarna wordt de PDF bestand in een mail toegvoegd opgestuurd naar e-mailadres van de klant en Brouwers contact persoon.
     * Deze functie schrijft ook automatisch de e-mail dat wordt opgestuurt.
     * Deze functie berekent ook automatisch de totaal maandbedrag exclusief BTW, de totaal maandbedrag inclusief BTW en
     * de BTW bedrag.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function factuur_maken_en_verzenden(Request $request, Factuur $factuur)
    {

        $user = auth()->user();

        //
        $bedrijf = $factuur->bedrijf;

        // stuurt de klanten van de gebruiker mee, zodat in deze lijst de gekozen klant wordt gevonden
        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();

        // start en einddatum dat is doorgegeven om de factuur te maken, ophalen zodat de factuur voor de dagen van deze
        // periode wordt aangemaakt
        $sdate = $factuur->startdatum;
        $fdate = $factuur->einddatum;

        // gegevens aan "tijden" leftjoinen zodat de gegevens dat aan de gewerkte dagen gekoppeld zijn, makkelijk gebruikt kunnen worden
        $tijden = Tijd::selectRaw('tijden.datum AS tijden_datum, toeslagochtend.datum AS toeslagochtend_datum, toeslagavond.datum AS toeslagavond_datum, toeslagnacht.datum AS toeslagnacht_datum, toeslagochtend.*, toeslagavond.*, toeslagnacht.*, tijden.*, TIMESTAMPDIFF(HOUR, begintijd, eindtijd) as uren')

            // vreemde sleutel "toeslag_idochtend" van de tijd verbinden met tabel "toeslagen" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "toeslagen" gevonden kan worden.
            ->leftJoin('toeslagen as toeslagochtend', function(\Illuminate\Database\Query\JoinClause $join) {
                $join->on('tijden.toeslag_idochtend', '=', 'toeslagochtend.id');
                $join->on('toeslagochtend.user_id', '=', 'tijden.user_id');
            })
            // vreemde sleutel "toeslag_idavond" van de tijd verbinden met tabel "toeslagen" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "toeslagen" gevonden kan worden.
            ->leftJoin('toeslagen as toeslagavond', function(\Illuminate\Database\Query\JoinClause$join) {
                $join->on('tijden.toeslag_idavond', '=', 'toeslagavond.id');
                $join->on('toeslagavond.user_id', '=', 'tijden.user_id');
            })
            // vreemde sleutel "toeslag_idnacht" van de tijd verbinden met tabel "toeslagen" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "toeslagen" gevonden kan worden.
            ->leftJoin('toeslagen as toeslagnacht', function(\Illuminate\Database\Query\JoinClause$join) {
                $join->on('tijden.toeslag_idnacht', '=', 'toeslagnacht.id');
                $join->on('toeslagnacht.user_id', '=', 'tijden.user_id');
            })

            // vreemde sleutel "bedrijf_id" van tijd verbinden met met tabel "bedrijven" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "bedrijven" gevonden kan worden.
            ->leftJoin('bedrijven', 'tijden.bedrijf_id', '=', 'bedrijven.id')

            // vreemde sleutel "tarief_id" van tijd verbinden met met tabel "tarieven" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "tarieven" gevonden kan worden.
            ->leftJoin('tarieven', 'tijden.tarief_id', '=', 'tarieven.id')

            // vreemde sleutel "user_id" van tijd verbinden met met tabel "users" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "users" gevonden kan worden.
            ->leftJoin('users', 'tijden.user_id', '=', 'users.id')

            // naar de datum van alle gewerkte dagen zoeken voor de doorgeven begin en eind van de gekozen maand (periode), zoeken
            ->whereBetween('tijden.datum', [$sdate, $fdate])

            // naar alle gewerkte dagen zoeken van de doorgeven klant
            ->where('tijden.bedrijf_id', [$bedrijf->id])

            // zoekt voor alle klanten (bedrijven) dat gebruker heeft geregistreerd
            ->where('bedrijven.user_id', auth()->user()->id)

            // zoekt voor alle tarieven dat gebruiker heeft geregistreerd
            ->where('tarieven.user_id', auth()->user()->id)

            // zoekt naar de "id" van de ingelogde gebruiker
            ->where('users.id', auth()->user()->id)

            ->get();

        // zoet naat de e-adress van brouwers contactpersoon dat de gebruiker heeft aangemaakt,
        // zodat het in de CC: van de e-mail kan worden toegevoegd
        $brouwerscontacten = DB::table('brouwerscontacten')
            ->where('brouwerscontacten.user_id', auth()->user()->id)
            ->get();


        ////// variables aanmaken voor de berekening/////

        // variable voor bedragen
        // variable voor de bedragen van het totaal maandbedrag exlusief btw, het totaal maandbedrag inclusief btw, en BTW bedrag
        $maanduitbetaling = 0;
        $maandbtw = 0;
        $maandTotaalBedrag = 0;

        // variable voor de bedragen van het ochtend, avond en nachttoeslag
        $totaalOchtendToeslagBedrag = 0;
        $totaalAvondToeslagBedrag = 0;
        $totaalNachtToeslagBedrag = 0;

        // variable voor het bedrag van het uitbetaling (exclusief BTW) van een gewerkte dag
        $totaalstandaardBedrag = 0;


        // variable voor tijden

        // variable voor alle minuten van de gewerkte dag
        $uren = 0;

        // variable voor alle minuten van de ochtend toeslag
        $ochtendtoeslaguren = 0;
        // variable voor alle minuten van de avond toeslag
        $avondtoeslaguren = 0;
        // variable voor alle minuten van de nacht toeslag
        $nachttoeslaguren = 0;

        // variable voor de tijd van de gewerkte dag en toeslagen in uren te tonen
        $toonuren = 0;
        $toontoeslaguren = 0;

        $dag = new Carbon();


        // statements voor elke gewerkte dag
        foreach($tijden as $tijd) {
            // voor elke gewerkte dag de vreemde sleutels van de ochtend, avond en nachttoeslag zoeken in tabek "toeslagen"
            $toeslag = Toeslag::selectRaw('*, TIMESTAMPDIFF(HOUR, toeslagbegintijd, toeslageindtijd) as toeslagauren')->where('id', $tijd->toeslag_idochtend)
                ->where('id', $tijd->toeslag_idavond)
                ->where('id', $tijd->toeslag_idnacht)

                // zoekt alle voor de toeslagen dat met de gebruiker is gekoppld
                ->where('toeslagen.user_id', auth()->user()->id)

                // pakt de laatste gemaakte toeslag van elke toeslag
                ->first();


            // de meeste recente tarief dat de gebruiker heeft geregistreerd opzoeken
            $tarief = \Auth::user()->tarief()
                // zoekt de uurtarief dat is gekoppelt de geregistreerde dag(tijd)
                ->where('id', $tijd->tarief_id)

                // zoekt de uurtarief dat is gekoppet aan de ingelogde gebruiker
                ->where('tarieven.user_id', auth()->user()->id)
                ->first();


            // carbon maken voor begintijd en eintijd van de geregistreerde dag, zodat het gebruikt kan worden
            $beginvandag = new Carbon($tijd->begintijd);
            $eindvandag = new Carbon($tijd->eindtijd);

            // alle minuten van een ingediende dag
            $tijd->uren = $beginvandag->diffInMinutes($eindvandag);


            /////////////toeslagen voor elke dag berekenen//////////////


            ///////berekenen van avondtoeslag voor elke regestreerde dag//////

            // als de geregistreerde dag geen "id" van een toeslag in de "ochten toeslag" vreemde sleutel bevat,
            // is het bedrag van de ochtentoeslag, 0.
            if (!$tijd->toeslagochtend){
                $tijd->totaalOchtendToeslagBedrag = null;

                // als de geregistreerde dag wel een "id" van een toeslag in de "ochten toeslag" vreemde sleutel bevat,
                // wordt de onstaande deel van de statement uitgevoerd.
            } else {

                // carbon voor begintijd en eind tijd van ochten toeslag zodat het kan worden gebruikt
                $beginvantoeslagochtend = new Carbon($tijd->toeslagochtend->toeslagbegintijd);
                $eindvantoeslagochtend = new Carbon($tijd->toeslagochtend->toeslageindtijd);

                // totaal minuten van de ochtend toeslag
                $tijd->ochtendtoeslaguren = $beginvantoeslagochtend->diffInMinutes($eindvantoeslagochtend);

                // conditie maken voor als de begin en eindtijd van de ochtend toelslag tussen de begin en eindtijd van de dag valt
                $BeginVanToeslagochtendIsInDag = $beginvantoeslagochtend->isBetween($beginvandag, $eindvandag);
                $EindVanToeslagochtendIsInDag = $eindvantoeslagochtend->isBetween($beginvandag, $eindvandag);

                // conditie maken voor als de begin en eindtijd van de dag tussen de begin en eindtijd van de ochtendtoeslag valt
                $BeginVanDagIsInOchtendtoeslag =  $beginvandag->isBetween($beginvantoeslagochtend, $eindvantoeslagochtend);
                $EindVanDagIsInOchtendtoeslag =  $eindvandag->isBetween($beginvantoeslagochtend, $eindvantoeslagochtend);

                // aantal minuten tussen de begin van het dag en het eind van het toeslag
                $tijd->BeginVanOchtendtoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagochtend);

                // aantal minuten tussen de begin van het ochtentoeslag en het eind van het dag
                $tijd->EindVanOchtendtoeslagurenIsIncompleet = $eindvandag->diffInMinutes($beginvantoeslagochtend);


                // als de begin en eindtijd van ochtendtoeslag tussen het begin en eindtijd van de dag ligt, gebruikt het de volle tijd van het ochtendtoeslag
                // tijd van ochtendtoeslag * (uurtarief * toeslag percentage) = ochtendtoeslag bedrag
                if ( $BeginVanToeslagochtendIsInDag && $EindVanToeslagochtendIsInDag) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->ochtendtoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                    // als het begin en eindtijd van de geregistreerde dag in tussen het begin en eindtijd van de ochtendtoeslag ligt,
                    // tijd van dag * (uurtarief * toeslag percentage) = ochtendtoeslag bedrag
                } elseif ($BeginVanDagIsInOchtendtoeslag && $EindVanDagIsInOchtendtoeslag) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));//

                    // als alleen het begin de dag in tussen het begin en eindtijd van de ochtendtoeslag ligt,
                    // tijd tussen "begintijd" van het dag en "eindtijd" van ochtend toeslag * (uurtarief * toeslag percentage) = ochtendtoeslag bedrag
                } elseif ( $BeginVanDagIsInOchtendtoeslag ) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->BeginVanOchtendtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                    // als alleen het eind de dag in tussen het begin en eindtijd van de ochtendtoeslag ligt,
                    // tijd tussen "eindtijd" van het dag en "begintijd" van ochtend toeslag * (uurtarief * toeslag percentage) = ochtendtoeslag bedrag
                } elseif ( $EindVanDagIsInOchtendtoeslag ) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->EindVanOchtendtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                    // als geen van de boventsaand statements zijn uitgevoert, is het ochtendtoeslag bedrag 0
                } else {
                    $tijd->totaalOchtendToeslagBedrag = null;
                }
            }

            //////////////berekenen van avondtoeslag voor elke dag/////////////

            // als de geregistreerde dag geen "id" van een toeslag in de "avondtoeslag" vreemde sleutel bevat,
            // is het bedrag van de avondtoeslag, 0.
            if (!$tijd->toeslagavond){
                $tijd->totaalAvondToeslagBedrag = null;

                // als de geregistreerde dag wel een "id" van een toeslag in de "avondtoeslag" vreemde sleutel bevat,
                // wordt de onstaande deel van de statement uitgevoerd.
            } else {

                // carbon voor begintijd en eind tijd van avondtoeslag zodat het kan worden gebruikt
                $beginvantoeslagavond = new Carbon($tijd->toeslagavond->toeslagbegintijd);
                $eindvantoeslagavond = new Carbon($tijd->toeslagavond->toeslageindtijd);

                // totaal minuten van de avondtoeslag
                $tijd->avondtoeslaguren = $beginvantoeslagavond->diffInMinutes($eindvantoeslagavond);

                // conditie maken voor als de begin en eindtijd van de avondtoeslag tussen de begin en eindtijd van de dag valt
                $BeginVanToeslagavondIsInDag = $beginvantoeslagavond->isBetween($beginvandag, $eindvandag);
                $EindVanToeslagavondIsInDag = $eindvantoeslagavond->isBetween($beginvandag, $eindvandag);

                // conditie maken voor als de begin en eindtijd van de dag tussen de begin en eindtijd van de avondtoeslag valt
                $BeginVanDagIsInAvondtoeslag =  $beginvandag->isBetween($beginvantoeslagavond, $eindvantoeslagavond);
                $EindVanDagIsInAvondtoeslag =  $eindvandag->isBetween($beginvantoeslagavond, $eindvantoeslagavond);

                // aantal minuten tussen de begin van het dag en het eind van het avondtoeslag
                $tijd->BeginVanAvondtoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagavond);

                // aantal minuten tussen de begin van het avondtoeslag en het eind van het dag
                $tijd->EindVanAvondtoeslagurenIsIncompleet = $eindvandag->diffInMinutes($beginvantoeslagavond);


                // als de begin en eindtijd van avondtoeslag tussen het begin en eindtijd van de dag ligt, gebruikt het de volle tijd van het avondtoeslag
                // tijd van avondtoeslag * (uurtarief * toeslag percentage) = avondtoeslag bedrag
                if ($BeginVanToeslagavondIsInDag && $EindVanToeslagavondIsInDag) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->avondtoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                    // als het begin en eindtijd van de geregistreerde dag in tussen het begin en eindtijd van de avondtoeslag ligt,
                    // tijd van dag * (uurtarief * toeslag percentage) = avondtoeslag bedrag
                } elseif ( $BeginVanDagIsInAvondtoeslag && $EindVanDagIsInAvondtoeslag) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                    // als alleen het begin de dag in tussen het begin en eindtijd van de avondtoeslag ligt,
                    // tijd tussen "begintijd" van het dag en "eindtijd" van avondtoeslag * (uurtarief * toeslag percentage) = avondtoeslag bedrag
                } elseif ( $BeginVanDagIsInAvondtoeslag ) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->BeginVanAvondtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                    // als alleen het eind de dag in tussen het begin en eindtijd van de avondtoeslag ligt,
                    // tijd tussen "eindtijd" van het dag en "begintijd" van avondtoeslag * (uurtarief * toeslag percentage) = avondtoeslag bedrag
                } elseif ( $EindVanDagIsInAvondtoeslag ) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->EindVanAvondtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                    // als geen van de boventsaand statements zijn uitgevoert, is het avondtoeslag bedrag 0
                } else {
                    $tijd->totaalAvondToeslagBedrag = null;
                }
            }

            ///////////berekenen van nachttoeslag bedrag voor elke dag///////////

            // als de geregistreerde dag geen "id" van een toeslag in de "ochten toeslag" vreemde sleutel bevat,
            // is het bedrag van de ochtentoeslag, 0.
            if (!$tijd->toeslagnacht){
                $tijd->totaalNachtToeslagBedrag = null;

                // als de geregistreerde dag wel een "id" van een toeslag in de "nachttoeslag" vreemde sleutel bevat,
                // wordt de onstaande deel van de statement uitgevoerd.
            } else {

                // carbon voor begintijd en eind tijd van nachttoeslag zodat het kan worden gebruikt
                $beginvantoeslagnacht = new Carbon($tijd->toeslagnacht->toeslagbegintijd);
                $eindvantoeslagnacht = new Carbon($tijd->toeslagnacht->toeslageindtijd);

                // totaal minuten van de nachttoeslag
                $tijd->nachttoeslaguren = $beginvantoeslagnacht->diffInMinutes($eindvantoeslagnacht);

                // conditie maken voor als de begin en eindtijd van de nachttoeslag tussen de begin en eindtijd van de dag valt
                $BeginVanToeslagnachtsInDag = $beginvantoeslagnacht->isBetween($beginvandag, $eindvandag);
                $EindVanToeslagnachtIsInDag = $eindvantoeslagnacht->isBetween($beginvandag, $eindvandag);

                // conditie maken voor als de begin en eindtijd van de dag tussen de begin en eindtijd van de nachttoeslag valt
                $BeginVanDagIsInNachttoeslag =  $beginvandag->isBetween($beginvantoeslagnacht, $eindvantoeslagnacht);
                $EindVanDagIsInNachttoeslag =  $eindvandag->isBetween($beginvantoeslagnacht, $eindvantoeslagnacht);


                // aantal minuten tussen de begin van het dag en het eind van het nachttoeslag
                $tijd->BeginVanNachttoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagnacht);

                // aantal minuten tussen de begin van het nachttoeslag en het eind van het dag
                $tijd->EindVanNachttoeslagurenIsIncompleet =$beginvantoeslagnacht->diffInMinutes($eindvandag);


                // als de begin en eindtijd van nachttoeslag tussen het begin en eindtijd van de dag ligt, gebruikt het de volle tijd van het nachttoeslag
                // tijd van nachttoeslag * (uurtarief * toeslag percentage) = nachttoeslag bedrag
                if ( $BeginVanToeslagnachtsInDag && $EindVanToeslagnachtIsInDag) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->nachttoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                    // als het begin en eindtijd van de geregistreerde dag in tussen het begin en eindtijd van de nachttoeslag ligt,
                    // tijd van dag * (uurtarief * toeslag percentage) = nachttoeslag bedrag
                } elseif ( $BeginVanDagIsInNachttoeslag && $EindVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                    // als alleen het begin de dag in tussen het begin en eindtijd van de nachttoeslag ligt,
                    // tijd tussen "begintijd" van het dag en "eindtijd" van ochtend toeslag * (uurtarief * toeslag percentage) = nachttoeslag bedrag
                } elseif ( $BeginVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->BeginVanNachttoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                    // als alleen het eind de dag in tussen het begin en eindtijd van de nachttoeslag ligt,
                    // tijd tussen "eindtijd" van het dag en "begintijd" van nachttoeslag * (uurtarief * toeslag percentage) = nachttoeslag bedrag
                } elseif ( $EindVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->EindVanNachttoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                    // als geen van de boventsaand statements zijn uitgevoert, is het nachttoeslag bedrag 0
                } else {
                    $tijd->totaalNachtToeslagBedrag = null;
                }
            }

            ////// van elke dag het standaard bedrag (bedrag dat geen toeslag heeft) berekenen, dit is voor het aantal tijd dat niet binnen de toeslag tijden liggen//////

            // wordt het aantal gebruikte tijd (in minuten) van de gekoppelde toeslagen opgehaald,
            // zodat het gebruikt wordt voor het berekenen van de standaard bedrag dat niet verbonden is aan de toeslagen.

            // als totaalNachtToeslagBedrag 0 is, is het gebruikte tijd 0
            if ( !$tijd->totaalNachtToeslagBedrag ) {
                $tijd->NachtToelsagTijd = null;
            // aantal gebruikte tijd van de NachtToelsag vinden door "het bereken van de totaalNachtToeslagBedrag" om te draaien
            } else {
                $tijd->NachtToelsagTijd = $tijd->totaalNachtToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagnacht->toeslagpercentage / 100);
            }

            // als totaalAvondToeslagBedrag 0 is, is het gebruikte tijd 0
            if ( !$tijd->totaalAvondToeslagBedrag ) {
                $tijd->AvondToelsagTijd = null;
                // aantal gebruikte tijd van de AvondToeslag vinden door "het bereken van de totaalAvondToeslagBedrag" om te draaien
            } else {
                $tijd->AvondToelsagTijd = $tijd->totaalAvondToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagavond->toeslagpercentage / 100);
            }

            // als totaalOchtendToeslagBedrag 0 is, is het gebruikte tijd 0
            if ( !$tijd->totaalOchtendToeslagBedrag ) {
                $tijd->OchtendToelsagTijd = null;
                // aantal gebruikte tijd van de OchtendToeslag vinden door "het bereken van de totaalOchtendToeslagBedrag" om te draaien
            } else {
                $tijd->OchtendToelsagTijd = $tijd->totaalOchtendToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagochtend->toeslagpercentage / 100);
            }


            // hier wordt het standaard bedrag (is niet gekoppelt aan toeslagen) berekent
            // Standaard bedrag = uurtarief * (tijd van het dag - tijd van ochtend toeslag - tijd van avond toeslag - tijd van nacht toeslag)
            $tijd->totaalstandaardBedrag += ($tarief->bedrag / 60) * ($tijd->uren - $tijd->NachtToelsagTijd - $tijd->AvondToelsagTijd - $tijd->OchtendToelsagTijd );

            // hier wordt het totaal bedrag van de dag berekent
            //Totaalbedrag van een dag = Standaard bedrag + ochtendtoeslag bedrag + avondtoeslag bedrag + nachttoeslag bedrag
            $tijd->totaalBedrag += $tijd->totaalOchtendToeslagBedrag + $tijd->totaalAvondToeslagBedrag + $tijd->totaalNachtToeslagBedrag + $tijd->totaalstandaardBedrag;

            // hier wordt het BTW van de dag berekent
            // Totaalbedrag van een dag * 0.21 = BTW bedrag
            $tijd->btw += $tijd->totaalBedrag * 0.21;

            // hier wordt het uitbetaling van de dag berekent
            // Totaalbedrag van een dag + BTW bedrag = uitbetaling
            $tijd->uitbetaling += $tijd->btw + $tijd->totaalBedrag;


            ///// Hier worden de bedragen voor de gekozen maand berekent

            // deze functie loopt het berekenen van het totaalBedrag van een dag voor elke dag van de gekozen maand,
            // en telt alle bedragen samen op
            $maandTotaalBedrag += $tijd->totaalBedrag;

            // deze functie loopt het berekenen van het btw van een dag voor elke dag van de gekozen maand,
            // telt alle bedragen samen op
            $maandbtw += $tijd->btw;

            // deze functie loopt het berekenen van het uitbetaling van een dag voor elke dag van de gekozen maand,
            // telt alle bedragen samen op
            $maanduitbetaling += $tijd->uitbetaling;
        }

        $data["email"] = "gijs@thedarecompany.com";
        $data["title"] = "From ItSolutionStuff.com";
        $data["body"] = "This is Demo";

///// variables met waarde aanmaken vooer het verzenden van de factuur////

        // sturen naar de van de klant dat in tabel "klanten" is opgeslagen
        $email = $bedrijf->email;
        // sturen naar CC: e-mail(brouwers) dat in tabel "brouwers contacten" is opgeslagen
        $bemail = \Auth::user()->brouwerscontact->email;
        // maakt automtisch een onderwerp van de gekozen klant en periode
        $subject = "Factuur van {$bedrijf->user->name} {$bedrijf->user->tussenvoegsel} {$bedrijf->user->achternaam} voor de periode {$factuur->startdatum->format('d-m-Y')} t/m {$factuur->einddatum->format('d-m-Y')}";
        // maakt automatish aan naam aan voor de PDF bestand
        $sendpdfnaam = "Factuur-".$factuur->naam.".pdf";
        // toont de periode van de gemaakt factuur in de e-mail
        $invoicemaand = "{$factuur->startdatum->format('d-m-Y')} t/m {$factuur->einddatum->format('d-m-Y')}";
        // toont da volledige naam van de zpper in de e-mail
        $sender = "{$user->name} {$user->tussenvoegsel} {$user->achternaam}";
        // toont de naam van de contactpersoon van de klant
        $ontvanger = $bedrijf->contactpersoon;


        // de resultaten van totaal bedrag exculesief btw, BTW en totaal bedrag inclusief btw  worden getoond in een PDF bestand
        // gegevensn van de klant, zpper en periode van de factuur worden op in het bestand getoond
        $pdf = PDF::loadView('layouts.user.functietoevoegen.factuur.factuur_pdf', compact( 'fdate', 'sdate', 'tijden', 'request', 'uren', 'ochtendtoeslaguren', 'avondtoeslaguren', 'nachttoeslaguren', 'maandTotaalBedrag', 'totaalOchtendToeslagBedrag', 'totaalAvondToeslagBedrag', 'totaalNachtToeslagBedrag', 'totaalstandaardBedrag', 'toeslag', 'toonuren', 'toontoeslaguren', 'bedrijf', 'bedrijven', 'brouwerscontacten',  'user', 'maandbtw', 'maanduitbetaling', 'factuur'));

        // PDF tonen in A4 formaat
        $pdf->setPaper('a4');

        // stuurr de benodigde gegevens naar de laravel functie dat factuur naar de klant zal verzenden.
        Mail::send(new InvoiceMail($email, $bemail, $subject, $sendpdfnaam, $invoicemaand, $sender, $ontvanger, $pdf->output()));


    }


    /**
     * Deze functie maakt een factuur aan en toont het in een PFD bestand, en maakt het downloadbaar
     * Deze functie berekent ook automatisch de totaal maandbedrag exclusief BTW, de totaal maandbedrag inclusief BTW en
     * de BTW bedrag.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function factuur_maken_en_downloaden(Request $request, Factuur $factuur)
    {

        $user = auth()->user();
        $bedrijf = $factuur->bedrijf;

        // stuurt de klanten van de gebruiker mee, zodat in deze lijst de gekozen klant wordt gevonden
        $bedrijven = Bedrijf::where('user_id', auth()->user()->id)->get();

        // start en einddatum dat is doorgegeven om de factuur te maken, ophalen zodat de factuur voor de dagen van deze
        // periode wordt aangemaakt
        $sdate = $factuur->startdatum;
        $fdate = $factuur->einddatum;

        // gegevens aan "tijden" leftjoinen zodat de gegevens dat aan de gewerkte dagen gekoppeld zijn, makkelijk gebruikt kunnen worden
        $tijden = Tijd::selectRaw('tijden.datum AS tijden_datum, toeslagochtend.datum AS toeslagochtend_datum, toeslagavond.datum AS toeslagavond_datum, toeslagnacht.datum AS toeslagnacht_datum, toeslagochtend.*, toeslagavond.*, toeslagnacht.*, tijden.*, TIMESTAMPDIFF(HOUR, begintijd, eindtijd) as uren')

            // vreemde sleutel "toeslag_idochtend" van de tijd verbinden met tabel "toeslagen" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "toeslagen" gevonden kan worden.
            ->leftJoin('toeslagen as toeslagochtend', function(\Illuminate\Database\Query\JoinClause $join) {
                $join->on('tijden.toeslag_idochtend', '=', 'toeslagochtend.id');
                $join->on('toeslagochtend.user_id', '=', 'tijden.user_id');
            })
            // vreemde sleutel "toeslag_idavond" van de tijd verbinden met tabel "toeslagen" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "toeslagen" gevonden kan worden.
            ->leftJoin('toeslagen as toeslagavond', function(\Illuminate\Database\Query\JoinClause$join) {
                $join->on('tijden.toeslag_idavond', '=', 'toeslagavond.id');
                $join->on('toeslagavond.user_id', '=', 'tijden.user_id');
            })
            // vreemde sleutel "toeslag_idnacht" van de tijd verbinden met tabel "toeslagen" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "toeslagen" gevonden kan worden.
            ->leftJoin('toeslagen as toeslagnacht', function(\Illuminate\Database\Query\JoinClause$join) {
                $join->on('tijden.toeslag_idnacht', '=', 'toeslagnacht.id');
                $join->on('toeslagnacht.user_id', '=', 'tijden.user_id');
            })

            // vreemde sleutel "bedrijf_id" van tijd verbinden met met tabel "bedrijven" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "bedrijven" gevonden kan worden.
            ->leftJoin('bedrijven', 'tijden.bedrijf_id', '=', 'bedrijven.id')

            // vreemde sleutel "tarief_id" van tijd verbinden met met tabel "tarieven" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "tarieven" gevonden kan worden.
            ->leftJoin('tarieven', 'tijden.tarief_id', '=', 'tarieven.id')

            // vreemde sleutel "user_id" van tijd verbinden met met tabel "users" zodat de "id of waarde" van de vreemde sleutel,
            // in tabel "users" gevonden kan worden.
            ->leftJoin('users', 'tijden.user_id', '=', 'users.id')

            // naar de datum van alle gewerkte dagen zoeken voor de doorgeven begin en eind van de gekozen maand (periode), zoeken
            ->whereBetween('tijden.datum', [$sdate, $fdate])

            // naar alle gewerkte dagen zoeken van de doorgeven klant
            ->where('tijden.bedrijf_id', [$bedrijf->id])

            // zoekt voor alle klanten (bedrijven) dat gebruker heeft geregistreerd
            ->where('bedrijven.user_id', auth()->user()->id)

            // zoekt voor alle tarieven dat gebruiker heeft geregistreerd
            ->where('tarieven.user_id', auth()->user()->id)

            // zoekt naar de "id" van de ingelogde gebruiker
            ->where('users.id', auth()->user()->id)

            ->get();


        ////// variables aanmaken voor de berekening/////

        // variable voor bedragen
        // variable voor de bedragen van het totaal maandbedrag exlusief btw, het totaal maandbedrag inclusief btw, en BTW bedrag
        $maanduitbetaling = 0;
        $maandbtw = 0;
        $maandTotaalBedrag = 0;

        // variable voor de bedragen van het ochtend, avond en nachttoeslag
        $totaalOchtendToeslagBedrag = 0;
        $totaalAvondToeslagBedrag = 0;
        $totaalNachtToeslagBedrag = 0;

        // variable voor het bedrag van het uitbetaling (exclusief BTW) van een gewerkte dag
        $totaalstandaardBedrag = 0;


        // variable voor tijden

        // variable voor alle minuten van de gewerkte dag
        $uren = 0;

        // variable voor alle minuten van de ochtend toeslag
        $ochtendtoeslaguren = 0;
        // variable voor alle minuten van de avond toeslag
        $avondtoeslaguren = 0;
        // variable voor alle minuten van de nacht toeslag
        $nachttoeslaguren = 0;

        // variable voor de tijd van de gewerkte dag en toeslagen in uren te tonen
        $toonuren = 0;
        $toontoeslaguren = 0;

        $dag = new Carbon();


        // statements voor elke gewerkte dag
        foreach($tijden as $tijd) {
            // voor elke gewerkte dag de vreemde sleutels van de ochtend, avond en nachttoeslag zoeken in tabek "toeslagen"
            $toeslag = Toeslag::selectRaw('*, TIMESTAMPDIFF(HOUR, toeslagbegintijd, toeslageindtijd) as toeslagauren')->where('id', $tijd->toeslag_idochtend)
                ->where('id', $tijd->toeslag_idavond)
                ->where('id', $tijd->toeslag_idnacht)

                // zoekt alle voor de toeslagen dat met de gebruiker is gekoppeld
                ->where('toeslagen.user_id', auth()->user()->id)

                // pakt de laatste gemaakte toeslag van elke toeslag
                ->first();


            // de meeste recente tarief dat de gebruiker heeft geregistreerd opzoeken
            $tarief = \Auth::user()->tarief()
                // zoekt de uurtarief dat is gekoppelt de geregistreerde dag(tijd)
                ->where('id', $tijd->tarief_id)

                // zoekt de uurtarief dat is gekoppet aan de ingelogde gebruiker
                ->where('tarieven.user_id', auth()->user()->id)
                ->first();


            // carbon maken voor begintijd en eintijd van de geregistreerde dag, zodat het gebruikt kan worden
            $beginvandag = new Carbon($tijd->begintijd);
            $eindvandag = new Carbon($tijd->eindtijd);

            // alle minuten van een ingediende dag
            $tijd->uren = $beginvandag->diffInMinutes($eindvandag);


            /////////////toeslagen voor elke dag berekenen//////////////

            ///////berekenen van avondtoeslag voor elke regestreerde dag//////

            // als de geregistreerde dag geen "id" van een toeslag in de "ochten toeslag" vreemde sleutel bevat,
            // is het bedrag van de ochtentoeslag, 0.
          if (!$tijd->toeslagochtend){
              $tijd->totaalOchtendToeslagBedrag = null;

              // als de geregistreerde dag wel een "id" van een toeslag in de "ochten toeslag" vreemde sleutel bevat,
              // wordt de onstaande deel van de statement uitgevoerd.
          } else {

              // carbon voor begintijd en eind tijd van ochten toeslag zodat het kan worden gebruikt
              $beginvantoeslagochtend = new Carbon($tijd->toeslagochtend->toeslagbegintijd);
              $eindvantoeslagochtend = new Carbon($tijd->toeslagochtend->toeslageindtijd);

              // totaal minuten van de ochtend toeslag
              $tijd->ochtendtoeslaguren = $beginvantoeslagochtend->diffInMinutes($eindvantoeslagochtend);

              // conditie maken voor als de begin en eindtijd van de ochtend toelslag tussen de begin en eindtijd van de dag valt
              $BeginVanToeslagochtendIsInDag = $beginvantoeslagochtend->isBetween($beginvandag, $eindvandag);
              $EindVanToeslagochtendIsInDag = $eindvantoeslagochtend->isBetween($beginvandag, $eindvandag);

              // conditie maken voor als de begin en eindtijd van de dag tussen de begin en eindtijd van de ochtendtoeslag valt
              $BeginVanDagIsInOchtendtoeslag =  $beginvandag->isBetween($beginvantoeslagochtend, $eindvantoeslagochtend);
              $EindVanDagIsInOchtendtoeslag =  $eindvandag->isBetween($beginvantoeslagochtend, $eindvantoeslagochtend);

              // aantal minuten tussen de begin van het dag en het eind van het toeslag
              $tijd->BeginVanOchtendtoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagochtend);

              // aantal minuten tussen de begin van het ochtentoeslag en het eind van het dag
              $tijd->EindVanOchtendtoeslagurenIsIncompleet = $eindvandag->diffInMinutes($beginvantoeslagochtend);


              // als de begin en eindtijd van ochtendtoeslag tussen het begin en eindtijd van de dag ligt, gebruikt het de volle tijd van het ochtendtoeslag
              // tijd van ochtendtoeslag * (uurtarief * toeslag percentage) = ochtendtoeslag bedrag
                if ( $BeginVanToeslagochtendIsInDag && $EindVanToeslagochtendIsInDag) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->ochtendtoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                    // als het begin en eindtijd van de geregistreerde dag in tussen het begin en eindtijd van de ochtendtoeslag ligt,
                    // tijd van dag * (uurtarief * toeslag percentage) = ochtendtoeslag bedrag
                } elseif ($BeginVanDagIsInOchtendtoeslag && $EindVanDagIsInOchtendtoeslag) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));//

                    // als alleen het begin de dag in tussen het begin en eindtijd van de ochtendtoeslag ligt,
                    // tijd tussen "begintijd" van het dag en "eindtijd" van ochtend toeslag * (uurtarief * toeslag percentage) = ochtendtoeslag bedrag
                } elseif ( $BeginVanDagIsInOchtendtoeslag ) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->BeginVanOchtendtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                    // als alleen het eind de dag in tussen het begin en eindtijd van de ochtendtoeslag ligt,
                    // tijd tussen "eindtijd" van het dag en "begintijd" van ochtend toeslag * (uurtarief * toeslag percentage) = ochtendtoeslag bedrag
                } elseif ( $EindVanDagIsInOchtendtoeslag ) {
                    $tijd->totaalOchtendToeslagBedrag += $tijd->EindVanOchtendtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagochtend->toeslagpercentage / 100));

                    // als geen van de boventsaand statements zijn uitgevoert, is het ochtendtoeslag bedrag 0
                } else {
                    $tijd->totaalOchtendToeslagBedrag = null;
                }
          }

            ///////////////////////berekenen van avondtoeslag voor elke dag//////////////////////

            // als de geregistreerde dag geen "id" van een toeslag in de "avondtoeslag" vreemde sleutel bevat,
            // is het bedrag van de avondtoeslag, 0.
            if (!$tijd->toeslagavond){
                $tijd->totaalAvondToeslagBedrag = null;

                // als de geregistreerde dag wel een "id" van een toeslag in de "avondtoeslag" vreemde sleutel bevat,
                // wordt de onstaande deel van de statement uitgevoerd.
            } else {

                // carbon voor begintijd en eind tijd van avondtoeslag zodat het kan worden gebruikt
                $beginvantoeslagavond = new Carbon($tijd->toeslagavond->toeslagbegintijd);
                $eindvantoeslagavond = new Carbon($tijd->toeslagavond->toeslageindtijd);

                // totaal minuten van de avondtoeslag
                $tijd->avondtoeslaguren = $beginvantoeslagavond->diffInMinutes($eindvantoeslagavond);

                // conditie maken voor als de begin en eindtijd van de avondtoeslag tussen de begin en eindtijd van de dag valt
                $BeginVanToeslagavondIsInDag = $beginvantoeslagavond->isBetween($beginvandag, $eindvandag);
                $EindVanToeslagavondIsInDag = $eindvantoeslagavond->isBetween($beginvandag, $eindvandag);

                // conditie maken voor als de begin en eindtijd van de dag tussen de begin en eindtijd van de avondtoeslag valt
                $BeginVanDagIsInAvondtoeslag =  $beginvandag->isBetween($beginvantoeslagavond, $eindvantoeslagavond);
                $EindVanDagIsInAvondtoeslag =  $eindvandag->isBetween($beginvantoeslagavond, $eindvantoeslagavond);

                // aantal minuten tussen de begin van het dag en het eind van het avondtoeslag
                $tijd->BeginVanAvondtoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagavond);

                // aantal minuten tussen de begin van het avondtoeslag en het eind van het dag
                $tijd->EindVanAvondtoeslagurenIsIncompleet = $eindvandag->diffInMinutes($beginvantoeslagavond);


                // als de begin en eindtijd van avondtoeslag tussen het begin en eindtijd van de dag ligt, gebruikt het de volle tijd van het avondtoeslag
                // tijd van avondtoeslag * (uurtarief * toeslag percentage) = avondtoeslag bedrag
                if ($BeginVanToeslagavondIsInDag && $EindVanToeslagavondIsInDag) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->avondtoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                    // als het begin en eindtijd van de geregistreerde dag in tussen het begin en eindtijd van de avondtoeslag ligt,
                    // tijd van dag * (uurtarief * toeslag percentage) = avondtoeslag bedrag
                } elseif ( $BeginVanDagIsInAvondtoeslag && $EindVanDagIsInAvondtoeslag) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                    // als alleen het begin de dag in tussen het begin en eindtijd van de avondtoeslag ligt,
                    // tijd tussen "begintijd" van het dag en "eindtijd" van avondtoeslag * (uurtarief * toeslag percentage) = avondtoeslag bedrag
                } elseif ( $BeginVanDagIsInAvondtoeslag ) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->BeginVanAvondtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                    // als alleen het eind de dag in tussen het begin en eindtijd van de avondtoeslag ligt,
                    // tijd tussen "eindtijd" van het dag en "begintijd" van avondtoeslag * (uurtarief * toeslag percentage) = avondtoeslag bedrag
                } elseif ( $EindVanDagIsInAvondtoeslag ) {
                    $tijd->totaalAvondToeslagBedrag += $tijd->EindVanAvondtoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                    // als geen van de boventsaand statements zijn uitgevoert, is het avondtoeslag bedrag 0
                } else {
                    $tijd->totaalAvondToeslagBedrag = null;
                }
            }

            ///////////////////////berekenen van nachttoeslag bedrag voor elke dag////////////////////////////////////

            // als de geregistreerde dag geen "id" van een toeslag in de "ochten toeslag" vreemde sleutel bevat,
            // is het bedrag van de ochtentoeslag, 0.
            if (!$tijd->toeslagnacht){
                $tijd->totaalNachtToeslagBedrag = null;

                // als de geregistreerde dag wel een "id" van een toeslag in de "nachttoeslag" vreemde sleutel bevat,
                // wordt de onstaande deel van de statement uitgevoerd.
            } else {

                // carbon voor begintijd en eind tijd van nachttoeslag zodat het kan worden gebruikt
                $beginvantoeslagnacht = new Carbon($tijd->toeslagnacht->toeslagbegintijd);
                $eindvantoeslagnacht = new Carbon($tijd->toeslagnacht->toeslageindtijd);

                // totaal minuten van de nachttoeslag
                $tijd->nachttoeslaguren = $beginvantoeslagnacht->diffInMinutes($eindvantoeslagnacht);

                // conditie maken voor als de begin en eindtijd van de nachttoeslag tussen de begin en eindtijd van de dag valt
                $BeginVanToeslagnachtsInDag = $beginvantoeslagnacht->isBetween($beginvandag, $eindvandag);
                $EindVanToeslagnachtIsInDag = $eindvantoeslagnacht->isBetween($beginvandag, $eindvandag);

                // conditie maken voor als de begin en eindtijd van de dag tussen de begin en eindtijd van de nachttoeslag valt
                $BeginVanDagIsInNachttoeslag =  $beginvandag->isBetween($beginvantoeslagnacht, $eindvantoeslagnacht);
                $EindVanDagIsInNachttoeslag =  $eindvandag->isBetween($beginvantoeslagnacht, $eindvantoeslagnacht);

                // aantal minuten tussen de begin van het dag en het eind van het nachttoeslag
                $tijd->BeginVanNachttoeslagurenIsIncompleet = $beginvandag->diffInMinutes($eindvantoeslagnacht);

                // aantal minuten tussen de begin van het nachttoeslag en het eind van het dag
                $tijd->EindVanNachttoeslagurenIsIncompleet =$beginvantoeslagnacht->diffInMinutes($eindvandag);


                // als de begin en eindtijd van nachttoeslag tussen het begin en eindtijd van de dag ligt, gebruikt het de volle tijd van het nachttoeslag
                // tijd van nachttoeslag * (uurtarief * toeslag percentage) = nachttoeslag bedrag
                if ( $BeginVanToeslagnachtsInDag && $EindVanToeslagnachtIsInDag) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->nachttoeslaguren * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                    // als het begin en eindtijd van de geregistreerde dag in tussen het begin en eindtijd van de nachttoeslag ligt,
                    // tijd van dag * (uurtarief * toeslag percentage) = nachttoeslag bedrag
                } elseif ( $BeginVanDagIsInNachttoeslag && $EindVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->uren * (($tarief->bedrag / 60) * ($tijd->toeslagavond->toeslagpercentage / 100));

                    // als alleen het begin de dag in tussen het begin en eindtijd van de nachttoeslag ligt,
                    // tijd tussen "begintijd" van het dag en "eindtijd" van ochtend toeslag * (uurtarief * toeslag percentage) = nachttoeslag bedrag
                } elseif ( $BeginVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->BeginVanNachttoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                    // als alleen het eind de dag in tussen het begin en eindtijd van de nachttoeslag ligt,
                    // tijd tussen "eindtijd" van het dag en "begintijd" van nachttoeslag * (uurtarief * toeslag percentage) = nachttoeslag bedrag
                } elseif ( $EindVanDagIsInNachttoeslag ) {
                    $tijd->totaalNachtToeslagBedrag += $tijd->EindVanNachttoeslagurenIsIncompleet * (($tarief->bedrag / 60) * ($tijd->toeslagnacht->toeslagpercentage / 100));

                    // als geen van de boventsaand statements zijn uitgevoert, is het nachttoeslag bedrag 0
                } else {
                    $tijd->totaalNachtToeslagBedrag = null;
                }
            }

            ////// van elke dag het standaard bedrag (bedrag dat geen toeslag heeft) berekenen, dit is voor het aantal tijd dat niet binnen de toeslag tijden liggen//////

            // wordt het aantal gebruikte tijd (in minuten) van de gekoppelde toeslagen opgehaald,
            // zodat het gebruikt wordt voor het berekenen van de standaard bedrag dat niet verbonden is aan de toeslagen.

            // als totaalNachtToeslagBedrag 0 is, is het gebruikte tijd 0
           if ( !$tijd->totaalNachtToeslagBedrag ) {
                $tijd->NachtToelsagTijd = null;
               // aantal gebruikte tijd van de NachtToelsag vinden door "het bereken van de totaalNachtToeslagBedrag" om te draaien
           } else {
               $tijd->NachtToelsagTijd = $tijd->totaalNachtToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagnacht->toeslagpercentage / 100);
           }

            // als totaalAvondToeslagBedrag 0 is, is het gebruikte tijd 0
            if ( !$tijd->totaalAvondToeslagBedrag ) {
                $tijd->AvondToelsagTijd = null;
                // aantal gebruikte tijd van de AvondToeslag vinden door "het bereken van de totaalAvondToeslagBedrag" om te draaien
            } else {
                $tijd->AvondToelsagTijd = $tijd->totaalAvondToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagavond->toeslagpercentage / 100);
            }

            // als totaalOchtendToeslagBedrag 0 is, is het gebruikte tijd 0
            if ( !$tijd->totaalOchtendToeslagBedrag ) {
                $tijd->OchtendToelsagTijd = null;
                // aantal gebruikte tijd van de OchtendToeslag vinden door "het bereken van de totaalOchtendToeslagBedrag" om te draaien
            } else {
                $tijd->OchtendToelsagTijd = $tijd->totaalOchtendToeslagBedrag / ($tarief->bedrag / 60) / ($tijd->toeslagochtend->toeslagpercentage / 100);
            }


            // hier wordt het standaard bedrag (is niet gekoppelt aan toeslagen) berekent
            // Standaard bedrag = uurtarief * (tijd van het dag - tijd van ochtend toeslag - tijd van avond toeslag - tijd van nacht toeslag)
            $tijd->totaalstandaardBedrag += ($tarief->bedrag / 60) * ($tijd->uren - $tijd->NachtToelsagTijd - $tijd->AvondToelsagTijd - $tijd->OchtendToelsagTijd );

            // hier wordt het totaal bedrag van de dag berekent
            //Totaalbedrag van een dag = Standaard bedrag + ochtendtoeslag bedrag + avondtoeslag bedrag + nachttoeslag bedrag
            $tijd->totaalBedrag += $tijd->totaalOchtendToeslagBedrag + $tijd->totaalAvondToeslagBedrag + $tijd->totaalNachtToeslagBedrag + $tijd->totaalstandaardBedrag;

            // hier wordt het BTW van de dag berekent
            // Totaalbedrag van een dag * 0.21 = BTW bedrag
            $tijd->btw += $tijd->totaalBedrag * 0.21;

            // hier wordt het uitbetaling van de dag berekent
            // Totaalbedrag van een dag + BTW bedrag = uitbetaling
            $tijd->uitbetaling += $tijd->btw + $tijd->totaalBedrag;


            ///// Hier worden de bedragen voor de gekozen maand berekent

            // deze functie loopt het berekenen van het totaalBedrag van een dag voor elke dag van de gekozen maand,
            // en telt alle bedragen samen op
            $maandTotaalBedrag += $tijd->totaalBedrag;

            // deze functie loopt het berekenen van het btw van een dag voor elke dag van de gekozen maand,
            // telt alle bedragen samen op
            $maandbtw += $tijd->btw;

            // deze functie loopt het berekenen van het uitbetaling van een dag voor elke dag van de gekozen maand,
            // telt alle bedragen samen op
            $maanduitbetaling += $tijd->uitbetaling;
        }

        // geeft de PFD bestand een naam
        $downloadpdfnaam = "Factuur-".$factuur->naam.".pdf";

        // de resultaten van totaal bedrag exculesief btw, BTW en totaal bedrag inclusief btw  worden getoond in een PDF bestand
        // gegevensn van de klant, zpper en periode van de factuur worden op in het bestand getoond
        $pdf = PDF::loadView('layouts.user.functietoevoegen.factuur.factuur_pdf', compact( 'fdate', 'sdate', 'tijden', 'request', 'uren', 'ochtendtoeslaguren', 'avondtoeslaguren', 'nachttoeslaguren','maandTotaalBedrag', 'totaalOchtendToeslagBedrag', 'totaalAvondToeslagBedrag', 'totaalNachtToeslagBedrag', 'totaalstandaardBedrag', 'toonuren', 'bedrijf', 'bedrijven', 'user', 'maandbtw', 'maanduitbetaling', 'factuur' ));

        // PDF tonen in A4 formaat
        $pdf->setPaper('a4');

        // download de PDF bestand met doorgegeven naam
        return $pdf->stream($downloadpdfnaam);


    }

}
