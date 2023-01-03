@extends('layouts.app')

@section('content')
    <section class="section">

        <div class="container-md height100 containerSupportedContent">
        <div class="row">
            <div class="col-md">
                <div class="titlebox titleboxSupportedContent">

                    <h3 class="title titleSupportedContent">Tarief wijzigen</h3>
                    <h class="info infoSupportedContent">Nieuwe tarief registreren</h>
                </div>
            </div>
        </div>

        </br>
        </br>
        </br>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="float-right">
                    <a class="createbutton createbuttonSupportedContent" href="{{ route('BProfiel.index') }}">Terug</a>
                </div>
            </div>
        </div>
        {{--    </div>--}}

        <div class="container-md  " >
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

                        <form action="{{ route('BProfieltarief.store') }}" method="POST">
                        @csrf
{{--                        @method('PATCH')--}}

                        {{--tabel tijd--}}


                            <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <div class="row justify-content-center">
                                    <div class="col-sm-2">
                                        <strong>Uurtarief:</strong>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>
                                            <input type="text" name="bedrag" value=" {{ $tarief?->bedrag }}"  class="form-control" placeholder="bedrag">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>



                        </br>
                        </br>

                        {{--knop voor aanpassen--}}
                            <div class="row justify-content-center">
                                <div class="col-sm-1.5">
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
