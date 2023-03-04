@extends('layouts.app')


@section('content')

    {{--     pagina van zpper module waar ze zijn toeslagen kan bekijken --}}


    <div class="container-xl containerSupportedContent">
        <div class="row">
            <div class="col-md">
                <div class="titlebox titleboxSupportedContent">
                    {{-- titel en onschrijving van de pagina--}}
                        <h2 class="title titleSupportedContent">Toeslagen</h2>
                        <h class="info infoSupportedContent"> Hier kan je toeslagen bekijken.</h>
                </div>
            </div>
        </div>
{{--        </div>--}}
        </br>
        </br>
        </br>


    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="container-xl containerSupportedContent" >
        <table class="table table-bordered">
            <tr class="tablehead tableheadSupportedContent">

                {{--      toon Toeslagsoort ,Begintijd, Eindtijd, E-Aantal en Percentage in het hoofd van de tabel      --}}
                    <th class="tableheadfont tableheadfontSupportedContent">Toeslagsoort</th>

                    <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Begintijd</th>

                    <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Eindtijd</th>

                    <th class="tableheadfont d-none d-md-table-cell tableheadfontSupportedContent">Aantal</th>

                    <th class="tableheadfont tableheadfontSupportedContent">Percentage</th>

                </tr>

        {{-- LIJST TOESLAG TONEN VOOR USER--}}
        @foreach ($toeslagen as $toeslag)

        <div class="row">
            <tr class="tablerow">

                {{-- voor mobile gegevens op deze manier tonen --}}
                    <td class="tablerowcell tablerowcellSupportedContent">
                        {{ $toeslag->toeslagsoort }}<br/>

                        <div class="d-md-none tablerowcellSupportedContent">
                        {{ date('H:i', strtotime($toeslag->toeslagbegintijd)) }}<br/>
                        {{ date('H:i', strtotime($toeslag->toeslageindtijd)) }}<br/>

                         {{ $toeslag->toeslaguren }} uren
                        </div>
                    </td>

                {{--      toon de Toeslagsoort ,Begintijd, Eindtijd, E-Aantal en Percentage van elke toeslag van de gebruiker in de tabel      --}}
                    <td class="tablerowcell  d-none d-md-table-cell tablerowcellSupportedContent">{{ date('H:i', strtotime($toeslag->toeslagbegintijd)) }}</td>

                    <td class="tablerowcell  d-none d-md-table-cell tablerowcellSupportedContent">{{ date('H:i', strtotime($toeslag->toeslageindtijd)) }}</td>

                    <td class="tablerowcell d-none d-md-table-cell tablerowcellSupportedContent">{{ $toeslag->toeslaguren }} uren</td>

                    <td class="tablerowcell tablerowcellSupportedContent">{{ $toeslag->toeslagpercentage }}%</td>

              </div>
            </tr>
        </div>
            @endforeach
    </table>

</div>
@endsection


