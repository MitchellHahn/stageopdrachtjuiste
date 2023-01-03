<!-- pdf.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>

<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table>
{{--blade dat de factuur maakt--}}
    {{--berekeningen nog erbij--}}
{{--                <tr>--}}
{{--                    <th></th>--}}
{{--                    <th></th>--}}
{{--                    <th></th>--}}
{{--                    <th><i><u><h3>ZZPer gegevens</h3></u></i></th>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <th>Voornaam</th>--}}
{{--                    <th>Tussenvoegsel</th>--}}
{{--                    <th>Achternaam</th>--}}
{{--                    <th>E-mail</th>--}}
{{--                    <th>Kvknummer</th>--}}
{{--                    <th>BTW-nummer</th>--}}
{{--                    <th>Iban-nummer</th>--}}
{{--                    <th>Bedrijfsnaam</th>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td style="text-align: center; vertical-align: middle;">--}}
{{--                        {{$user->name}}--}}
{{--                    </td>--}}
{{--                    <td style="text-align: center; vertical-align: middle;">--}}
{{--                        {{$user->tussenvoegsel}}--}}
{{--                    </td>--}}
{{--                    <td style="text-align: center; vertical-align: middle;">--}}
{{--                        {{$user->achternaam}}--}}
{{--                    </td>--}}
{{--                    <td style="text-align: center; vertical-align: middle;">--}}
{{--                        {{$user->email }}--}}
{{--                    </td>--}}
{{--                    <td style="text-align: center; vertical-align: middle;">--}}
{{--                        {{$user->kvknummer}}--}}
{{--                    </td>--}}
{{--                    <td style="text-align: center; vertical-align: middle;">--}}
{{--                        {{$user->btwnummer}}--}}
{{--                    </td>--}}
{{--                    <td style="text-align: center; vertical-align: middle;">--}}
{{--                        {{$user->ibannummer}}--}}
{{--                    </td>--}}
{{--                    <td style="text-align: center; vertical-align: middle;">--}}
{{--                        {{$user->bedrijfsnaam}}--}}
{{--                    </td>--}}
{{--                </tr>--}}


                <tr>
                    <td><b>
                        {{$bedrijf->bedrijfsnaam}}
                    </b></td>
                </tr>
                <tr>
                    <td>
                        {{$bedrijf->contactpersoon}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{$bedrijf->debnummer}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{$bedrijf->straat}}

                        {{$bedrijf->huisnummer}}

                        {{$bedrijf->toevoeging}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{$bedrijf->postcode}}

                        {{$bedrijf->stad}}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{$bedrijf->land}}
                    </td>
                </tr>
                </table>

<br>
</br>

            <table class="table table-bordered table-striped">
                <tr>
                    <td><b>
                        Factuurnummer:
                    </b></td>
                    <td>
                    </td>
                    <td>
                        {{ $factuur->naam }}
                    </td>
                </tr>
                <tr>
                    <td><b>
                        Factuurdatum:
                        </b></td>
                    <td>
                    </td>
                    <td>
                        {{ $factuur->created_at->format('d-m-Y')}}
                    </td>
                </tr>
            </table>
{{--                <tr>--}}
{{--                    <th></th>--}}
{{--                    <th></th>--}}
{{--                    <th></th>--}}
{{--                    <th><i><u><h3>Factuur</h3></u></i></th>--}}
{{----}}
{{--                </tr>--}}
{{--            @foreach($tijden as $tijd)--}}
{{----}}
{{--    <tr>--}}
{{--            <th>Datum</th>--}}
{{--            <th>Begintijd</th>--}}
{{--            <th>Eindtijd</th>--}}
{{--            <th>Totaal uren</th>--}}
{{----}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td style="text-align: center; vertical-align: middle;">--}}
{{--            {{$tijd->tijden_datum}}--}}
{{--        </td>--}}
{{--        <td style="text-align: center; vertical-align: middle;">--}}
{{--            {{$tijd->begintijd}}--}}
{{--        </td>--}}
{{--        <td style="text-align: center; vertical-align: middle;">--}}
{{--            {{$tijd->eindtijd}}--}}
{{--        </td>--}}
{{--        <td style="text-align: center; vertical-align: middle;">--}}
{{--            {{$tijd->toonuren}}--}}
{{--        </td>--}}
{{----}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--            <th>Toeslag begintijd</th>--}}
{{--            <th>Toeslag eindtijd</th>--}}
{{--            <th>Toeslag uren</th>--}}
{{--            <th>Toeslag soort</th>--}}
{{--            <th>Toeslag percentage</th>--}}
{{--            <th>Uurtarief</th>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td style="text-align: center; vertical-align: middle;">--}}
{{--            {{$tijd->toeslag->toeslagbegintijd}}--}}
{{--        </td>--}}
{{--        <td style="text-align: center; vertical-align: middle;">--}}
{{--            {{$tijd->toeslag->toeslageindtijd}}--}}
{{--        </td>--}}
{{-- resultaten van berekening toeslag uren--}}
{{--        <td style="text-align: center; vertical-align: middle;">--}}
{{--            {{$tijd->toontoeslaguren}}--}}
{{--        </td>--}}
{{--        <td style="text-align: center; vertical-align: middle;">--}}
{{--            {{$tijd->toeslag->toeslagsoort}}--}}
{{--        </td>--}}
{{--        <td style="text-align: center; vertical-align: middle;">--}}
{{--            {{$tijd->toeslag->toeslagpercentage}}--}}
{{--        </td>--}}
{{--        <td style="text-align: center; vertical-align: middle;">--}}
{{--            {{$tijd->toeslag->tarief->bedrag}}--}}
{{--        </td>--}}
{{--    </tr>--}}
{{----}}
{{--   resultaten van berekening per dag of tijd tonen--}}
{{--        <tr>--}}
{{--            <th>Toeslag bedrag</th>--}}
{{--            <th>Standaard bedrag</th>--}}
{{--            <th>Totaal bedrag</th>--}}
{{--            <th>BTW(21%)</th>--}}
{{--            <th>Uitbetaling</th>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td style="text-align: center; vertical-align: middle;">--}}
{{--                {{$tijd->totaalToeslagBedrag}}--}}
{{--            </td>--}}
{{--            <td style="text-align: center; vertical-align: middle;">--}}
{{--                {{$tijd->totaalstandaardBedrag}}--}}
{{--            </td>--}}
{{--            <td style="text-align: center; vertical-align: middle;">--}}
{{--                {{$tijd->totaalBedrag}}--}}
{{--            </td>--}}
{{--            <td style="text-align: center; vertical-align: middle;">--}}
{{--                {{$tijd->btw}}--}}
{{--            </td>--}}
{{--            <td style="text-align: center; vertical-align: middle;">--}}
{{--                {{$tijd->uitbetaling}}--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--   gegevens van bedrijf per dag of tijd--}}

{{--             @endforeach--}}

            <br>
            </br>
           <table class="table table-bordered table-striped" border="1" style="width:83%">

<br>
</br>
                <tr>
                    <td><b>Omschrijving</b></td>
{{--                    <td><b></b></td>--}}
                    <td><b>Bedrag</b></td>
                </tr>

                <tr>
                    <td>Werkzaamheden {{$bedrijf->bedrijfsnaam}}</td>
{{--                    <td style="text-align: center; vertical-align: middle;"></td>--}}
                    <td>€{{ number_format($maandTotaalBedrag, 2, ',', '.') }}</td>
                <tr>

                <tr >
                    <td width=100%>Periode: {{$factuur->startdatum->format('d-m-Y') }} t/m {{$factuur->einddatum->format('d-m-Y')}}</td>
{{--                    <td></td>--}}
{{--                   <td></td>--}}
                <tr>

<br>
</br>

                <tr>
                    <td>Totaal excl. BTW</td>
{{--                    <td style="text-align: center; vertical-align: middle;"></td>--}}
                    <td>€{{ number_format($maandTotaalBedrag, 2, ',', '.') }}</td>
                <tr>
                </tr>
                    <td>21% BTW</td>
{{--                    <td style="text-align: center; vertical-align: middle;">€</td>--}}
                    <td>€{{ number_format($maandbtw, 2, ',', '.') }}</td>
                <tr>
                </tr>
                    <td><b>Totaal incl. BTW</b></td>
{{--                    <td style="text-align: center; vertical-align: middle;"><b>€</b></td>--}}
                    <td><b>€{{ number_format($maanduitbetaling, 2, ',', '.') }}</b></td>
                </tr>
            </table>

            <br>
            </br>

            <div>
                    <h>Wij verzoeken u vriendelijk om bovenstaand bedrag binnen 14 dagen over te
                        maken op rekeningnummer <i>{{ $user->ibannummer }}</i> t.n.v. <i>{{ $user->bedrijfsnaam }}</i> onder vermelding
                        van het factuurnummer.</h>
            </div>

            <br>
            </br>

            <table>
            <tr>
                <td>
                    {{$user->name}} {{$user->tussenvoegsel}} {{$user->achternaam}}
                </td>
            </tr>
            <tr>
                <td>
                    {{$user->email }}
                </td>
            </tr>
            <tr>
                <td>
                    {{$user->kvknummer}}
                </td>
            </tr>
            <tr>
                <td>
                    {{$user->btwnummer}}
                </td>
            </tr>
            <tr>
                <td>
                    {{$user->ibannummer}}
                </td>
            </tr>
            <tr>
                <td>
                    {{$user->bedrijfsnaam}}
                </td>
            </tr>
            </table>

</div>
</div>
</div>
</body>
</html>
