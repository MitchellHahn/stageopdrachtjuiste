@extends('layouts.app')

@section('content')
    <section class="section">

        <div class="container-md height100 containerSupportedContent">
            <div class="row">
                <div class="col-md">
                    <div class="titlebox titleboxSupportedContent">
                        <h2 class="title titleSupportedContent">Toeslag registreren</h2>
                        <h class="info infoSupportedContent">Hier registreer de toeslagen.</h>

                    </div>
                </div>
            </div>

            </br>
            </br>
            </br>

            <div class="row justify-content-center">
                <div class="col-sm-10">
                    <div class="float-right">
                        <a class="createbutton createbuttonSupportedContent" href="{{ route('Toeslagen.index') }}">Terug</a>
                    </div>
                </div>
            </div>
            {{-- </div>--}}

            <div class="container-md height73 " style="background-color:;align-self:flex-end">
                <div class="row height100 justify-content-center">

                    <div class="col-sm-10 height100 sectioninner ">

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

                        <form action="{{ route('Toeslagen.store',$user->id) }}" method="POST">
                            @csrf


                            {{--        <div class="row justify-content-center" >--}}
                            {{--            <div class="col-sm-9">--}}
                            {{--                <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent" >--}}
                            {{--                    <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent" >--}}
                            {{--                        <strong class=" max375pxcollumntextSupportedContent collumntextSupportedContent">Datum:</strong>--}}
                            {{--                    </div>--}}
                            {{--                    <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent">--}}
                            {{--                        <label>--}}
                            {{--                            <input type="date" name="datum" class="form-control max375pxcollumntextSupportedContent" placeholder="datum">--}}
                            {{--                        </label>--}}
                            {{--                    </div>--}}
                            {{--                </div>--}}
                            {{--            </div>--}}
                            {{--        </div>--}}


                            </br>

                            <div class="row justify-content-center" >
                                <div class="col-sm-9" >
                                    <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent" >
                                        <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent" >
                                            <strong class=" max375pxcollumntextSupportedContent collumntextSupportedContent">Begintijd:</strong>
                                        </div>
                                        <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent" >
                                            <label>
                                                <input type="time" name="toeslagbegintijd" class="form-control max375pxcollumntextSupportedContent" placeholder="toeslagbegintijd">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </br>

                            <div class="row justify-content-center" >
                                <div class="col-sm-9 ">
                                    <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent" >
                                        <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent" >
                                            <strong class=" max375pxcollumntextSupportedContent collumntextSupportedContent">Eindtijd:</strong>
                                        </div>
                                        <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent" >
                                            <label>
                                                <input type="time" name="toeslageindtijd" class="form-control max375pxcollumntextSupportedContent" placeholder="toeslageindtijd">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

{{--                            </br>--}}

{{--                            <div class="row justify-content-center" >--}}
{{--                                <div class="col-sm-9" >--}}
{{--                                    <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent">--}}
{{--                                        <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent">--}}
{{--                                            <strong class="max375pxcollumntextSupportedContent collumntextSupportedContent">Naam:</strong>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent" >--}}
{{--                                            <label>--}}
{{--                                                <input type="text" name="toeslagsoort" class="form-control max375pxcollumntextSupportedContent" placeholder="naam">--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            </br>

                            <div class="row justify-content-center">
                                <div class="col-sm-9">
                                    <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent" >
                                        <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent" >
                                            <strong class="max375pxcollumntextSupportedContent collumntextSupportedContent" >Percentage:</strong>
                                        </div>
                                        <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent" >
                                            <label>
                                                <input type="number" name="toeslagpercentage" class="form-control max375pxcollumntextSupportedContent " placeholder="%">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </br>

                            <div class="row justify-content-center">
                                <div class="col-sm-9">
                                    <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent" >
                                        <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent" >
                                            <strong class="max375pxcollumntextSupportedContent collumntextSupportedContent" >Soort:</strong>
                                        </div>
                                        <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent" >
                                            <label>
                                                <select name="soort" class="form-control">
                                                    <option value="1">Ochtend (Week)</option>
                                                    <option value="2">Avond (Week)</option>
                                                    <option value="3">Nacht (Week)</option>
                                                    <option value="4">Ochtend (Weekend)</option>
                                                    <option value="5">Avond (Weekend)</option>
                                                    <option value="6">Nacht (Weekend)</option>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </br>

                            {{--knop voor aanpassen--}}
                            <div class="row justify-content-center rowbuttonSupportedContent">
                                <div class="col-sm-3 collumnbuttonSupportedContent">
                                    <button type="submit" class="createbutton createbuttonSupportedContent">Opslaan</button>
                                </div>
                            </div>
                            {{--        </div>--}}

                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
