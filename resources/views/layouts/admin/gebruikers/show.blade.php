@extends('layouts.app')

@section('content')

    <?php //pagina van ZZPer module waar hij/zij uren en toeslag kunnen invoeren en facturen aanmaken?>
    <section class="section">
      <div class="container-xl height100 containerSupportedContent" style="align-self:flex-end;">

          <div class="row">
              <div class="col-xl">
                  <div class="titlebox titleboxSupportedContent">

                      <h2 class="title titleSupportedContent">Gebruikers</h2>
                      <h class="info infoSupportedContent">Profiel van de gebruiker.</h>

                  </div>
              </div>
          </div>

          </br>
          </br>
          </br>

            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="float-right">
                        <a class="createbutton createbuttonSupportedContent" href="{{ route('Gebruikers.index') }}">Terug</a>
                    </div>
                </div>
            </div>
{{--    </div>--}}

          <div class="container-lg " >
              <div class="row  justify-content-center">
                  <div class="col-md-11  sectioninner">

    <?php // uren en toeslag toevoegen?>

{{--          <div class="container-xl height73" >--}}
{{--              <div class="row height100 justify-content-center">--}}
{{--                  <div class="col-xl height100 sectioninner" style="align-self:flex-end;">--}}
{{----}}
{{--                      <div class="row justify-content-center">--}}
{{--                          <div class="col-lg">--}}

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

          <div class="row justify-content-center">
              <div class="col-sm-5">
                  <div class="row justify-content-center" >
                      <div class="col-8 col-sm-5">
                          <strong>Voornaam:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Voornaam">
                          </label>
                      </div>
                  </div>

                  <div class="row justify-content-center" >
                      <div class="col-8 col-sm-5">
                          <strong>Tussenvoegsel:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="tussenvoegsel" value="{{ $user->tussenvoegsel }}" class="form-control" placeholder="Tussenvoegsel">
                          </label>
                      </div>
                  </div>

                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>Achternaam:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="achternaam" value="{{ $user->achternaam }}" class="form-control" placeholder="Achternaam">
                          </label>
                      </div>
                  </div>

                  <div class="row justify-content-center" >
                      <div class="col-8 col-sm-5">
                          <strong>Straat:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="straat" value="{{ $user->straat }}" class="form-control" placeholder="Straat">
                          </label>
                      </div>
                  </div>



                  <div class="row justify-content-center" >
                      <div class="col-8 col-sm-5">
                          <strong>Huisnummer:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="number" name="huisnummer" value="{{ $user->huisnummer }}" class="form-control" placeholder="Huisnummer">
                          </label>
                      </div>
                  </div>



                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>Toevoeging:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="toevoeging" value="{{ $user->toevoeging }}" class="form-control" placeholder="Toevoeging">
                          </label>
                      </div>
                  </div>



                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>Postcode:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="postcode" value="{{ $user->postcode }}" class="form-control" placeholder="Postcode">
                          </label>
                      </div>
                  </div>



                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>Stad:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="stad" value="{{ $user->stad }}" class="form-control" placeholder="Stad">
                          </label>
                      </div>
                  </div>



                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>Land:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="land" value="{{ $user->land }}" class="form-control" placeholder="Land">
                          </label>
                      </div>
                  </div>
              </div>

              <div class="col-sm-5">

                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>Telefoonnummer:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="telefoonnumer" value="{{ $user->telefoonnumer }}" class="form-control" placeholder="Telefoonnumer">
                          </label>
                      </div>
                  </div>

                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>E-mail:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="email" value="{{ $user->email }}" class="form-control" placeholder="E-mail">
                          </label>
                      </div>
                  </div>

                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>KVK-nummer:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="number" name="kvknummer" value="{{ $user->kvknummer }}" class="form-control" placeholder="KVK-nummer">
                          </label>
                      </div>
                  </div>

                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>BTW-nummer:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="btwnummer" value="{{ $user->btwnummer }}" class="form-control" placeholder="BTW-nummer">
                          </label>
                      </div>
                  </div>

                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>Iban-nummer:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="ibannummer" value="{{ $user->ibannummer }}" class="form-control" placeholder="Iban-nummer">
                          </label>
                      </div>
                  </div>

                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>Bedrijfsnaam:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <input type="text" name="bedrijfsnaam" value="{{ $user->bedrijfsnaam }}" class="form-control" placeholder="Bedrijfsnaam">
                          </label>
                      </div>
                  </div>

                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>Account type:</strong>
                      </div>
                      <div class="col-8 col-sm-7" >
                          <label>
                              <select name="account_type" class="form-control">
                                  <option value="0">Gebruiker</option>
                                  <option value="1">Admin</option>
                              </select>
                          </label>
                      </div>
                  </div>

              </div>
          </div>

{{--    <form action="{{ route('AProfiel.destroy',$user->id) }}" method="POST">--}}

        {{--                        <a class="btn btn-info" href="{{ route('Bedrijven.show',$bedrijf->id) }}">Show</a>--}}
{{--        <a class="btn btn-primary" href="{{ route('AProfiel.edit',$user->id) }}">Edit</a>--}}


        @csrf
        @method('DELETE')

{{--    </form>--}}

    {{--        @endforeach--}}

    {{--    {!! $tijden ->links() !!}--}}
    </div>
    </div>
    </div>
    </div>
    </section>
@endsection


