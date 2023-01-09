@extends('layouts.app')

@section('content')
    <section class="section">
        {{--    <div class="section" >--}}

        <div class="container-xl height100 containerSupportedContent">
            <div class="row">
                <div class="col-lg">
                    <div class="titlebox titleboxSupportedContent">

                        <h2 class="title titleSupportedContent">Bevestigen</h2>
                        <h class="info infoSupportedContent">Maak een wachtwoord aan.</h>

                    </div>
                </div>
            </div>

            </br>

            <div class="container-lg height70">
                <div class="row height100 justify-content-center">
                    <div class="col-md-12 height100 sectioninner" style="align-self:flex-end;">

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

    <form action="{{ url('reset-password') }}" method="POST">
        @csrf

        <input type="hidden" name="token" value="{{ $request->token }}">

        <div class="row justify-content-center">
            <div class="col-sm-5">

                 <div class="row justify-content-center">
                     <div class="col-8 col-sm-5">
                         <strong>E-mail:</strong>
                     </div>
                     <div class="col-8 col-sm-7">
                         <label>
                                 <input type="text" name="email" value="{{ $request->email }}" class="form-control" placeholder="E-mail">
                         </label>
                     </div>
                 </div>

                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Wachtwoord:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                         <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                         @error('password')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                         @enderror
                     </div>
                 </div>

                <div class="row justify-content-center">
                    <div class="col-8 col-sm-5">
                        <strong>Wachtwoord bevestigen:</strong>
                    </div>
                    <div class="col-8 col-sm-7">
                        <label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
                        </label>
                    </div>
                </div>
{{--         <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--             <div class="form-group">--}}
{{--                 <strong>password:</strong>--}}
{{--                 <label>--}}
{{--                     <input type="text" name="password_confirmation" class="form-control" placeholder="password">--}}
{{--                 </label>--}}
{{--             </div>--}}
{{--         </div>--}}

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary createbutton createbuttonSupportedContent">Bevestigen</button>
                </div>

            </div>
        </div>
    </form>

                               </div>
                        </div>
                  </div>
            </div>
    </section>
@endsection
