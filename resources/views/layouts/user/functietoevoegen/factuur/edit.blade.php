@extends('layouts.app')



@section('content')
    <section class="section">

        <div class="container-md height100 containerSupportedContent">
            <div class="row">
                <div class="col-md">
                    <div class="titlebox titleboxSupportedContent">
                        <h3 class="title titleSupportedContent">CC: aanpassen</h3>
                        <h class="info infoSupportedContent">E-mail die in de CC: wordt meegestuurd.</h>

                    </div>
{{--            <div class="pull-right">--}}
{{--                <a class="btn btn-primary" href="{{ route('Factuur.pdf', $bedrijf) }}"> Back</a>--}}
{{--            </div>--}}
        </div>
    </div>
            </br>
            </br>
            </br>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="float-right">
                        <a class="createbutton createbuttonSupportedContent" href="{{ route ('Factuurmaand.select', $bedrijfId) }}">Terug</a>
                    </div>
                </div>
            </div>


            <div class="container-md">
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

    @isset(\Auth::user()->brouwerscontact)
    <form action="{{ route('Factuuremail.update',\Auth::user()->brouwerscontact->id) }}" method="POST">
        @method('PATCH')
    @else
    <form action="{{ route('Factuuremail.store') }}" method="POST">
    @endisset
        @csrf
        <input type="hidden" name="bedrijf" value="{{ $bedrijfId }}" />

        {{-- tabel tijd--}}
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="row justify-content-center">
                    <div class="col-3 col-sm-2">
                        <strong class="tablerowcellSupportedContent">E-mail:</strong>
                    </div>
                    <div class="col-9 col-sm-4" >
                        <label>
                            <input type="text" name="email" value="{{ \Auth::user()->brouwerscontact?->email }}" class="form-control tablerowcellSupportedContent" placeholder="Email">
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
                <button type="submit" class="createbutton createbuttonSupportedContent">Opslaan</button>
            </div>
        </div>

    </form>
  </div>
  </div>
  </div>
  </div>
</section>
@endsection
