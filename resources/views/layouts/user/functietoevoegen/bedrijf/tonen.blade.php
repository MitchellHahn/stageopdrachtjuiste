@extends('layouts.app')


@section('content')

    {{-- pagin voor het tonen van de bedrijf (klant) (zzper module)--}}

<section class="section">
    <div class="container-lg height100 containerSupportedContent">
        <div class="row">
            <div class="col-lg">
                <div class="titlebox titleboxSupportedContent">
                    {{-- Titel en beshcrijving van de pagina --}}
                <h2 class="title titleSupportedContent">Klanten</h2>
                <h class="info infoSupportedContent">Gegevens van de geselecteerde klant.</h>

                </div>
            </div>
        </div>

        </br>
        </br>
        </br>

        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="float-right">
                    {{-- Knop om terug te gaan naar de bedrijven (klanten) overzicht pagina --}}
                    <a class="createbutton createbuttonSupportedContent" href="{{ route('Klanten.overzicht_alle_klanten') }}">Terug</a>
                </div>
            </div>
        </div>

        <div class="container-lg height73"  style="background-color:;align-self:flex-end">
            <div class="row height100 justify-content-center">
                <div class="col-md-11 height100 sectioninner">

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

        <div class="row justify-content-center">
            <div class="col-sm-5">

                {{--   toont de woord "Klantnaam" en de Klantnaam van de bedrijf  --}}
                <div class="row justify-content-center" >
                    <div class="col-8 col-sm-5">
                        <strong>Klantnaam:</strong>
                    </div>
                    <div class="col-8 col-sm-7" >
                        <label>
                            <input type="text" name="bedrijfsnaam" value="{{ $bedrijf->bedrijfsnaam }}" class="form-control" placeholder="bedrijfsnaam">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Contactpersoon" en de Contactpersoon van de bedrijf  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Contactpersoon:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="contactpersoon" value="{{ $bedrijf->contactpersoon }}" class="form-control" placeholder="contactpersoon">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Debnummer" en de Debnummer van de bedrijf  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Debnummer:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="debnummer" value="{{ $bedrijf->debnummer }}" class="form-control" placeholder="Debnummer">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Email" en de Email van de bedrijf  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="email" value="{{ $bedrijf->email }}" class="form-control" placeholder="Email">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Straat" en de Straat van de bedrijf  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Straat:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="straat" value="{{ $bedrijf->straat }}" class="form-control" placeholder="Straat">
                        </label>
                    </div>
                </div>

               {{--   toont de woord "Huisnummer" en de Huisnummer van de bedrijf  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Huisnummer:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="number" name="huisnummer" value="{{ $bedrijf->huisnummer }}" class="form-control" placeholder="Huisnummer">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Toevoeging" en de Toevoeging van de bedrijf  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Toevoeging:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="toevoeging" value="{{ $bedrijf->toevoeging }}" class="form-control" placeholder="Toevoeging">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Postcode" en de Postcode van de bedrijf  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Postcode:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="postcode" value="{{ $bedrijf->postcode }}" class="form-control" placeholder="Postcode">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Stad" en de Stad van de bedrijf  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Stad:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="stad" value="{{ $bedrijf->stad }}" class="form-control" placeholder="Stad">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Land" en de Land van de bedrijf  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Land:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="land" value="{{ $bedrijf->land }}" class="form-control" placeholder="Land">
                        </label>
                    </div>
                </div>
        </div>

</div>
</div>
</div>
</div>
</section>
@endsection


