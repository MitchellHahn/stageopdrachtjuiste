<?php //@extends('layouts.app')?>
@extends('layouts.app')


{{--@extends('layouts.user.functietoevoegen.layout')--}}


@section('content')

    <?php //pagina van ZZPer module waar hij/zij uren en toeslag kunnen invoeren en facturen aanmaken?>

    <?php // uren en toeslag toevoegen?>

    <div class="container-xl containerSupportedContent">
        <div class="row">
            <div class="col-md">
                <div class="titlebox titleboxSupportedContent">
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
            {{--            <div class="row">--}}

            <tr class="tablehead tableheadSupportedContent">

                {{--                    <div class="col-sm">--}}
                <th class="tableheadfont tableheadfontSupportedContent">Naam</th>
                {{--                    </div>--}}
                {{--                    <div class="col-sm">--}}
                <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Tussenvoegsel en Achternaam</th>
                {{--                    </div>--}}
                {{--                    <div class="col-sm">--}}
                <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">E-mail</th>
                {{--                    </div>--}}
                {{--                    <div class="col-sm">--}}
{{--                <th class="tableheadfont tableheadfontSupportedContent">Soort gebruiker</th>--}}
                {{--                    </div>--}}
                {{--                    <div class="col-sm">--}}
                <th class="tableheadfont tableheadfontSupportedContent"></th>
                {{--                    </div>--}}
            </tr>
            {{--            </div>--}}
            @foreach ($users as $user)
                {{--                <div class="row">--}}
                <tr class="tablerow">

                    {{--                        <div class="col-sm">--}}
                    <td class="tablerowcell tablerowcellSupportedContent">
                        {{ $user->name }}
                        <div class="d-md-none tablerowcellSupportedContent">
                            {{ $user->tussenvoegsel }} {{ $user->achternaam }}<br />
                            {{--                                    {{ $user->email }}--}}
                        </div>
                    </td>
                    {{--                        </div>--}}
                    {{--                        <div class="col-sm">--}}
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $user->tussenvoegsel }} {{ $user->achternaam }}</td>
                    {{--                        </div>--}}
                    {{--                        <div class="col-sm">--}}
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $user->email }}</td>
                    {{--                        </div>--}}

                    {{--toon account_type 0 en 1 als admin en gebruiker--}}

                    {{--                        <div class="col-sm">--}}
{{--                    <td class="tablerowcell tablerowcellSupportedContent">--}}
{{--                        @if($user->account_type == 1)--}}
{{--                            admin--}}
{{--                        @else--}}
{{--                            gebruiker--}}
{{--                        @endif--}}
{{--                    </td>--}}
                    {{--                        </div>--}}

                    {{--                <label>--}}
                    {{--                    <select name="account_type" class="form-control">--}}
                    {{--                        <option value="0">Gebruiker</option>--}}
                    {{--                        <option value="1">Admin</option>--}}
                    {{--                    </select>--}}
                    {{--                </label>--}}

                    {{--toon toeslagen op basis van de tijd--}}
                    {{--                <div class="col-md">--}}
                    <td class="tablerowcell col-xl-4">
                        <form action="{{ route('Gebruikers.destroy',$user->id) }}" class="formSupportedContent" method="POST">

{{--                            <a class="klantenbutton buttonSupportedContent" href="{{ route('Gebruikers.show',$user->id) }}">Tonen</a>--}}

                            <a class="klantenbutton klantenbutton1 buttonSupportedContent" href="{{ route('Toeslagen.create',$user->id) }}">Aanmaken</a>

{{--                            <button type="submit" class="klantenbutton klantenbutton3 buttonSupportedContent">Verwijderen</button>--}}


                            {{--alleen gebruiker met account_type "0" overnemen--}}
                            {{--                            <br>--}}
{{--                            @if($user->account_type == 0 )--}}
{{--                                @canBeImpersonated($user, $guard = null)--}}
{{--                                <a class="factuurbutton buttonSupportedContent" href="{{ route('impersonate', $user->id) }}">Overnemen</a>--}}
{{--                                @endCanBeImpersonated--}}
{{--                            @else--}}
{{--                            @endif--}}
                            {{--                            </br>--}}

                            @csrf
                            @method('DELETE')

                        </form>
                    </td>
                    {{--             </div>--}}
                </tr>
                {{--       </div>--}}
            @endforeach
        </table>
        {{--    {!! $tijden ->links() !!}--}}
    </div>
@endsection


