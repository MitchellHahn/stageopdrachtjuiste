@extends('layouts.app')



@section('content')

    {{-- pagin voor het tonen van de bedrijf (klant) (zzper module)--}}

<section class="section">

    <div class="container-xl height100 containerSupportedContent">
        <div class="row">
            <div class="col-lg">
                <div class="titlebox titleboxSupportedContent">
                    {{-- Titel en beshcrijving van de pagina --}}
                    <h2 class="title titleSupportedContent">Uren</h2>
                    <h class="info infoSupportedContent">Geregistreerde toelsag voor doorgegeven tijd.</h>

                </div>
            </div>
        </div>

        </br>
        </br>
        </br>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="float-right">
                    {{-- Knop om terug te gaan naar uren overzicht pagina --}}
                    <a class="createbutton createbuttonSupportedContent" href="{{ route('UToevoegen.overzicht_gewerkte_dagen') }}">Terug</a>
                </div>
            </div>
        </div>

    <div class="container-lg height70">
        <div class="row height100 justify-content-center">
            <div class="col-md-12 height100 sectioninner" style="align-self:flex-end;">


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


        <div class="row justify-content-center">
            <div class="col-sm-5">
                @foreach ($toeslagen as $toeslag)

                    {{--   toont de woord "Begintijd" en de Begintijd van de gewerkte dag  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Begintijd:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="toeslagbegintijd" value="{{ date('H:i', strtotime($toeslag->toeslagbegintijd))  }}" class="form-control" placeholder="toeslagbegintijd">
                        </label>
                    </div>
                </div>

                    {{--   toont de woord "Eindtijd" en de Eindtijd van de gewerkte dag  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Eindtijd:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="toeslageindtijd" value="{{  date('H:i', strtotime($toeslag->toeslageindtijd)) }}" class="form-control" placeholder="toeslageindtijd">
                        </label>
                    </div>
                </div>

                    {{--   toont de woord "Toeslagsoort" en de Toeslagsoort van de gewerkte dag  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Toeslagsoort:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="toeslagsoort" value="{{ $toeslag->toeslagsoort  }}" class="form-control" placeholder="toeslagsoort">
                        </label>
                    </div>
                </div>

                    {{--   toont de woord "Percentage" en de Percentage van de gewerkte dag  --}}
                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Percentage:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="number" name="toeslagpercentage" value="{{ $toeslag->toeslagpercentage }}" class="form-control" placeholder="toeslagpercentage">
                        </label>
                    </div>
                </div>

                @endforeach

            </div>

        </div>

</div>
</div>
</div>
</div>
{{--</div>--}}
    </section>


@endsection


