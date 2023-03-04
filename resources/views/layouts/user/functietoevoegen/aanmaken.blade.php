@extends('layouts.app')

@section('content')
<section class="section">
    {{-- pagina voor het registreren van de gewerkte dagen (zzper module)--}}
   <div class="container-md height100 containerSupportedContent">
    <div class="row">
        <div class="col-md">
            <div class="titlebox titleboxSupportedContent">
                {{-- Titel en beshcrijving van de pagina --}}
                <h2 class="title titleSupportedContent">Uren toevoegen</h2>
                <h class="info infoSupportedContent">Hier kan je een tijd registreren.</h>
            </div>
        </div>
    </div>

       </br>
       </br>
       </br>

       <div class="row justify-content-center">
           <div class="col-sm-9">
               <div class="float-right">
                   {{-- Knop om terug te geaan de uren overzicht pagina --}}
                   <a class="createbutton createbuttonSupportedContent" href="{{ route('UToevoegen.overzicht_gewerkte_dagen') }}">Terug</a>
            </div>
        </div>
    </div>

    <div class="container-md height73 " style="background-color:;align-self:flex-end">
        <div class="row height100 justify-content-center">

            <div class="col-sm-9 height100 sectioninner ">

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Woops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        {{-- slaat de dag met de ingevoerd gegevens op --}}
        <form action="{{ route('UToevoegen.opslaan') }}" method="POST">
        @csrf

        <div class="row justify-content-center" >
            <div class="col-sm-9 ">
                {{--   toont de woord "Datum" en de invoervak van de Datum van de dag (tijd)  --}}
                <div class="row justify-content-center rowSupportedContent">
                    <div class="col-sm-3 collumnSupportedContent">
                        <strong class="collumntextSupportedContent">Datum:</strong>
                    </div>
                    <div class="col-sm-4 collumnSupportedContent">
                        <label>
                            <input type="date" name="datum" class="form-control collumntextSupportedContent" placeholder="datum">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        </br>

        <div class="row justify-content-center" >
            <div class="col-sm-9" >
                {{--   toont de woord "Begintijd" en de invoervak van de Begintijd van de dag (tijd)  --}}
                <div class="row justify-content-center rowSupportedContent" >
                    <div class="col-sm-3 collumnSupportedContent" >
                        <strong class="collumntextSupportedContent">Begintijd:</strong>
                    </div>
                    <div class="col-sm-4 collumnSupportedContent" >
                        <label>
                            <input type="time" name="begintijd" class="form-control collumntextSupportedContent" placeholder="begintijd">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        </br>

        <div class="row justify-content-center" >
            <div class="col-sm-9" >
                {{--   toont de woord "Eindtijd" en de invoervak van de Eindtijd van de dag (tijd)  --}}
                <div class="row justify-content-center rowSupportedContent" >
                    <div class="col-sm-3 collumnSupportedContent" >
                        <strong class="collumntextSupportedContent">Eindtijd:</strong>
                    </div>
                    <div class="col-sm-4 collumnSupportedContent" >
                        <label>
                            <input type="time" name="eindtijd" class="form-control collumntextSupportedContent" placeholder="eindtijd">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        </br>

        <div class="row justify-content-center" >
            <div class="col-sm-9" >
                {{--   toont de woord "Klant" en de invoervak van de Klant van de dag (tijd)  --}}
                <div class="row justify-content-center rowSupportedContent">
                    <div class="col-sm-3 collumnSupportedContent">
                        <strong class="collumntextSupportedContent">Klant:</strong>
                    </div>
                    <div class="col-sm-4 collumnSupportedContent">
                        <label for="">
                            <select class="collumntextSupportedContent" name="bedrijf_id">
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

            {{--knop voor opslaan van de ingevoerd gegevens van de gewerkte dag--}}
        <div class="row justify-content-center rowbuttonSupportedContent" >
            <div class="col-sm-3 collumnbuttonSupportedContent">
                <button type="submit" class="createbutton createbuttonSupportedContent">Toevoegen</button>
            </div>
        </div>

    </form>
   </div>
    </div>
    </div>
    </div>
    </section>

@endsection
