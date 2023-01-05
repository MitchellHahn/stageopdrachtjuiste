@extends('layouts.app')

{{--@extends('layouts.user.functietoevoegen.toeslag.layout')--}}


@section('content')

    <?php //pagina van ZZPer module waar hij/zij uren en toeslag kunnen invoeren en facturen aanmaken?>
    <?php // uren en toeslag toevoegen?>

{{--    <style>--}}
{{--        body {--}}
{{--            height: 100%;--}}
{{--            margin: 0;--}}
{{--        }--}}
{{--    </style>--}}

{{--    <meta charset="utf-8" />--}}
{{--    <style>--}}
{{--        .overlay {--}}
{{--            position: fixed;--}}
{{--            width: 100%;--}}
{{--            height: 100%;--}}
{{--            left: 0;--}}
{{--            top: 0;--}}
{{--            background: rgba(51,51,51,0.7);--}}
{{--            z-index: 10;--}}
{{--        }--}}
{{--    </style>--}}
<section class="section">
{{--    <div class="section" >--}}

    <div class="container-xl height100 containerSupportedContent">
        <div class="row">
            <div class="col-lg">
                <div class="titlebox titleboxSupportedContent">

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
                    <a class="createbutton createbuttonSupportedContent" href="{{ route('UToevoegen.index') }}">Terug</a>
                </div>
            </div>
        </div>
{{--    </div>--}}

    <div class="container-lg height70">
        <div class="row height100 justify-content-center">
            <div class="col-md-12 height100 sectioninner" style="align-self:flex-end;">


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

{{--    <div class="container-lg">--}}

        <div class="row justify-content-center">
            <div class="col-sm-5">
{{--                <div class="row justify-content-center" >--}}
{{--                    <div class="col-8 col-sm-5">--}}
{{--                        <strong>Datum:</strong>--}}
{{--                    </div>--}}
{{--                    <div class="col-8 col-sm-7" >--}}
{{--                        <label>--}}
{{--                            <input type="text" name="datum" value="{{  $toeslag->datum }}" class="form-control" placeholder="datum">--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}

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

                {{--            </div>--}}

                {{--            <div class="col-sm-5">--}}
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

                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Uurtarief:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="bedrag" value="{{ $toeslag->tarief->bedrag }}" class="form-control" placeholder="bedrag">
                        </label>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong></strong>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Uitbetaling:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input type="text" name="bedrag" value="€{{ $tijd->uitbetaling }}" class="form-control" placeholder="bedrag">
                        </label>
                    </div>
                </div>

                {{--            </div>--}}
            </div>

        </div>

</div>
</div>
</div>
</div>
{{--</div>--}}
    </section>


@endsection


