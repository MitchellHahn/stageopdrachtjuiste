@extends('layouts.app')

@section('content')

    <?php //pagina van ZZPer module waar hij/zij uren en toeslag kunnen invoeren en facturen aanmaken?>

{{--    <div class="container">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
{{----}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <?php // uren en toeslag toevoegen?>

{{--    <div class="row">--}}
{{--        <div class="col-lg-12 margin-tb">--}}
    <div class="container-xl containerSupportedContent">
        <div class="row">
            <div class="col-md">
{{--                <div class="titleboxSupportedContent">--}}

                    <div class="titlebox titleboxSupportedContent">

                        <h2 class="title titleSupportedContent">Klanten</h2>
                        <h class="info infoSupportedContent">Registreer hier een klant.</h>
                    </div>
{{--                </div>--}}
            </div>
        </div>
{{--        </div>--}}
            </br>
            </br>
            </br>
        <div class="row">
            <div class="col-lg">
                <div class="float-right">
                <a class="createbutton createbuttonSupportedContent" href="{{ route('Klanten.create') }}"> Klant registreren</a>
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
                            <th class="tableheadfont tableheadfontSupportedContent">Klantnaam</th>
{{--                        </div>--}}
{{--                        <div class="col-sm">--}}
                            <th class="tableheadfont tableheadfontSupportedContent">Debnummer</th>
{{--                        </div>--}}
{{--                        <div class="col-sm">--}}
{{--                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">E-mail</th>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm">--}}
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Straat</th>
{{--                        </div>--}}
{{--                        <div class="col-sm">--}}
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Huisnummer</th>
{{--                        </div>--}}
        {{--                <div class="col-sm">--}}
        {{--                    <th class="tableheadfont">Toevoeging</th>--}}
        {{--                </div>--}}
{{--                        <div class="col-sm">--}}
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Postcode</th>
{{--                        </div>--}}
{{--                        <div class="col-sm">--}}
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Stad</th>
{{--                        </div>--}}
{{--                        <div class="col-sm">--}}
                            <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Land</th>
{{--                        </div>--}}
{{--                        <div class="col-md">--}}
                            <th class="tableheadfont tableheadfontSupportedContent"></th>
{{--                        </div>--}}

        </tr>
{{--    <div/>--}}
            @foreach ($bedrijven as $bedrijf)

{{--    <div class="row">--}}
            <tr class="tablerow">

{{--                <div class="col-sm">--}}
                    <td class="tablerowcell tablerowcellSupportedContent">
                        {{ $bedrijf->bedrijfsnaam	 }}
                        <div class="d-md-none tablerowcellSupportedContent">
{{--                            {{ $bedrijf->email }}<br />--}}
                            {{ $bedrijf->straat }}<br />
                            {{ $bedrijf->huisnummer }}{{ $bedrijf->toevoeging }}<br />
                            {{ $bedrijf->postcode }}<br />
                            {{ $bedrijf->stad }}<br />
                            {{ $bedrijf->land}}
                        </div>

                    </td>
{{--                </div>--}}
{{--                <div class="col-sm">--}}
                    <td class="tablerowcell tablerowcellSupportedContent">{{ $bedrijf->debnummer }}</td>
{{--                </div>--}}
{{--                <div class="col-sm">--}}
{{--                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $bedrijf->email }}</td>--}}
{{--                </div>--}}
{{--                <div class="col-sm">--}}
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $bedrijf->straat }}</td>
{{--                </div>--}}
{{--                <div class="col-sm">--}}
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $bedrijf->huisnummer }} {{ $bedrijf->toevoeging }}</td>
{{--                </div>--}}
{{--                <div class="col-sm">--}}
{{--                    <td class="tablerowcell">{{ $bedrijf->toevoeging }}</td>--}}
{{--                </div>--}}
{{--                <div class="col-sm">--}}
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $bedrijf->postcode }}</td>
{{--                </div>--}}
{{--                <div class="col-sm">--}}
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $bedrijf->stad }}</td>
{{--                </div>--}}
{{--                <div class="col-sm">--}}
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $bedrijf->land }}</td>
{{--                </div>--}}

{{--                <div class="col-md">--}}
                    <td class="tablerowcell">
                    <form action="{{ route('Klanten.destroy',$bedrijf->id) }}" class="formSupportedContent" method="POST">

                        <a class="klantenbutton buttonSupportedContent" href="{{ route('Klanten.show',$bedrijf->id) }}">Tonen</a>

                        <a class="klantenbutton klantenbutton2 buttonSupportedContent" href="{{ route('Klanten.edit',$bedrijf->id) }}">Wijzigen</a>


                        @csrf
                        @method('DELETE')

                        <button type="submit" class="klantenbutton klantenbutton3 buttonSupportedContent">Verwijderen</button>

                    {{--knop om een factuur te maken--}}
{{--                        <br>--}}
                        <a class="factuurbutton buttonSupportedContent" href="{{ route('Factuur.select',$bedrijf->id) }}">Facturen</a>
{{--                        </br>--}}
                    </form>
                </td>
{{--              </div>--}}
            </tr>
{{--        </div>--}}
            @endforeach
    </table>
    {{--    {!! $tijden ->links() !!}--}}
<div/>

@endsection


