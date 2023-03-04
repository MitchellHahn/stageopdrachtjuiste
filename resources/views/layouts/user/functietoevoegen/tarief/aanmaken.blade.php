@extends('layouts.app')

@section('content')
    <section class="section">
{{-- hier wordt er een tarief aangemaakt (zpper module) --}}
        <div class="container-md height100 containerSupportedContent">
        <div class="row">
            <div class="col-md">
                <div class="titlebox titleboxSupportedContent">
                    {{-- Titel en beshcrijving van de pagina --}}
                    <h3 class="title titleSupportedContent">Tarief wijzigen</h3>
                    <h class="info infoSupportedContent">Nieuwe tarief registreren</h>
                </div>
            </div>
        </div>

        </br>
        </br>
        </br>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="float-right">
                    {{-- Knop om terug te gaan naar de profiel pagina --}}
                    <a class="createbutton createbuttonSupportedContent" href="{{ route('BProfiel.overzicht_profiel_gegevens') }}">Terug</a>
                </div>
            </div>
        </div>

        <div class="container-md  " >
            <div class="row justify-content-center">

                <div class="col-sm-8 sectioninner">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        {{-- slaar de ingevoerd uut terif op--}}
                        <form action="{{ route('BProfieltarief.opslaan') }}" method="POST">
                        @csrf

                            <div class="row justify-content-center">
                            <div class="col-sm-12">
                                {{--   toont de woord "Uurtarief" en de Uurtarief van de ingelogde gebruiker in de invoervak om het aan te passen --}}
                                <div class="row justify-content-center">
                                    <div class="col-sm-2">
                                        <strong>Uurtarief:</strong>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>
                                            <input type="text" name="bedrag" value=" {{ $tarief->bedrag }}"  class="form-control" placeholder="bedrag">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </br>
                        </br>

                            {{--knop dat de nieuwe ingevoerde gegevens opslaat--}}
                            <div class="row justify-content-center">
                                <div class="col-sm-1.5">
                                    <button type="submit" class="createbutton createbuttonSupportedContent">Aanpassen</button>
                                </div>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </section>
@endsection
