<?php //@extends('layouts.app')?>
@extends('layouts.app')




@section('content')

{{--     pagina van medewerker module waar b-medewerker gegbruikers kan beheren--}}

    <div class="container-xl containerSupportedContent">
        <div class="row">
            <div class="col-md">
                <div class="titlebox titleboxSupportedContent">
                    {{-- titel en onschrijving van de pagina--}}
                    <h2 class="title titleSupportedContent">Gebruikers</h2>
                    <h class="info infoSupportedContent">Overzicht van alle gebruikers.</h>
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

                    {{--      toon Naam ,Tussenvoegsel, Achternaam, E-mail en soort gebruiker in het hoofd van de tabel      --}}
                        <th class="tableheadfont tableheadfontSupportedContent">Naam</th>
                        <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Tussenvoegsel en Achternaam</th>
                        <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">E-mail</th>
                        <th class="tableheadfont tableheadfontSupportedContent">Soort gebruiker</th>

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

                        {{--      toon de Naam ,Tussenvoegsel, Achternaam en E-mail van elke gebruiker in de tabel      --}}
                            <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $user->tussenvoegsel }} {{ $user->achternaam }}</td>

                            <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $user->email }}</td>

                        {{--toon account_type 0 en 1 als admin en gebruiker--}}
                            <td class="tablerowcell tablerowcellSupportedContent">
                                @if($user->account_type == 1)
                                    admin
                                @else
                                    gebruiker
                                @endif
                            </td>

                    <td class="tablerowcell col-xl-4">
                        <form action="{{ route('Gebruikers.gebruiker_verwijderen',$user->id) }}" class="formSupportedContent" method="POST">

                            {{--knop voor het tonen van de gegevens van de geselecteerde gebruiker  --}}
                            <a class="klantenbutton buttonSupportedContent" href="{{ route('Gebruikers.gegevens_tonen',$user->id) }}">Tonen</a>

                            {{--knop voor het wijzigen van de gegevens van de geselecteerde gebruiker  --}}
                            <a class="klantenbutton klantenbutton2 buttonSupportedContent" href="{{ route('Gebruikers.gegevens_wijzigen',$user->id) }}">Wijzigen</a>

                            {{--knop voor het verwijderen van de account van de gebruiker  --}}
                            <button type="submit" class="klantenbutton klantenbutton3 buttonSupportedContent">Verwijderen</button>


                            {{--alleen gebruiker met account_type "0" overnemen--}}
                            {{--overnemen knop alleen bij gebruikers met account_type "0" tonen--}}
                            @if($user->account_type == 0 )
                                @canBeImpersonated($user, $guard = null)
                                <a class="factuurbutton buttonSupportedContent" href="{{ route('gebruiker_overnemen', $user->id) }}">Overnemen</a>
                                @endCanBeImpersonated
                            @else
                            @endif

                            @csrf
                            @method('DELETE')

                        </form>
                </td>
          </tr>
        @endforeach
    </table>
</div>
@endsection


