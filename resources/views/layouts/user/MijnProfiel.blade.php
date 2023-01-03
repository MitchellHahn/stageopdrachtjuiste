@extends('layouts.app')

@section('content')

    <section class="profilesection">

    <div class="container-xxl height100 no-padding">

    <?php //pagina van ZZPer module waar hij/zij uren en toeslag kunnen invoeren en facturen aanmaken?>
        <?php // uren en toeslag toevoegen?>

        {{--    <div class="row">--}}
        {{--        <div class="col-lg-12 margin-tb">--}}
        {{--            <div class="pull-left">--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--    </div>--}}

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="container-xxl height100 justify-content-lg-start" style="background-color:saddlebrown;">
            <div class="row no-margin height100" style="background-color:green;">

                <div class="col-lg-3 profilesectionleft" >

{{--boven ruimte--}}
    <div class="row justify-content-center height10">
    </div>

<br>
    <br>
    <div class="row justify-content-center">
                       <h3 class="profiletitle" >Mijn gegevens</h3>
    </div>
    </br>
</br>

<br>
           <div class="row justify-content-center ">

                    <img src="{{ url('uploads/logos/'.$user->logo) }}" width="190" height="190" class="logo " />


           </div>
</br>
{{--     <br>--}}
{{--            <div class="row justify-content-center height5">--}}
{{--                <div class="col-7 col-sm-4 col-md-3 col-lg-8 col-xl-6 collumntextSupportedContent">--}}
{{--                    <b>Voornaam:</b> {{ $user->name }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{----}}
{{----}}
{{--            <div class="row justify-content-center height5">--}}
{{--                <div class="col-7 col-sm-4 col-md-3 col-lg-8 col-xl-6 collumntextSupportedContent">--}}
{{--                    <b>Tussenvoegsel:</b> {{ $user->tussenvoegsel }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{----}}
{{--            <div class="row justify-content-center height5">--}}
{{--                <div class="col-7 col-sm-4 col-md-3 col-lg-8 col-xl-6 collumntextSupportedContent">--}}
{{--                    <b>Achternaam:</b> {{ $user->achternaam }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--    </br>--}}

            <br>
            <br>

<div class="row justify-content-center height14">

    <form action="{{ route('BProfiel.destroy',$user->id) }}" method="POST">

                    <a class="createbutton createbuttonSupportedContent" href="{{ route('BProfiel.edit',$user->id) }}">Aanpassen</a>

                    @csrf
                    @method('DELETE')
                    <br>
                    <a class="createbutton createbuttontarief createbuttonSupportedContent" href="{{ route('BProfieltarief.create') }}">Uurtarief wijzigen</a>
                    <br>

                </form>

</div>
                    <div class="row justify-content-center">
                        @auth
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <input type="submit" class="logoutbtn createbutton createbuttontarief createbuttonSupportedContent" style="background-color:  #C3C2C2;" value="Uitloggen" />

                            </form>
                        @endauth
                    </div>




            </br>
            </br>
        </div>

{{--            ///////////////////////////////////////////////////////////////////////////////////--}}

            <div class="col-lg-9 section height110" style="align-self:flex-end;">
                <div class="row justify-content-center height100">
            <div class="col-sm-10 sectioninner height85" style="align-self:flex-end;">

            {{--top spacing van text--}}


                <div class="row justify-content-center">
                    <div class="col-11 col-sm-9 collumntextSupportedContent">
                <table class="table ">
                    <tr>
                        <th>Naam:</th>
                        <td>{{$user->name }}</td>
                    </tr>
                    <tr>
                        <th>Tussenvoegesel en achternaam:</th>
                        <td>{{ $user->tussenvoegsel }} {{ $user->achternaam }}</td>
                    </tr>
                    <tr>
                        <th>Straat:</th>
                        <td>{{ $user->straat }}</td>

                    </tr>
                    <tr>
                        <th>Huisnummer en
                            Toevoeging:</th>
                        <td>{{ $user->huisnummer }}
                            {{ $user->toevoeging }}</td>
                    </tr>
                    <tr>
                        <th>Postcode en
                            Stad:</th>
                        <td>{{ $user->postcode }}
                            {{ $user->stad }}</td>
                    </tr>
                    <tr>
                        <th>Land:</th>
                        <td>{{ $user->land }}</td>
                    </tr>
                    <tr>
                        <th>Uurtarief:</th>
                        <td>€{{ $tarief?->bedrag }}</td>
                    </tr>
                    <tr>
                        <th>E-mail:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Telefoonnummer:</th>
                        <td>{{ $user->telefoonnumer }}</td>
                    </tr>
                    <tr>
                        <th>Kvknummer:</th>
                        <td>{{ $user->kvknummer }}</td>
                    </tr>
                    <tr>
                        <th>BTW-nummer:</th>
                        <td>{{ $user->btwnummer }}</td>
                    </tr>
                    <tr>
                        <th>Iban-nummer:</th>
                        <td>{{ $user->ibannummer }}</td>
                    </tr>
                    <tr>
                        <th>Bedrijfsnaam:</th>
                        <td>{{ $user->bedrijfsnaam }}</td>
                    </tr>


                </table>
                    </div>
                {{--    {!! $tijden ->links() !!}--}}
{{--            </div>--}}
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


