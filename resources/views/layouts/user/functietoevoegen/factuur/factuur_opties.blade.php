
@extends('layouts.app')

@section('content')
    {{--     pagina van zzper module waar de gewerkte dagen voor gekozen klant en periode worden getoond--}}

    <section class="section">

        <div class="container-lg height100 no-padding containerSupportedContent">
            <div class="row">
                <div class="col-lg">
                    <div class="titlebox titleboxSupportedContent">

                        {{-- titel en onschrijving van de pagina--}}
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
                                            {{--      toon Datum ,Begintijd en Eindtijd in het hoofd van de tabel      --}}
                                            <tr class="tablehead tableheadSupportedContent">

                                                <th class="tableheadfont tableheadfontSupportedContent">Datum</th>
                                                <th class="tableheadfont tableheadfontSupportedContent">Begintijd</th>
                                                <th class="tableheadfont tableheadfontSupportedContent">Eindtijd</th>

                                            </tr>
                                        </div>

                                        @foreach($tijden as $tijd)
                                            <div class="row">
                                                <tr class="tablerow">

                                                    {{-- toont de Datum ,Begintijd en Eindtijd van elke gewerkte dag van de gekozen maand en klant, in de tabel --}}
                                                    <td class="tableheadfont tablerowcellSupportedContent">{{ date('d M Y', strtotime($tijd->tijden_datum)) }}</td>
                                                    <td class="tableheadfont tablerowcellSupportedContent">{{ date('H:i', strtotime($tijd->begintijd)) }}</td>
                                                    <td class="tableheadfont tablerowcellSupportedContent">{{ date('H:i', strtotime($tijd->eindtijd)) }}</td>

                                                </tr>
                                            </div>
                                        @endforeach
                                        <div class="row">
                                            <tr class="tablerow">
                                                {{-- deze knop maakt een factuur aan en download het    --}}
                                                <td class="tableheadfont tablerowcellSupportedContent"><a href="{{route('Factuurdownloaden.pdf', $factuur)}}">Downloaden</a></td>

                                                {{-- deze knop maakt een factuur aan en verzend het naar de klant en brouwerd contactpersoon    --}}
                                                <td class="tableheadfont tablerowcellSupportedContent"><a href="{{route('Factuurverzenden.pdf', ['factuur' => $factuur, 'month' => $month, 'year' => $year])}}">Verzenden</a></td>
                                                <td><a></a></td>
                                        </div>
                                        </tr>
                            </div>
                            </table>

                            {{--///////////////////facturen sturen naar Klant email///////////////////////////////--}}
                            </br>

                            {{-- toont de text verzenden naar    --}}
                            <div class="row">
                                <div class="col-sm-8">
                                    <strong class="tablerowcellSupportedContent">Factuur verzenden naar:</strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-9" >
                                    {{-- toont de text ""Klant e-mail:" en de e-mailadres van de klant    --}}
                                    <strong class="tablerowcellSupportedContent">Klant e-mail:</strong>
                                    <label class="tablerowcellSupportedContent">
                                        <td>{{ $bedrijf->email }}</td>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9" >

                                    {{--functie dat de e-mail van de cc verdert--}}
                                    @isset(\Auth::user()->brouwerscontact)
                                        <form action="{{ route('Factuuremail.CC_verwijderen',\Auth::user()->brouwerscontact->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            {{-- toont text "CC:" en e-mailadres dat in de CC: staat--}}
                                            <strong class="tablerowcellSupportedContent">CC:</strong>
                                            <label class="tablerowcellSupportedContent">
                                                <td>{{  $bemail = \Auth::user()->brouwerscontact->email }}</td>
                                            </label>

                                            {{-- knop dat de venster toont dat de e-mail die in de CC: staat wijzigt --}}
                                            <a class="createbutton createbuttonSupportedContent" href="{{ route('Factuuremail.CC_wijzigen', ['brouwerscontact' => \Auth::user()->brouwerscontact->id, 'bedrijf' => $bedrijf->id]) }}">CC: Aanpassen</a>

                                            {{-- knop dat terug gaat naar de venster waar de factuur wordt aangemaakt--}}
                                            <a href="{{ route('Factuur.gemaakte_facturen_van_klant_tonen',\Auth::user()->brouwerscontact->id) }}" class="createbutton createbuttonSupportedContent">Terug</a>
                                            </br>

                                        </form>

                                        {{-- knop dat de venster toont waarin CC: e-mail wordt aangemaakt--}}
                                    @else
                                        <a class="createbutton createbuttonSupportedContent" href="{{ route('Factuuremail.CC_aanmaken', ['bedrijf' => $bedrijf->id]) }}">CC: aanmaken</a>
                                    @endisset
                                </div>
                            </div>
                        </div>

                        {{-- toont deze melding als de er geen uren zijn geregistreerd voor de gekozen maand en klant--}}
                        @else
                            <h5 class="text-center tablerowcellSupportedContent"><i>Geen geregistreerde uren gevonden voor de gekozen periode</i></h5>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        </div>

    </section>
@endsection

