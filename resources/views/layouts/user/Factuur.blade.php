@extends('layouts.app')

@section('content')
{{--hier kies je een bedrijf om een factuur te maken--}}
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h5><i>Facturen</i></h5>
                <h><i> Toon alle facturen voor: </i></h>
                <form method="POST" action="{{ route('Factuur.select',$bedrijf->id) }}">
                    {{ csrf_field() }}

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Klant:</strong>
                                                <label for="">
                                                    <select name="bedrijf_id">

                                                            <option value="{{$bedrijf->id}}">{{$bedrijf->bedrijfsnaam}}</option>

                                                    </select>
                                                </label>
                                            </div>
                                        </div>

                    <input type="submit" value="Submit" class="btn btn-primary" >
                </form>
            </div>
        </div>
    </div>
@endsection
