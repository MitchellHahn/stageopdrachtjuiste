@extends('layouts.app')



@section('content')
{{--  pagina waarin de CC: e-mailadress (e-mail van Brouwers contactpersoon) wordt   --}}
    <section class="section">

        <div class="container-md height100 containerSupportedContent">
            <div class="row">
                <div class="col-md">
                    <div class="titlebox titleboxSupportedContent">
                        {{-- Titel en beshcrijving van de pagina --}}
                        <h3 class="title titleSupportedContent">CC: aanpassen</h3>
                        <h class="info infoSupportedContent">E-mail die in de CC: wordt meegestuurd.</h>

                    </div>

        </div>
    </div>
            </br>
            </br>
            </br>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="float-right">
                        {{-- Knop om terug te geaan de pagina waarin een factuur wordt aangemaakt--}}
                        <a class="createbutton createbuttonSupportedContent" href="{{ route ('Factuurmaand.uren_van_maand_tonen', $bedrijfId) }}">Terug</a>
                    </div>
                </div>
            </div>


            <div class="container-md">
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

{{--           als de gegeven moeten worden gewijzigt voert het dit uit             --}}
    @isset(\Auth::user()->brouwerscontact)
    <form action="{{ route('Factuuremail.CC_wijziging_opslaan',\Auth::user()->brouwerscontact->id) }}" method="POST">
        @method('PATCH')
    @else
            {{--           als de gegevens moeten worden aangemaakt voert het dit uit             --}}
    <form action="{{ route('Factuuremail.CC_opslaan') }}" method="POST">
    @endisset
        @csrf
        <input type="hidden" name="bedrijf" value="{{ $bedrijfId }}" />

        {{-- tabel tijd--}}
        <div class="row justify-content-center">
            <div class="col-sm-12">
                {{--   toont de woord "E-mail" en de invoervak van de E-mail van de Brouwers contact persoon  --}}
                <div class="row justify-content-center">
                    <div class="col-3 col-sm-2">
                        <strong class="tablerowcellSupportedContent">E-mail:</strong>
                    </div>
                    <div class="col-9 col-sm-4" >
                        <label>
                            <input type="text" name="email" value="{{ \Auth::user()->brouwerscontact->email }}" class="form-control tablerowcellSupportedContent" placeholder="Email">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        </br>
        </br>

        {{--knop voor opslaan van de ingevoerd e-mail van de brouwers contactpersoon--}}
        <div class="row justify-content-center">
            <div class="col-sm-1.5">
                <button type="submit" class="createbutton createbuttonSupportedContent">Opslaan</button>
            </div>
        </div>

    </form>
  </div>
  </div>
  </div>
  </div>
</section>
@endsection
