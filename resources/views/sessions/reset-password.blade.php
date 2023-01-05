@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            {{--            <div class="pull-left">--}}
            {{--                <h2>Uren</h2>--}}
            {{--            </div>--}}
            {{--            <div class="pull-right">--}}
            {{--                <a class="btn btn-primary" href="{{ route('UToevoegen.index') }}"> Back</a>--}}
            {{--            </div>--}}
        </div>
    </div>

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

     <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12">
             <div class="form-group">
                 <strong>E-mail:</strong>
                 <label>
                     <input type="text" name="email" value="{{ $request->email }}" class="form-control" placeholder="E-mail">
                 </label>
             </div>
         </div>


         <div class="form-group row">
             <label for="password" class="col-md-4 col-form-label text-md-right">Wachtwoord</label>

             <div class="col-md-6">
                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                 @error('password')
                 <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                 @enderror
             </div>
         </div>

         <div class="form-group row">
             <label for="password" class="col-md-4 col-form-label text-md-right">Wachtwoord bevestigen</label>

             <div class="col-md-6">
                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
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
                <button type="submit" class="btn btn-primary">Bevestigen</button>
            </div>
        </div>

    </form>
@endsection
