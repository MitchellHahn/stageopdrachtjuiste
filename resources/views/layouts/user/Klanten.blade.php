@extends('layouts.app')

@section('content')

    {{--     pagina van zzper module waar zijn klanten (bedrijven) kan bekijken--}}

    <div class="container-xl containerSupportedContent">
        <div class="row">
            <div class="col-md">
                    <div class="titlebox titleboxSupportedContent">
                        {{-- titel en onschrijving van de pagina--}}
                        <h2 class="title titleSupportedContent">Klanten</h2>
                        <h class="info infoSupportedContent">Registreer hier een klant.</h>
                    </div>
            </div>
        </div>
            </br>
            </br>
            </br>
        <div class="row">
            <div class="col-lg">
                <div class="float-right">
                {{--       knop dat de klant (bedrijf) aanmaakt met de ingevoerd gegeven             --}}
                <a class="createbutton createbuttonSupportedContent" href="{{ route('Klanten.aanmaken') }}"> Klant registreren</a>
            </div>
          </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="container-xl containerSupportedContent" >
        <table class="table table-bordered">
                <tr class="tablehead tableheadSupportedContent">
                    {{--      toon Klantnaam ,Debnummer, Straat, Huisnummer, Postcode, Stad en Land in het hoofd van de tabel      --}}

                            <th class="tableheadfont tableheadfontSupportedContent">Klantnaam</th>

                            <th class="tableheadfont tableheadfontSupportedContent">Debnummer</th>
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Straat</th>
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Huisnummer</th>
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Postcode</th>
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Stad</th>
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Land</th>
                            <th class="tableheadfont tableheadfontSupportedContent"></th>

        </tr>
            @foreach ($bedrijven as $bedrijf)

            <tr class="tablerow">
                    {{-- toont de gegeven en tabel op deze manier op mobiel aparaten--}}
                    <td class="tablerowcell tablerowcellSupportedContent">
                        {{ $bedrijf->bedrijfsnaam	 }}
                        <div class="d-md-none tablerowcellSupportedContent">
                            {{ $bedrijf->straat }}<br />
                            {{ $bedrijf->huisnummer }}{{ $bedrijf->toevoeging }}<br />
                            {{ $bedrijf->postcode }}<br />
                            {{ $bedrijf->stad }}<br />
                            {{ $bedrijf->land}}
                        </div>

                        {{-- toont de Klantnaam ,Debnummer, Straat, Huisnummer, Postcode, Stad en Land van elke elke klant van de ingelogde gebruiker in de tabel --}}
                    </td>
                    <td class="tablerowcell tablerowcellSupportedContent">{{ $bedrijf->debnummer }}</td>
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $bedrijf->straat }}</td>
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $bedrijf->huisnummer }} {{ $bedrijf->toevoeging }}</td>
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $bedrijf->postcode }}</td>
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $bedrijf->stad }}</td>
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $bedrijf->land }}</td>
                    <td class="tablerowcell">
                    {{-- functie dat de klant van de ingelogde gebruiker verwijdert --}}
                    <form action="{{ route('Klanten.verwijderen',$bedrijf->id) }}" class="formSupportedContent" method="POST">

                        {{-- knop en functie dat de gegeven van de klant toont --}}
                        <a class="klantenbutton buttonSupportedContent" href="{{ route('Klanten.tonen',$bedrijf->id) }}">Tonen</a>

                        {{-- knop en functie dat de gegeven van de klant wijzigt --}}
                        <a class="klantenbutton klantenbutton2 buttonSupportedContent" href="{{ route('Klanten.wijzigen',$bedrijf->id) }}">Wijzigen</a>


                        @csrf
                        @method('DELETE')

                        {{-- knop en functie dat de klant verwijdert --}}
                        <button type="submit" class="klantenbutton klantenbutton3 buttonSupportedContent">Verwijderen</button>

                    {{--knop om een factuur te maken--}}
                        <a class="factuurbutton buttonSupportedContent" href="{{ route('Factuur.gemaakte_facturen_van_klant_tonen',$bedrijf->id) }}">Facturen</a>
                    </form>
                </td>
            </tr>
            @endforeach
    </table>
<div/>

@endsection


