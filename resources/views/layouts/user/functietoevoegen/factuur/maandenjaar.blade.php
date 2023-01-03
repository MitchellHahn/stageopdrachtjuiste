@extends('layouts.app')

@section('content')

<section class="section">

    <div class="container-lg height100 no-padding containerSupportedContent">
        <div class="row">
            <div class="col-lg">

            {{--                <h5><i>Factuur aanmaken</i></h5>--}}
{{--                <h><i> Hier kan je facturen aanmaken voor een gekozen periode of datum.</i></h>--}}

{{-- facetuur resultaten voor de gekozen bedrijf--}}

                <div class="titlebox titleboxSupportedContent">

                    <h2 class="title titleSupportedContent">Klanten</h2>
                    <p class="info infoSupportedContent">Gemaakte facturen van gekozen klant.</p>

                </div>
            </div>
        </div>
{{--    </div>--}}
{{--                    <div class="col-md-4 col-md-offset-4">--}}
{{--                    <div class="col-md-8 col-md-offset-2">--}}

    </br>
    </br>
    </br>

    <div class="row justify-content-center ">
        <div class="col-md-11">
            <div class="float-right">
                <a class="createbutton createbuttonSupportedContent" href="{{ route('Klanten.index') }}">Terug</a>
            </div>
        </div>
    </div>

<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-11 sectioninner">

            <div class="row justify-content-center">
                <div class="col-md-8">

                    @if(count($facturen)>0)



                           <table class="table table-bordered">
                            <div class="row">
                                <tr class="tablehead tableheadSupportedContent">

{{--                                <div class="col-sm">--}}
                                    <th class="tableheadfont tableheadfontSupportedContent">Factuurnaam</th>
{{--                                </div>--}}
{{--                                <div class="col-sm">--}}
                                    <th class="tableheadfont tableheadfontSupportedContent">Periode</th>
{{--                                </div>--}}
                                    {{--                            <th>Klant</th>--}}
                                </tr>
                            </div>

                        @foreach($facturen as $factuur)
                            <div class="row">
                                <tr class="tablerow">
{{--                                    <div class="col-sm">--}}
                                        <td class="tableheadfont tablerowcellSupportedContent">{{ $factuur->naam }}</td>
{{--                                    </div>--}}
{{--                                    <div class="col-sm">--}}
                                        <td class="tableheadfont tablerowcellSupportedContent">{{ date('M Y', strtotime($factuur->startdatum)) }}</td>
{{--                                    </div>--}}

                                    {{--                                    <td>{{ $factuur->bedrijf->bedrijfsnaam }}</td>--}}

                                </tr>
                            @endforeach
                        </table>

                    @else
                        <h6 class="text-center"><i>Geen facturen gevonden voor het gekozen bedrijf</i></h6>
                    @endif

{{--Factuur aanmaken door maand en jaar te kiezen--}}
                <form method="GET" action="{{ route('Factuurmaand.select', $bedrijf->id ) }}">

</br>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h7 class="text-center tablerowcellSupportedContent"><b>Maak een factuur aan voor:</b></h7>

                        <div class="form-group">

                            <strong class="tablerowcellSupportedContent">Maand:</strong>
                            <label for="">
                                <select name="month" class="form-control tablerowcellSupportedContent">

                                    {{--                                    {!! Form::selectMonth('month') !!}--}}

                                    @for($month=1; $month <= 12; $month++)
                                        <option value="{{$month}}">{{$month}}</option>
                                    @endfor

                                </select>
                            </label>
{{--                        </div>--}}
{{--                    </div>--}}


{{--                    <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                        <div class="form-group">--}}

                            <strong class="tablerowcellSupportedContent">Jaar:</strong>
                            <label for="">
                                <select name="year" class="form-control tablerowcellSupportedContent">

                                    {{--                                    {!! Form::selectYear('year', 1900, 2022) !!}--}}

                                    @for($year=2000; $year <= 2023; $year++)
                                        <option value="{{$year}}">{{$year}}</option>
                                    @endfor

                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                    <input type="submit" value="Aanmaken" class="createbutton createbuttonSupportedContent">
                    </div>

                </form>
            </div>
        </div>
        </div>
        </div>
        </div>
    </div>

</section>

@endsection
