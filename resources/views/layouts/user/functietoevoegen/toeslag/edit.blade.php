@extends('layouts.app')

@section('content')
<section class="section">

    <div class="container-md height100 containerSupportedContent">
        <div class="row">
            <div class="col-md">
                <div class="titlebox titleboxSupportedContent">

                <h2 class="title titleSupportedContent">Toeslagen wijzigen</h2>
                <h class="info infoSupportedContent">Geselecteerde toeslag aanpassen.</h>

                </div>
            </div>
        </div>

        </br>
        </br>
        </br>

        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="float-right">
                <a class="createbutton createbuttonSupportedContent" href="{{ route('UToevoegenToeslag.index') }}">Terug</a>
                </div>
            </div>
        </div>

    <div class="container-md height73" style="background-color:;align-self:flex-end">
        <div class="row height100 justify-content-center">
            <div class="col-sm-10 height100 sectioninner">

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

    <form action="{{ route('UToevoegenToeslag.update',$toeslag->id) }}" method="POST">
        @csrf
        @method('PATCH')

{{--tabel tijd--}}
{{--        <div class="row justify-content-center" >--}}
{{--            <div class="col-sm-9">--}}
{{--                <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent" >--}}
{{--                    <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent" >--}}
{{--                    <strong class=" max375pxcollumntextSupportedContent collumntextSupportedContent">Datum:</strong>--}}
{{--                </div>--}}
{{--                <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent">--}}
{{--                    <label>--}}
{{--                        <input type="date" name="datum" value="{{ $toeslag->datum }}" class="form-control max375pxcollumntextSupportedContent" placeholder="Datum">--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        </br>

        <div class="row justify-content-center" >
            <div class="col-sm-9">
                <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent" >
                    <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent" >
                    <strong class=" max375pxcollumntextSupportedContent collumntextSupportedContent">Begintijd:</strong>
            </div>
            <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent">
                    <label>
                        <input type="time" name="toeslagbegintijd" value="{{ $toeslag->toeslagbegintijd }}" class="form-control max375pxcollumntextSupportedContent" placeholder="Toeslag begintijd">
                    </label>
                    </div>
                </div>
            </div>
        </div>

        </br>

        <div class="row justify-content-center" >
            <div class="col-sm-9">
                <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent" >
                    <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent" >
                        <strong class=" max375pxcollumntextSupportedContent collumntextSupportedContent">Eindtijd:</strong>
            </div>
                <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent">
                <label>
                        <input type="time" name="toeslageindtijd" value="{{ $toeslag->toeslageindtijd }}" class="form-control max375pxcollumntextSupportedContent" placeholder="Toeslag eindtijd">
                    </label>
                    </div>
                </div>
            </div>
        </div>
        </br>

        <div class="row justify-content-center" >
            <div class="col-sm-9">
                <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent" >
                    <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent" >
                        <strong class=" max375pxcollumntextSupportedContent collumntextSupportedContent">Naam:</strong>
            </div>
            <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent">
                <label>
                        <input type="text" name="toeslagsoort" value="{{ $toeslag->toeslagsoort }}" class="form-control max375pxcollumntextSupportedContent" placeholder="Toeslag soort">
                    </label>
                   </div>
                </div>
            </div>
        </div>

        </br>


        <div class="row justify-content-center" >
            <div class="col-sm-9">
                <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent" >
                    <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent" >
                        <strong class=" max375pxcollumntextSupportedContent collumntextSupportedContent">Percentage:</strong>
            </div>
            <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent">
                <label>
                        <input type="number" name="toeslagpercentage" value="{{ $toeslag->toeslagpercentage }}" class="form-control max375pxcollumntextSupportedContent" placeholder="Toeslag percentage">
                    </label>
                    </div>
                </div>
            </div>
        </div>

        </br>
        </br>

{{--knop voor aanpassen--}}
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
    </div>

</section>
@endsection
