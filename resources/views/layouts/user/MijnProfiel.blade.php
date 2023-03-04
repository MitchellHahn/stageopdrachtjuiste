@extends('layouts.app')

@section('content')

    <section class="profilesection">

    <div class="container-xxl height100 no-padding">

        {{--            pagina van zzper module waar de gebruiker zijn profiel gegevens kan bekijken --}}

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="container-xxl height100 justify-content-lg-start">
            <div class="row no-margin height100" >

                <div class="col-lg-3 profilesectionleft" >

{{--boven ruimte--}}
    <div class="row justify-content-center height10">
    </div>

        <br>
            <br>
                    {{-- titel van de pagina--}}
                    <div class="row justify-content-center">
                  <h3 class="profiletitle" >Mijn gegevens</h3>
                </div>
            </br>
        </br>

        <br>
            <div class="row justify-content-center ">
                {{--logo of foto van de ingelogde gebruiker tonen--}}
                <img src="{{ url('uploads/logos/'.$user->logo) }}" width="190" height="190" class="logo " />
            </div>
        </br>
            <br>
            <br>

<div class="row justify-content-center height14">

    <form action="{{ route('BProfiel.verwijderen',$user->id) }}" method="POST">

                    {{--   knop om de profiel gegevens van de ingelogde gebruiker te wijzigen     --}}
                    <a class="createbutton createbuttonSupportedContent" href="{{ route('BProfiel.wijzigen',$user->id) }}">Aanpassen</a>

                    @csrf
                <br>
                    {{--toonte de venseter waarin de uurtarief van de ingelogde gebruiker gewijzgd kan worden--}}
                    <a class="createbutton createbuttontarief createbuttonSupportedContent" href="{{ route('BProfieltarief.aanmaken') }}">Uurtarief wijzigen</a>
                    <br>

                </form>

</div>
                    <div class="row justify-content-center">
                        @auth
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                {{--knop en functie voor het uitloggen --}}

                                <input type="submit" class="logoutbtn createbutton createbuttontarief createbuttonSupportedContent" style="background-color:  #C3C2C2;" value="Uitloggen" />

                            </form>
                        @endauth
                    </div>

            </br>
            </br>
        </div>


            <div class="col-lg-9 section height110" style="align-self:flex-end;">
                <div class="row justify-content-center height100">
            <div class="col-sm-10 sectioninner height85" style="align-self:flex-end;">

            {{--top spacing van text--}}

                {{--   Toont het woord "voornaam" en de naam de ingelogde gebruiker --}}
                <div class="row justify-content-center">
                    <div class="col-11 col-sm-9 collumntextSupportedContent">
                <table class="table ">
                    <tr>
                        <th>Naam:</th>
                        <td>{{$user->name }}</td>
                    </tr>

                    {{--   Toont het woord "Tussenvoegesel en achternaam" en de Tussenvoegesel en achternaam van de ingelogde gebruiker --}}
                    <tr>
                        <th>Tussenvoegesel en achternaam:</th>
                        <td>{{ $user->tussenvoegsel }} {{ $user->achternaam }}</td>
                    </tr>

                    {{--   Toont het woord "Straat" en de Straat van de ingelogde gebruiker --}}

                    <tr>
                        <th>Straat:</th>
                        <td>{{ $user->straat }}</td>
                    </tr>

                    {{--   Toont het woord "Huisnummer en Toevoeging" en de Huisnummer en Toevoeging van de ingelogde gebruiker --}}
                    <tr>
                        <th>Huisnummer en
                            Toevoeging:</th>
                        <td>{{ $user->huisnummer }}
                            {{ $user->toevoeging }}</td>
                    </tr>

                    {{--   Toont het woord "Postcode en Stad" en de Postcode en Stad van de ingelogde gebruiker --}}
                    <tr>
                        <th>Postcode en
                            Stad:</th>
                        <td>{{ $user->postcode }}
                            {{ $user->stad }}</td>
                    </tr>

                    {{--   Toont het woord "Land" en de Land van de ingelogde gebruiker --}}
                    <tr>
                        <th>Land:</th>
                        <td>{{ $user->land }}</td>
                    </tr>

                    {{--   Toont het woord "Uurtarief" en de Uurtarief van de ingelogde gebruiker --}}
                    <tr>
                        <th>Uurtarief:</th>
                        <td>€{{ $tarief->bedrag }}</td>
                    </tr>

                    {{--   Toont het woord "E-mail" en de E-mail van de ingelogde gebruiker --}}
                    <tr>
                        <th>E-mail:</th>
                        <td>{{ $user->email }}</td>
                    </tr>

                    {{--   Toont het woord "Telefoonnummer" en de Telefoonnummer van de ingelogde gebruiker --}}
                    <tr>
                        <th>Telefoonnummer:</th>
                        <td>{{ $user->telefoonnumer }}</td>
                    </tr>

                    {{--   Toont het woord "Kvknummer" en de Kvknummer van de ingelogde gebruiker --}}
                    <tr>
                        <th>Kvknummer:</th>
                        <td>{{ $user->kvknummer }}</td>
                    </tr>

                    {{--   Toont het woord "BTW-nummer" en de BTW-nummer van de ingelogde gebruiker --}}
                    <tr>
                        <th>BTW-nummer:</th>
                        <td>{{ $user->btwnummer }}</td>
                    </tr>

                    {{--   Toont het woord "Iban-nummer" en de Iban-nummer van de ingelogde gebruiker --}}
                    <tr>
                        <th>Iban-nummer:</th>
                        <td>{{ $user->ibannummer }}</td>
                    </tr>

                    {{--   Toont het woord "Bedrijfsnaam" en de Bedrijfsnaam van de ingelogde gebruiker --}}
                    <tr>
                        <th>Bedrijfsnaam:</th>
                        <td>{{ $user->bedrijfsnaam }}</td>
                    </tr>


                </table>
                    </div>

            </div>
        </div>
        </div>
        </div>
        </div>
    </div>
    </div>
    </div>

    </section>
@endsection


