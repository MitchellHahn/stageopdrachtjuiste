<?php //@extends('layouts.app')?>
@extends('layouts.app')




@section('content')

    {{--     pagina van zzper module waar zijn gewerkte dagen kan bekijken--}}
    <div class="container-xl containerSupportedContent">
        <div class="row">
            <div class="col-md">
                    <div class="titlebox titleboxSupportedContent">
                        {{-- titel en onschrijving van de pagina--}}
                        <h2 class="title titleSupportedContent">Uren</h2>
                            <h class="info infoSupportedContent">Vul hieronder je uren in.</h>
                    </div>
            </div>
        </div>

        </br>
        </br>
        </br>
        <div class="row">
            <div class="col-lg">

                <div class="float-right">
                    {{--       knop dat de een gewerkte dag registreert met de ingevoerd gegeven             --}}
                    <a class="createbutton createbuttonSupportedContent" href="{{ route('UToevoegen.aanmaken') }}">Uren toevoegen</a>
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

            {{--      toon Datum ,Begintijd, Eindtijd, Klantnaam en Totaal in het hoofd van de tabel      --}}
                <tr class="tablehead tableheadSupportedContent">
                            <th class="tableheadfont tableheadfontSupportedContent">Datum</th>
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Begintijd</th>
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Eindtijd</th>
                            <th class="tableheadfont tableheadfontSupportedContent">Klantnaam</th>
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Totaal</th>

                            <th class="tableheadfont tableheadfontSupportedContent"></th>

                </tr>

                @foreach ($tijden as $tijd)

                        <tr class="tablerow ">
                            {{-- toont de gegevens en tabel op deze manier op mobiel aparaten--}}
                                <td class="tablerowcell tablerowcellSupportedContent datepicker">
                                    {{ $tijd->datum->format('d-m-Y') }}
                                    <div class="d-md-none tablerowcellSupportedContent">
                                        {{ $tijd->begintijd }} <br/>
                                        {{ $tijd->eindtijd }} <br/>
                                        {{ $tijd->uren }} uren
                                    </div>
                                </td>

                            {{-- toont de Datum ,Begintijd, Eindtijd, Klantnaam en Totaal van elke gewerkte dag van de ingelogde gebruiker in de tabel --}}
                                <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ date('H:i', strtotime($tijd->begintijd)) }}</td>
                                <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ date('H:i', strtotime($tijd->eindtijd)) }}</td>
                                <td class="tablerowcell tablerowcellSupportedContent">{{ $tijd->bedrijf->bedrijfsnaam }}</td>
                                <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $tijd->uren }} uren</td>

                                <td class="tablerowcell ">

                                    {{-- functie dat de geregostreerde dag van de ingelogde gebruiker verwijdert --}}
                                    <form action="{{ route('UToevoegen.verwijderen',$tijd->id) }}" class="formSupportedContent" method="POST">

                                        {{-- knop en functie dat de gegeven van de dag toont --}}
                                        <a class="button buttonSupportedContent" href="{{ route('UToevoegen.tonen',$tijd->id) }}">Tonen</a>

                                        {{-- knop en functie dat de gegevens van de dag wijzigt --}}
                                        <a class="button button2 buttonSupportedContent" href="{{ route('UToevoegen.wijzigen',$tijd->id) }}">Wijzigen</a>

                                        @csrf
                                        @method('DELETE')

                                        {{-- knop en functie dat de dag verwijdert --}}
                                        <button type="submit" class="button button3 buttonSupportedContent">Verwijderen</button>
                                    </form>
                                </td>
                        </tr>
            @endforeach
        </table>
    </div>
@endsection


