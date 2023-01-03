@extends('layouts.user.functietoevoegen.layout')

@section('content')
    <section class="section" style="flex:1 0">

        <div class="container-md height100 containerSupportedContent">
            <div class="row jus">
                <div class="col-md">
                    <div class="titlebox titleboxSupportedContent">

                        <h3 class="title titleSupportedContent">Inloggen</h3>
                        <h class="info infoSupportedContent">Vul je inloggevens in.</h>
                    </div>
                </div>
            </div>

            </br>
            </br>
            </br>

                    {{--    </div>--}}

            <div class="container-md  " >
                <div class="row justify-content-center">

                    <div class="col-sm-8 sectioninner">

                        <form method="POST" action="/login" class="mt-10">
                            @csrf
                            {{--                        @method('PATCH')--}}

                            {{--tabel tijd--}}

                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-2">
                                            <strong>Email:</strong>
                                        </div>
                                        <div class="col-sm-5">
                                            <label>
                                                <input class="border border-gray-400 p-2 w-full"
                                                       type="email"
                                                       name="email"
                                                       id="email"
                                                       value="{{old('email')}}"
                                                       required
                                                >

                                                @error('email')
                                                <p class="text-red-500 text-xs mt-2">{{$message}}</p>
                                                @enderror
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-2">
                                            <strong>Wachtwoord:</strong>
                                        </div>
                                        <div class="col-sm-5">
                                            <label>
                                                <input class="border border-gray-400 p-2 w-full"
                                                       type="password"
                                                       name="password"
                                                       id="password"
                                                       required
                                                >

                                                @error('password')
                                                <p class="text-red-500 text-xs mt-2">{{$message}}</p>
                                                @enderror
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
                                    <button type="submit" class="createbutton createbuttonSupportedContent">Inloggen</button>
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
