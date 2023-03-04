@extends('layouts.app')



@section('content')

<section class="section">
    {{-- pagina voor het wijzgen van de gegevens van de gebruiker (medewerkers module)--}}

    <div class="container-md height100">
        <div class="row">
            <div class="col-md" >
                <div class="titlebox titleboxSupportedContent">
                    {{-- Titel en beshcrijving van de pagina --}}
                    <h2 class="title titleSupportedContent">Uren wijzigen</h2>
                    <h class="info infoSupportedContent">Geselecteerde tijd wijzigen.</h>

                </div>
            </div>
        </div>

    </br>
    </br>
    </br>


    <div class="row justify-content-center">
        <div class="col-sm-9">
            <div class="float-right">
                {{-- Knop om terug te gaan naar de uren overzicht pagina --}}
                <a class="createbutton createbuttonSupportedContent" href="{{ route('UToevoegen.overzicht_gewerkte_dagen') }}">Terug</a>
            </div>
        </div>
    </div>


    <div class="container-md height73 " style="background-color:;align-self:flex-end">
        <div class="row height100 justify-content-center">

        <div class="col-sm-9 height100 sectioninner">

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

        {{-- voert de functie uit om de gegevens van de bedrijf te wijzigen --}}
        <form action="{{ route('UToevoegen.WijzigingOpslaan',$tijd->id) }}" method="POST">
        @csrf
        @method('PATCH')

        {{-- tabel tijd--}}

        <div class="row justify-content-center" >
            <div class="col-sm-9">
                {{--   toont de woord "Datum" en de Datum van de dag in de invoervak om het aan te passen --}}
                <div class="row justify-content-center rowSupportedContent" >
                    <div class="col-sm-3 collumnSupportedContent" >
                        <strong class="collumntextSupportedContent">Datum:</strong>
                    </div>
                    <div class="col-sm-4 collumnSupportedContent">
                        <label>
                            <input type="date" name="datum" value="{{ $tijd->datum }}" class="form-control collumntextSupportedContent" placeholder="Datum">
                        </label>
                    </div>
                </div>
            </div>
        </div>


        </br>

        <div class="row justify-content-center" >
            <div class="col-sm-9" >
                {{--   toont de woord "Begintijd" en de Begintijd van de dag in de invoervak om het aan te passen --}}
                <div class="row justify-content-center rowSupportedContent" >
                    <div class="col-sm-3 collumnSupportedContent" >
                        <strong class="collumntextSupportedContent">Begintijd:</strong>
                    </div>
                    <div class="col-sm-4 collumnSupportedContent" >
                        <label>
                            <input type="time" name="begintijd" value="{{ $tijd->begintijd }}" class="form-control collumntextSupportedContent" placeholder="Begintijd">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        </br>

        <div class="row justify-content-center" >
            <div class="col-sm-9" >
                {{--   toont de woord "Eindtijd" en de Eindtijd van de dag in de invoervak om het aan te passen --}}
                <div class="row justify-content-center rowSupportedContent" >
                    <div class="col-sm-3 collumnSupportedContent">
                        <strong class="collumntextSupportedContent">Eindtijd:</strong>
                    </div>
                    <div class="col-sm-4 collumnSupportedContent">
                        <label>
                            <input type="time" name="eindtijd" value="{{ $tijd->eindtijd }}" class="form-control collumntextSupportedContent" placeholder="Eindtijd">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        </br>

        <div class="row justify-content-center" >
            <div class="col-sm-9">
                {{--   toont de woord "Klant" en de Klant van de dag in de invoervak om het aan te passen --}}
                <div class="row justify-content-center rowSupportedContent">
                    <div class="col-sm-3 collumnSupportedContent">
                        <strong class="collumntextSupportedContent">Klant:</strong>
                    </div>
                    <div class="col-sm-4 collumnSupportedContent">
                        <label for="">
                            <select name="bedrijf_id" class="collumntextSupportedContent">
                                @foreach($bedrijven as $bedrijf)
                                    <option value="{{$bedrijf->id}}">{{$bedrijf->bedrijfsnaam}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        </br>
        </br>

            {{--knop voor de wijziging van de gegevens van de gewerkte dag, opslaan--}}
        <div class="row justify-content-center rowbuttonSupportedContent">
            <div class="col-sm-3 collumnbuttonSupportedContent">
                <button type="submit" class="createbutton createbuttonSupportedContent">Aanpassen</button>
            </div>
        </div>

    </form>
</div>
</div>
</div>
    </div>

</section>

@endsection
