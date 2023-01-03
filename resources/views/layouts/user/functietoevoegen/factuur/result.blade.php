
@extends('layouts.app')

{{--@extends('layouts.master')--}}
@section('content')
    <section class="section">

        <div class="container-lg height100 no-padding containerSupportedContent">
            <div class="row">
                <div class="col-lg">
                    <div class="titlebox titleboxSupportedContent">

                        <h2 class="title titleSupportedContent">Resultaten</h2>
                        <p class="info infoSupportedContent">Geregistreerde uren voor de gekozen maand.</p>

                    </div>
                </div>
            </div>

            </br>
            </br>
            </br>

            <div class="container-lg">
                <div class="row justify-content-center">
                    <div class="col-md-11 sectioninner">

                        <div class="row justify-content-center">
                            <div class="col-md-8">

                                @if(count($tijden)>0)
                                    <table class="table table-bordered">
                                        <div class="row">
                                            <tr class="tablehead tableheadSupportedContent">

                                                {{--                                <div class="col-sm">--}}
                                                <th class="tableheadfont tableheadfontSupportedContent">Datum</th>
                                                {{--                                </div>--}}
                                                {{--                                <div class="col-sm">--}}
                                                <th class="tableheadfont tableheadfontSupportedContent">Begintijd</th>
                                                {{--                                </div>--}}
                                                {{--                                <div class="col-sm">--}}
                                                <th class="tableheadfont tableheadfontSupportedContent">Eindtijd</th>
                                                {{--                                </div>--}}

                                            </tr>
                                        </div>

                                        @foreach($tijden as $tijd)
                                            <div class="row">
                                                <tr class="tablerow">

                                                    {{--                                    <div class="col-sm">--}}
                                                    <td class="tableheadfont tablerowcellSupportedContent">{{ date('d M Y', strtotime($tijd->tijden_datum)) }}</td>
                                                    {{--                                    </div>--}}
                                                    {{--                                    <div class="col-sm">--}}
                                                    <td class="tableheadfont tablerowcellSupportedContent">{{ date('H:i', strtotime($tijd->begintijd)) }}</td>
                                                    {{--                                    </div>--}}
                                                    {{--                                    <div class="col-sm">--}}
                                                    <td class="tableheadfont tablerowcellSupportedContent">{{ date('H:i', strtotime($tijd->eindtijd)) }}</td>
                                                    {{--                                    </div>--}}

                                                </tr>
                                            </div>
                                        @endforeach
                                        {{--                        </tbody>--}}
                                        <div class="row">
                                            <tr class="tablerow">
                                                {{--                                    <div class="col-sm">--}}
                                                <td class="tableheadfont tablerowcellSupportedContent"><a href="{{route('Factuur.pdf', $factuur)}}">Downloaden</a></td>
                                                {{--                                    </div>--}}
                                                {{--                                    <div class="col-sm">--}}
                                                <td class="tableheadfont tablerowcellSupportedContent"><a href="{{route('Factuursend.pdf', ['factuur' => $factuur, 'month' => $month, 'year' => $year])}}">Verzenden</a></td>
                                                {{--                                    </div>--}}
                                                {{--                                    <div class="col-sm">--}}
                                                <td><a></a></td>
                                        </div>
                                        </tr>
                            </div>
                            </table>

                            {{--///////////////////facturen sturen naar Klant email///////////////////////////////--}}
                            </br>

                            <div class="row">
                                <div class="col-sm-8">
                                    <strong class="tablerowcellSupportedContent">Factuur verzenden naar:</strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-9" >
                                    {{--                                    <strong class="tablerowcellSupportedContent">Klant e-mail:</strong>--}}

                                    <strong class="tablerowcellSupportedContent">Klant e-mail:</strong>
                                    <label class="tablerowcellSupportedContent">
                                        <td>{{ $bedrijf->email }}</td>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9" >

                                    {{--////////////////////////////////CC: brouwers email//////////////////////////////////////--}}
                                    {{--                        <form action="{{ route('Factuuremail.update', [\Auth::user()->brouwerscontact]) }}" method="POST">--}}

                                    @isset(\Auth::user()->brouwerscontact)
                                        <form action="{{ route('Factuuremail.destroy',\Auth::user()->brouwerscontact->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            {{----}}

                                            <strong class="tablerowcellSupportedContent">CC:</strong>
                                            <label class="tablerowcellSupportedContent">
                                                <td>{{  $bemail = \Auth::user()->brouwerscontact->email }}</td>
                                            </label>
                                            <a class="createbutton createbuttonSupportedContent" href="{{ route('Factuuremail.edit', ['brouwerscontact' => \Auth::user()->brouwerscontact->id, 'bedrijf' => $bedrijf->id]) }}">CC: Aanpassen</a>
                                            <a href="{{ route('Factuur.select',\Auth::user()->brouwerscontact->id) }}" class="createbutton createbuttonSupportedContent">Terug</a>
                                            </br>

                                        </form>
                                    @else
                                        <a class="createbutton createbuttonSupportedContent" href="{{ route('Factuuremail.create', ['bedrijf' => $bedrijf->id]) }}">CC: aanmaken</a>
                                    @endisset
                                </div>
                            </div>
                        </div>

                        {{--//////////////////////////////////////////////////////////////////////--}}
                        @else
                            <h5 class="text-center tablerowcellSupportedContent"><i>Geen geregistreerde uren gevonden voor de gekozen periode</i></h5>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        </div>

    </section>
    {{--    </div>--}}
    {{--    </div>--}}
@endsection

