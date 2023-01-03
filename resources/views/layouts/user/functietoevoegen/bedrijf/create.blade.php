@extends('layouts.app')

@section('content')

<section class="section">
    <div class="container-lg height100 containerSupportedContent">

        <div class="row">
            <div class="col-lg">
                <div class="titlebox titleboxSupportedContent">
                    <h2 class="title titleSupportedContent">Klanten registreren</h2>
                    <p class="info infoSupportedContent">Hier registreer je een klant.</p>

                </div>
            </div>
        </div>

        </br>
        </br>
        </br>

        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="float-right">
                    <a class="createbutton createbuttonSupportedContent" href="{{ route('Klanten.index') }}">Terug</a>
                </div>
            </div>
        </div>
{{--    </div>--}}

    <div class="container-lg height73" style="background-color:;align-self:flex-end">
        <div class="row height100 justify-content-center">

            <div class="col-md-11 height100 sectioninner">

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

    <form action="{{ route('Klanten.store') }}" method="POST">
        @csrf

{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-sm-9" >--}}


<div class="row justify-content-center">
    <div class="col-sm-5">
        <div class="row justify-content-center" >
            <div class="col-8 col-sm-5">
                <strong>Klantnaam:</strong>
            </div>
            <div class="col-8 col-sm-7" >
                <label>
                    <input type="text" name="bedrijfsnaam" class="form-control" placeholder="klant">
                </label>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-8 col-sm-5">
                <strong>Contactpersoon:</strong>
            </div>
            <div class="col-8 col-sm-7">
                <label>
                    <input type="text" name="contactpersoon" class="form-control" placeholder="contactpersoon">
                </label>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-8 col-sm-5">
                <strong>Debnummer:</strong>
            </div>
            <div class="col-8 col-sm-7">
                <label>
                    <input type="number" name="debnummer" class="form-control" placeholder="debnummer">
                </label>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-8 col-sm-5">
                <strong>Email:</strong>
            </div>
            <div class="col-8 col-sm-7">
                <label>
                    <input type="text" name="email" class="form-control" placeholder="email">
                </label>
            </div>
        </div>
    </div>

    <div class="col-sm-5">
         <div class="row justify-content-center">
             <div class="col-8 col-sm-5">
                 <strong>Straat:</strong>
             </div>
             <div class="col-8 col-sm-7">
                 <label>
                     <input type="text" name="straat" class="form-control" placeholder="straat">
                 </label>
             </div>
         </div>

        <div class="row justify-content-center">
            <div class="col-8 col-sm-5">
                 <strong>Huisnummer:</strong>
             </div>
            <div class="col-8 col-sm-7">
                 <label>
                     <input type="number" name="huisnummer" class="form-control" placeholder="huisnummer">
                 </label>
             </div>
         </div>

        <div class="row justify-content-center">
            <div class="col-8 col-sm-5">
                    <strong>Toevoeging:</strong>
                </div>
            <div class="col-8 col-sm-7">
                    <label>
                        <input type="text" name="toevoeging" class="form-control" placeholder="toevoeging">
                    </label>
                </div>
            </div>

        <div class="row justify-content-center">
            <div class="col-8 col-sm-5">
                 <strong>Postcode:</strong>
             </div>
            <div class="col-8 col-sm-7">
                 <label>
                     <input type="text" name="postcode" class="form-control" placeholder="postcode">
                 </label>
             </div>
         </div>

        <div class="row justify-content-center">
            <div class="col-8 col-sm-5">
                 <strong>Stad:</strong>
             </div>
            <div class="col-8 col-sm-7">
                 <label>
                     <input type="text" name="stad" class="form-control" placeholder="stad">
                 </label>
             </div>
         </div>

        <div class="row justify-content-center">
             <div class="col-8 col-sm-5">
                 <strong>Land:</strong>
             </div>
             <div class="col-8 col-sm-7">
                 <label>
                     <input type="text" name="land" class="form-control" placeholder="land">
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
                <button type="submit" class="createbutton createbuttonSupportedContent">Registreren</button>
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div>
</section>
{{--</div>--}}

@endsection
