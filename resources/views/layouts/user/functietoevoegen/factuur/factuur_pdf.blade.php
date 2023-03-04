<!-- factuur_pdf.blade.php -->

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
{{--pagina van de PFD formaat van de factuur --}}

                {{-- toon de bedrijfsnaam van de klant --}}
                <tr>
                    <td><b>
                        {{$bedrijf->bedrijfsnaam}}
                    </b></td>
                </tr>

                {{-- toon de contactpersoon van de klant --}}
                <tr>
                    <td>
                        {{$bedrijf->contactpersoon}}
                    </td>
                </tr>

                {{-- toon de debnummer van de klant --}}
                <tr>
                    <td>
                        {{$bedrijf->debnummer}}
                    </td>
                </tr>

                {{-- toon de straat, huisnummer en toevoeging  van de klant --}}
                <tr>
                    <td>
                        {{$bedrijf->straat}}

                        {{$bedrijf->huisnummer}}

                        {{$bedrijf->toevoeging}}
                    </td>
                </tr>

                {{-- toon de postcode en stad van de klant --}}
                <tr>
                    <td>
                        {{$bedrijf->postcode}}

                        {{$bedrijf->stad}}
                    </td>
                </tr>

                {{-- toon de land van de klant --}}
                <tr>
                    <td>
                        {{$bedrijf->land}}
                    </td>
                </tr>
                </table>

<br>
</br>

            <table class="table table-bordered table-striped">
                {{-- toon de text "Factuurnummer" en de naam van de factuur --}}
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

                {{-- toon de text "Factuurdatum" en de datum van de factuur --}}
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


            <br>
            </br>
           <table class="table table-bordered table-striped" border="1" style="width:83%">

<br>
</br>
                {{--     toont de tekst Omschrijving en bedrag           --}}
                <tr>
                    <td><b>Omschrijving</b></td>
                    <td><b>Bedrag</b></td>
                </tr>

               {{--     toont de tekst Werkzaamheden  --}}
               {{--     toont de naam van de klant en het totaal bedrag (exclusief btw) van de factuur  --}}
               <tr>
                    <td>Werkzaamheden {{$bedrijf->bedrijfsnaam}}</td>
                    <td>€{{ number_format($maandTotaalBedrag, 2, ',', '.') }}</td>
                <tr>

               {{--     toont de begin en eind datum van de gekozen maande        --}}
                <tr >
                    <td width=100%>Periode: {{$factuur->startdatum->format('d-m-Y') }} t/m {{$factuur->einddatum->format('d-m-Y')}}</td>
                <tr>

<br>
</br>
               {{--    reultaten van berekening       --}}
               {{--     toont de totaalbedrag exclusief btw van de factuur     --}}
                <tr>
                    <td>Totaal excl. BTW</td>
                    <td>€{{ number_format($maandTotaalBedrag, 2, ',', '.') }}</td>
                <tr>

               {{--     toont de btw bedrag van de factuur     --}}
               </tr>
                    <td>21% BTW</td>
                    <td>€{{ number_format($maandbtw, 2, ',', '.') }}</td>
                <tr>

               {{--     toont de totaalbedrag inclusief btw van de factuur     --}}
                </tr>
                    <td><b>Totaal incl. BTW</b></td>
                    <td><b>€{{ number_format($maanduitbetaling, 2, ',', '.') }}</b></td>
                </tr>
            </table>

            <br>
            </br>
                                {{-- toont de inbannummer en bedrijfsnaam van de klant--}}
                                {{-- toont tekst dat zegt de de betaling binnen 2 weken over te maken--}}
            <div>
                    <h>Wij verzoeken u vriendelijk om bovenstaand bedrag binnen 14 dagen over te
                        maken op rekeningnummer <i>{{ $user->ibannummer }}</i> t.n.v. <i>{{ $user->bedrijfsnaam }}</i> onder vermelding
                        van het factuurnummer.</h>
            </div>

            <br>
            </br>

            <table>
                {{-- toont de voornaam, tussenvoegsel en achternaam van de zpper--}}
            <tr>
                <td>
                    {{$user->name}} {{$user->tussenvoegsel}} {{$user->achternaam}}
                </td>
            </tr>
                {{-- toont de e-mailadres van de zpper--}}
            <tr>
                <td>
                    {{$user->email }}
                </td>
            </tr>
                {{-- toont de kvknummer van de zpper--}}
            <tr>
                <td>
                    {{$user->kvknummer}}
                </td>
            </tr>
                {{-- toont de btwnummer van de zpper--}}
            <tr>
                <td>
                    {{$user->btwnummer}}
                </td>
            </tr>
                {{-- toont de ibannummer van de zpper--}}
            <tr>
                <td>
                    {{$user->ibannummer}}
                </td>
            </tr>
                {{-- toont de bedrijfsnaam van de zpper--}}
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
