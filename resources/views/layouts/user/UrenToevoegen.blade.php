<?php //@extends('layouts.app')?>
@extends('layouts.app')


{{--@extends('layouts.user.functietoevoegen.layout')--}}


@section('content')

    <?php //pagina van ZZPer module waar hij/zij uren en toeslag kunnen invoeren en facturen aanmaken?>
    <?php // uren en toeslag toevoegen?>

    {{--  <div class="row">--}}
    {{--        <div class="col-lg-12 margin-tb">--}}
    <div class="container-xl containerSupportedContent">
        <div class="row">
            <div class="col-md">
{{--                <div class="titleboxSupportedContent">--}}
                    <div class="titlebox titleboxSupportedContent">
{{--                        <div class="titleSupportedContent">--}}
                            <h2 class="title titleSupportedContent">Uren</h2>
                            <h class="info infoSupportedContent">Vul hieronder je uren in.</h>
{{--                        </div>--}}
                    </div>
{{--                </div>--}}
            </div>
        </div>
        {{--        </div>--}}
        {{--  </div>--}}
        </br>
        </br>
        </br>
        <div class="row">
            <div class="col-lg">

                <div class="float-right">
{{--                    <div class="createbuttonSupportedContent">--}}

                    {{--                /<a class="btn btn-success" href="{{ route('UToevoegen.create') }}"> uren toevoegen</a>--}}
                    <a class="createbutton createbuttonSupportedContent" href="{{ route('UToevoegen.create') }}">Uren toevoegen</a>
{{--                    </div>--}}
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

{{--            <div class="row">--}}

                <tr class="tablehead tableheadSupportedContent">
{{--                        <div class="col-sm">--}}
                            <th class="tableheadfont tableheadfontSupportedContent">Datum</th>
{{--                        </div>--}}
{{--                        <div class="col-sm">--}}
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Begintijd</th>
{{--                        </div>--}}
{{--                        <div class="col-sm">--}}
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Eindtijd</th>
{{--                        </div>--}}
{{--                        <div class="col-md">--}}
                            <th class="tableheadfont tableheadfontSupportedContent">Klantnaam</th>
{{--                        </div>--}}
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Totaal</th>

                    {{--                        <div class="col-md">--}}
                            <th class="tableheadfont tableheadfontSupportedContent"></th>
{{--                        </div>--}}
                    {{--toeslag--}}

                </tr>

{{--                <div/>--}}
                @foreach ($tijden as $tijd)

{{--                    <div class="row">--}}

                        <tr class="tablerow ">

{{--                            <div class="col-sm">--}}
                                <td class="tablerowcell tablerowcellSupportedContent datepicker">
                                    {{ $tijd->datum->format('d-m-Y') }}
                                    <div class="d-md-none tablerowcellSupportedContent">
                                        {{ $tijd->begintijd }} <br/>
                                        {{ $tijd->eindtijd }} <br/>
                                        {{ $tijd->uren }} uren
                                    </div>
                                </td>
{{--                            </div>--}}
{{--                            <div class="col-sm">--}}

                                <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ date('H:i', strtotime($tijd->begintijd)) }}</td>
{{--                            </div>--}}
{{--                            <div class="col-sm">--}}
                                <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ date('H:i', strtotime($tijd->eindtijd)) }}</td>
{{--                            </div>--}}
{{--                            <div class="col-md">--}}
                                <td class="tablerowcell tablerowcellSupportedContent">{{ $tijd->bedrijf->bedrijfsnaam }}</td>
                                <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $tijd->uren }} uren</td>

                            {{--                            </div>--}}

{{--                            <div class="col-md">--}}
                                <td class="tablerowcell ">

                                    <form action="{{ route('UToevoegen.destroy',$tijd->id) }}" class="formSupportedContent" method="POST">

                                        {{--                        <a class="btn btn-info" href="{{ route('UToevoegen.show',$tijd->id) }}">Show</a>--}}
                                        <a class="button buttonSupportedContent" href="{{ route('UToevoegen.show',$tijd->id) }}">Tonen</a>

                                        {{--                        <a class="btn btn-primary" href="{{ route('UToevoegen.edit',$tijd->id) }}">Edit</a>--}}
                                        <a class="button button2 buttonSupportedContent" href="{{ route('UToevoegen.edit',$tijd->id) }}">Wijzigen</a>

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="button button3 buttonSupportedContent">Verwijderen</button>
                                    </form>
                                </td>
{{--                            </div>--}}
                        </tr>
{{--                    </div>--}}
            @endforeach
        </table>
    </div>
    {{--    {!! $tijden ->links() !!}--}}
@endsection


