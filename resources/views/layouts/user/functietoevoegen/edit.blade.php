@extends('layouts.app')



@section('content')

<section class="section">

    <div class="container-md height100">
        <div class="row">
            <div class="col-md" >
                <div class="titlebox titleboxSupportedContent">

                    <h2 class="title titleSupportedContent">Uren wijzigen</h2>
                    <h class="info infoSupportedContent">Geselecteerde tijd wijzigen.</h>

                </div>
            </div>
        </div>

{{--    </div>--}}

    </br>
    </br>
    </br>

{{--    <div class="container-md" style="background-color:black;">--}}

    <div class="row justify-content-center">
        <div class="col-sm-9">
            <div class="float-right">
                <a class="createbutton createbuttonSupportedContent" href="{{ route('UToevoegen.index') }}">Terug</a>
            </div>
        </div>
    </div>

{{--                <a class="btn btn-primary" href="{{ route('UToevoegen.index') }}"> Back</a>--}}

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

    <form action="{{ route('UToevoegen.update',$tijd->id) }}" method="POST">
        @csrf
        @method('PATCH')

        {{-- tabel tijd--}}

        <div class="row justify-content-center" >
            <div class="col-sm-9">
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

            {{--knop voor aanpassen--}}
        <div class="row justify-content-center rowbuttonSupportedContent">
            <div class="col-sm-3 collumnbuttonSupportedContent">
                <button type="submit" class="createbutton createbuttonSupportedContent">Aanpassen</button>
            </div>
        </div>
{{--        </div>--}}

    </form>
</div>
</div>
</div>
    </div>

</section>

@endsection
