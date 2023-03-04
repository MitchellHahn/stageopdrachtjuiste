@extends('layouts.app')

@section('content')

<section class="section">

    <div class="container-lg height100 no-padding containerSupportedContent">
        <div class="row">
            <div class="col-lg">

                {{--     pagina van zzper module waar factuur wordt gedownload of verzonden--}}


                <div class="titlebox titleboxSupportedContent">
                    {{-- titel en onschrijving van de pagina--}}
                    <h2 class="title titleSupportedContent">Klanten</h2>
                    <p class="info infoSupportedContent">Gemaakte facturen van gekozen klant.</p>

                </div>
            </div>
        </div>


    </br>
    </br>
    </br>

    <div class="row justify-content-center ">
        <div class="col-md-11">
            <div class="float-right">
                {{-- knop dat terug gaat naar de pagina waar je de klant en maan kan selecteren --}}
                <a class="createbutton createbuttonSupportedContent" href="{{ route('Klanten.overzicht_alle_klanten') }}">Terug</a>
            </div>
        </div>
    </div>

<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-md-11 sectioninner">

            <div class="row justify-content-center">
                <div class="col-md-8">

                    @if(count($facturen)>0)


                        {{-- toont alle aangemaakt faceturen voor de gekozen bedrijf--}}

                           <table class="table table-bordered">
                            <div class="row">
                                <tr class="tablehead tableheadSupportedContent">
                                    {{-- toone tekst "factuurnaam en periode"--}}
                                    <th class="tableheadfont tableheadfontSupportedContent">Factuurnaam</th>

                                    <th class="tableheadfont tableheadfontSupportedContent">Periode</th>

                                </tr>
                            </div>

                        @foreach($facturen as $factuur)
                            <div class="row">
                                <tr class="tablerow">
                                    {{-- toone tekst naam er startdatum (alleen maand en jaar) van de factuur--}}
                                        <td class="tableheadfont tablerowcellSupportedContent">{{ $factuur->naam }}</td>
                                        <td class="tableheadfont tablerowcellSupportedContent">{{ date('M Y', strtotime($factuur->startdatum)) }}</td>

                                </tr>
                            @endforeach
                        </table>

                        {{-- toont deze melding als er geen facturen zijn  aangemaakt voor de gekozen klant--}}
                    @else
                        <h6 class="text-center"><i>Geen facturen gevonden voor het gekozen bedrijf</i></h6>
                    @endif

                {{--Factuur aanmaken door maand en jaar te kiezen--}}
                {{-- stuurt de resultaten van deze functie naar de volgende vnetser--}}
                <form method="GET" action="{{ route('Factuurmaand.uren_van_maand_tonen', $bedrijf->id ) }}">

</br>
                    <div class="col-xs-12 col-sm-12 col-md-12">

                        <h7 class="text-center tablerowcellSupportedContent"><b>Maak een factuur aan voor:</b></h7>

                        <div class="form-group">

                            <strong class="tablerowcellSupportedContent">Maand:</strong>
                            <label for="">
                                <select name="month" class="form-control tablerowcellSupportedContent">

                                    {{--toont de 12 maanden dat geselecteerd kan worden in en drop down lijst--}}
                                    @for($month=1; $month <= 12; $month++)
                                        <option value="{{$month}}">{{$month}}</option>
                                    @endfor

                                </select>
                            </label>

                            <strong class="tablerowcellSupportedContent">Jaar:</strong>
                            <label for="">
                                <select name="year" class="form-control tablerowcellSupportedContent">

                                    {{--toont de jaren van 2000 t/m 2023 dat geselecteerd kan worden in en drop down lijst--}}
                                    @for($year=2000; $year <= 2023; $year++)
                                        <option value="{{$year}}">{{$year}}</option>
                                    @endfor

                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                    {{--  zoekt naar alle gewerkte tijden van maand en klant en toont het in de volgende venstrer    --}}
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
