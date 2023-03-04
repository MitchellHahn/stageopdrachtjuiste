@extends('layouts.app')

@section('content')
    <section class="section">

        <div class="container-md height100 containerSupportedContent">
            <div class="row">
                <div class="col-md">
                    <div class="titlebox titleboxSupportedContent">
                        {{-- Titel en beshcrijving van de pagina --}}
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
                        {{-- Knop om terug te geaan de toeslagen pagina --}}
                        <a class="createbutton createbuttonSupportedContent" href="{{ route('Toeslagen.zppers') }}">Terug</a>
                    </div>
                </div>
            </div>

            <div class="container-md height73 " style="background-color:;align-self:flex-end">
                <div class="row height100 justify-content-center">

                    <div class="col-sm-10 height100 sectioninner ">

                        {{-- toont melding als de iets niet goed is opgeslagen--}}
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
                        {{-- slaat de gebruiker met de ingevoerd gegevens op --}}
                        <form action="{{ route('Toeslagen.gebruikerstoeslagopslaan',$user->id) }}" method="POST">
                            @csrf

                            </br>
                            {{--   toont de woord "Begintijd" en de invoervak van de begintijd van de toeslag  --}}
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

                            {{--   toont de woord "Eindtijd" en de invoervak van de Eindtijd van de toeslag  --}}
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

                            </br>

                            {{--   toont de woord "Percentage" en de invoervak van de Percentage van de toeslag  --}}
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

                            {{--   toont de woord "Soort" en dropdownmenu van de toeslag  --}}
                            <div class="row justify-content-center">
                                <div class="col-sm-9">
                                    <div class="row justify-content-center max375pxrowSupportedContent rowSupportedContent" >
                                        <div class="col-sm-3 max375pxcollumnSupportedContent collumnSupportedContent" >
                                            <strong class="max375pxcollumntextSupportedContent collumntextSupportedContent" >Soort:</strong>
                                        </div>
                                        <div class="col-sm-4 max375pxcollumnSupportedContent collumnSupportedContent" >
                                            {{--toont dropsdown menu voor ochtend, avond en nacht toeslagen van week en weekend dagen--}}
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

                            <div class="row justify-content-center rowbuttonSupportedContent " >
                                <div class="col-sm-3 collumnbuttonSupportedContent">
                                    {{--knop voor opslaan van de ingevoerd toeslag gegevens--}}
                                    <button type="submit" class="createbutton createbuttonSupportedContent">Opslaan</button>
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
