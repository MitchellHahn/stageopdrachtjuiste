@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container-lg height100 containerSupportedContent">

    <div class="row">
        <div class="col-lg">
            <div class="titlebox titleboxSupportedContent">
                {{-- Titel en beshcrijving van de pagina --}}
                <h2 class="title titleSupportedContent">Registratie formulier</h2>
                <h class="info infoSupportedContent">Hier registreer je een gebruiker</h>

            </div>
        </div>
    </div>

    </br>
    </br>
    </br>

        <div class="container-lg height80"  style="background-color:;align-self:flex-end">
            <div class="row height100 justify-content-center">

                <div class="col-md-11 height100 sectioninner">

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


    <form action="{{ route('Registratie.gebruiker_registreren') }}" method="POST">
        @csrf

        {{--   toont de woord "Naam" en invoervak naast     --}}
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <div class="row justify-content-center" >
                    <div class="col-8 col-sm-5">
                        <strong>Voornaam:</strong>
                    </div>
                    <div class="col-8 col-sm-7" >
                        <label>
                            <input type="text" name="name" class="form-control" placeholder="Voornaam">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Tussenvoegsel" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Tussenvoegsel:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="tussenvoegsel" class="form-control" placeholder="Tussenvoegsel">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Achternaam" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Achternaam:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="achternaam" class="form-control" placeholder="Achternaam">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Straat" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Straat:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="straat" class="form-control" placeholder="Straat">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Huisnummer" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Huisnummer:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="number" name="huisnummer" class="form-control" placeholder="Huisnummer">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Toevoeging" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Toevoeging:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="toevoeging" class="form-control" placeholder="Toevoeging">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Postcode" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Postcode:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="postcode" class="form-control" placeholder="Postcode">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Postcode" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Stad:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="stad" class="form-control" placeholder="Stad">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Land" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Land:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="land" class="form-control" placeholder="Land">
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-sm-5">
                {{--   toont de woord "Telefoonnummer" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Telefoonnummer:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="telefoonnumer" class="form-control" placeholder="Telefoonnumer">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Kvk-nummer" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Kvk-nummer:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="number" name="kvknummer" class="form-control" placeholder="Kvk-nummer">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "BTW-nummer" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>BTW-nummer:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="btwnummer" class="form-control" placeholder="BTW-nummer">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Iban-nummer" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Iban-nummer:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="ibannummer" class="form-control" placeholder="Iban-nummer">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Bedrijfsnaam" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Bedrijfsnaam:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="bedrijfsnaam" class="form-control" placeholder="Bedrijfsnaam">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "E-mail" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>E-mail:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="email" class="form-control" placeholder="E-mail">
                        </label>
                    </div>
                </div>

                {{--   toont de woord "Soort gebruiker" en invoervak naast     --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Soort gebruiker:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <select name="account_type" class="form-control">
                                {{--toont drown menu voor het kiezen van gebruiker of admin--}}
                                <option value="0">Gebruiker</option>
                                <option value="1">Admin</option>
                            </select>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        </br>
        </br>

        <div class="row justify-content-center">
            <div class="col-sm-1.5">
                    {{--Knop dat de ingevoerde gegevens van de gebruiker opslaat--}}
                    <button type="submit" class="createbutton createbuttonSupportedContent">Registreren</button>
            </div>
        </div>

    </form>
    </div>
    </div>
    </div>
    </div>

</section>

@endsection
