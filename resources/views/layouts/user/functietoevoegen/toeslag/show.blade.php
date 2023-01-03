@extends('layouts.app')

{{--@extends('layouts.user.functietoevoegen.toeslag.layout')--}}


@section('content')

    <?php //pagina van ZZPer module waar hij/zij uren en toeslag kunnen invoeren en facturen aanmaken?>
    <?php // uren en toeslag toevoegen?>
<section class="section" >
    <div class="container-lg height100 no-padding containerSupportedContent">
        <div class="row">
            <div class="col-lg">
                <div class="titlebox titleboxSupportedContent">

                <h2 class="title titleSupportedContent">Toeslagen</h2>
                <h class="info infoSupportedContent">Ingediende uren voor doorgegeven toeslag</h>
            </div>
        </div>
    </div>

        </br>
        </br>
        </br>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="float-right">
                        <a class="createbutton createbuttonSupportedContent" href="{{ route('UToevoegenToeslag.index') }}">Terug</a>
                </div>
            </div>
        </div>
{{--    </div>--}}

        <div class="container-lg height73">
            <div class="row height100 justify-content-center">
                <div class="col-md-12 height100 sectioninner" style="align-self:flex-end;">

                    <div class="row justify-content-center">
                        <div class="col-md-8">

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

{{--    <div class="container-lg">--}}
        <table class="table table-bordered">
            <div class="row">
                <tr class="tablehead tableheadSupportedContent">

{{--                    <div class="col-sm">--}}
                        <th class="tableheadfont tableheadfontSupportedContent">Datum</th>
{{--                    </div>--}}

{{--                    <div class="col-sm">--}}
                        <th class="tableheadfont tableheadfontSupportedContent">Begintijd</th>
{{--                    </div>--}}

{{--                    <div class="col-sm">--}}
                        <th class="tableheadfont tableheadfontSupportedContent">Eindtijd</th>
{{--                    </div>--}}

                </tr>
            </div>
        {{-- LIJST TOESLAG TONEN VOOR USER--}}
        @foreach ($tijden  as $tijd)
                <div class="row">
                    <tr class="tablerow">

{{--                        <div class="col-sm">--}}
                            <td class="tablerowcell tablerowcellSupportedContent">{{ $tijd->datum->format('d-m-Y') }}</td>
{{--                        </div>--}}
{{--                        <div class="col-sm">--}}
                            <td class="tablerowcell tablerowcellSupportedContent">{{ date('H:i', strtotime($tijd->begintijd)) }}</td>
{{--                        </div>--}}
{{--                        <div class="col-sm">--}}
                            <td class="tablerowcell tablerowcellSupportedContent">{{ date('H:i', strtotime($tijd->eindtijd)) }}</td>
{{--                        </div>--}}

                    </tr>
                </div>
        @endforeach
    </table>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection


