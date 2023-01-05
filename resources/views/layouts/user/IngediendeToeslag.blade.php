@extends('layouts.app')

{{--@extends('layouts.user.functietoevoegen.toeslag.layout')--}}


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
                <div class="titlebox titleboxSupportedContent">

{{--                    <div class="titlebox">--}}
                        <h2 class="title titleSupportedContent">Toeslagen</h2>
                        <h class="info infoSupportedContent"> Hier kan je toeslagen indienen.</h>
{{--                    </div>--}}
                </div>
            </div>
        </div>
{{--        </div>--}}
        </br>
        </br>
        </br>

        <div class="row">
          <div class="col-lg">
            <div class="float-right">
                <a class="createbutton createbuttonSupportedContent" href="{{ route('UToevoegenToeslag.create') }}">Toeslag toevoegen</a>
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
            {{--tijd--}}
            {{--            <th>id</th>--}}
        {{--                <div class="col-sm">--}}
{{--                    <th class="tableheadfont tableheadfontSupportedContent">Ingediend op</th>--}}
                    <th class="tableheadfont tableheadfontSupportedContent">Toeslagsoort</th>
        {{--                </div>--}}
        {{--                <div class="col-sm">--}}
                    <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Begintijd</th>
        {{--                </div>--}}
        {{--                <div class="col-sm">--}}
                    <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Eindtijd</th>
        {{--                </div>--}}
        {{--                <div class="col-sm">--}}
{{--                    <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Toeslagsoort</th>--}}
        {{--                </div>--}}
                    <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Totaal</th>

                {{--                <div class="col-sm">--}}
                    <th class="tableheadfont tableheadfontSupportedContent">Percentage</th>
        {{--                </div>--}}
        {{--                <div class="col-sm">--}}
                    <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Uurtarief</th>
        {{--                </div>--}}
        {{--                <div class="col-sm">--}}
                    <th class="tableheadfont tableheadfontSupportedContent"></th>
        {{--                </div>--}}
                    {{--toeslag--}}
                    {{--            <th>toeslag begintijd</th>--}}
                    {{--            <th>toeslag eindtijd</th>--}}
                    {{--            <th>toeslagsoort</th>--}}
                    {{--            <th>toeslag percentage</th>--}}
                    {{--            <th>uurtarief</th>--}}

                    {{--            <th>Action</th>--}}
                </tr>
{{--            <div/>--}}

        {{-- LIJST TOESLAG TONEN VOOR USER--}}
        @foreach ($toeslagen as $toeslag)

        <div class="row">
            <tr class="tablerow">
                {{--                    <td>{{ ++$i }}</td>--}}
{{--                <div class="col-sm">--}}
                    <td class="tablerowcell tablerowcellSupportedContent">
{{--                        {{ $toeslag->datum }}--}}
                        {{ $toeslag->toeslagsoort }}<br/>

                        <div class="d-md-none tablerowcellSupportedContent">
                        {{ date('H:i', strtotime($toeslag->toeslagbegintijd)) }}<br/>
                        {{ date('H:i', strtotime($toeslag->toeslageindtijd)) }}<br/>
{{--                        {{ $toeslag->toeslagsoort }}<br/>--}}
                        €{{ $toeslag->tarief->bedrag }}<br/>
                         {{ $toeslag->toeslaguren }} uren
                        </div>
                    </td>
{{--                </div>--}}
{{--                <div class="col-sm">--}}
                    <td class="tablerowcell  d-none d-md-table-cell tablerowcellSupportedContent">{{ date('H:i', strtotime($toeslag->toeslagbegintijd)) }}</td>
{{--                </div>--}}
{{--                <div class="col-sm">--}}
                    <td class="tablerowcell  d-none d-md-table-cell tablerowcellSupportedContent">{{ date('H:i', strtotime($toeslag->toeslageindtijd)) }}</td>
{{--                </div>--}}
{{--                <div class="col-sm">--}}
{{--                    <td class="tablerowcell  d-none d-md-table-cell tablerowcellSupportedContent">{{ $toeslag->toeslagsoort }}</td>--}}
{{--                </div>--}}
                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $toeslag->toeslaguren }} uren</td>

                {{--                <div class="col-sm">--}}
                    <td class="tablerowcell tablerowcellSupportedContent">{{ $toeslag->toeslagpercentage }}%</td>
{{--                </div>--}}
{{--                <div class="col-sm">--}}
                    <td class="tablerowcell  d-none d-md-table-cell tablerowcellSupportedContent">€{{ $toeslag->tarief->bedrag }}</td>
{{--                </div>--}}

                    {{--                <td>{{ $toeslag->user_id }}</td>--}}

                {{--                    <td>{{ $tijd->eindtijd }}</td>--}}
                {{--                    <td>{{ $tijd->eindtijd }}</td>--}}
                {{--                    <td>{{ $tijd->eindtijd }}</td>--}}
                {{--                    <td>{{ $tijd->eindtijd }}</td>--}}

                {{--toon toeslagen op basis van de tijd--}}
                {{--                    <td>{{ $tijd->toeslagen->count() }}</td>--}}
                    <td class="tablerowcell">
                    <form action="{{ route('UToevoegenToeslag.destroy',$toeslag->id) }}" class="formSupportedContent" method="POST">

                        <a class="button buttonSupportedContent" href="{{ route('UToevoegenToeslag.show',$toeslag->id) }}">Tonen</a>

                        <a class="button button2 buttonSupportedContent" href="{{ route('UToevoegenToeslag.edit',$toeslag->id) }}">Wijzigen</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="button button3 buttonSupportedContent">Verwijderen</button>
                    </form>
                </td>
              </div>
            </tr>
        </div>
            @endforeach
    </table>
    {{--    {!! $tijden ->links() !!}--}}
</div>
@endsection


