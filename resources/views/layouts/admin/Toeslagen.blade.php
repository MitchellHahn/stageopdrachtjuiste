<?php //@extends('layouts.app')?>
@extends('layouts.app')




@section('content')

{{--    pagina van medewerkers module waar B-medewerker toeslagen voor zppers kunnen aanmaken--}}


    <div class="container-xl containerSupportedContent">
        <div class="row">
            <div class="col-md">
                <div class="titlebox titleboxSupportedContent">
                    {{-- Titel en beshcrijving van de pagina --}}
                    <h2 class="title titleSupportedContent">Toeslag</h2>
                    <h class="info infoSupportedContent">Overzicht van alle ZPP'ers.</h>
                </div>
            </div>
        </div>
    </div>

    </br>
    </br>
    </br>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="container-xl containerSupportedContent" >
        <table class="table table-bordered">

            <tr class="tablehead tableheadSupportedContent">

                {{--      toon Naam ,Tussenvoegsel, Achternaam en E-mail in het hoofd van de tabel      --}}
                <th class="tableheadfont tableheadfontSupportedContent">Naam</th>

                <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Tussenvoegsel en Achternaam</th>

                <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">E-mail</th>

                <th class="tableheadfont tableheadfontSupportedContent"></th>
            </tr>
            @foreach ($users as $user)
                <tr class="tablerow">


                    <td class="tablerowcell tablerowcellSupportedContent">
                        {{ $user->name }}
                        <div class="d-md-none tablerowcellSupportedContent">
                            {{ $user->tussenvoegsel }} {{ $user->achternaam }}<br />
                        </div>
                    </td>

                    {{--      toon de Naam ,Tussenvoegsel, Achternaam en E-mail van elke zpper in de tabel      --}}

                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $user->tussenvoegsel }} {{ $user->achternaam }}</td>

                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $user->email }}</td>


                    <td class="tablerowcell col-xl-4">

                            {{-- Knop voor het tonen van het venster dat een toeslag voor zpper aanmaakt --}}
                            <a class="klantenbutton klantenbutton1 buttonSupportedContent" href="{{ route('Toeslagen.aanmaken',$user->id) }}">Aanmaken</a>

                            @csrf
                            @method('DELETE')

                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection


