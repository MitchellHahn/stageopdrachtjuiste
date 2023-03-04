@extends('layouts.app')

@section('content')

{{-- pagin voor het tonen van de gebruiker (medewerkers module)--}}
    <section class="section">
      <div class="container-xl height100 containerSupportedContent" style="align-self:flex-end;">

          <div class="row">
              <div class="col-xl">
                  <div class="titlebox titleboxSupportedContent">
                      {{-- Titel en beshcrijving van de pagina --}}
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
                        {{-- Knop om terug te geaan de gebruikers overzicht pagina --}}
                        <a class="createbutton createbuttonSupportedContent" href="{{ route('Gebruikers.overzicht') }}">Terug</a>
                    </div>
                </div>
            </div>

          <div class="container-lg " >
              <div class="row  justify-content-center">
                  <div class="col-md-11  sectioninner">


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

          <div class="row justify-content-center">
              <div class="col-sm-5">

                  {{--   toont de woord "Voornaam" en de Voornaam van de gebruiker  --}}
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

                  {{--   toont de woord "Tussenvoegsel" en de Tussenvoegsel van de gebruiker  --}}
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

                  {{--   toont de woord "Achternaam" en de Achternaam van de gebruiker  --}}
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

                  {{--   toont de woord "Straat" en de Straat van de gebruiker  --}}
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

                  {{--   toont de woord "Huisnummer" en de Huisnummer van de gebruiker  --}}
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

                  {{--   toont de woord "Toevoeging" en de Toevoeging van de gebruiker  --}}
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

                  {{--   toont de woord "Postcode" en de Postcode van de gebruiker  --}}
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

                  {{--   toont de woord "Stad" en de Stad van de gebruiker  --}}
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

                  {{--   toont de woord "Land" en de Land van de gebruiker  --}}
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
                  {{--   toont de woord "Telefoonnummer" en de Telefoonnummer van de gebruiker  --}}
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

                  {{--   toont de woord "E-mail" en de E-mail van de gebruiker  --}}
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

                  {{--   toont de woord "KVK-nummer" en de KVK-nummer van de gebruiker  --}}
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

                  {{--   toont de woord "BTW-nummer" en de BTW-nummer van de gebruiker  --}}
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

                  {{--   toont de woord "Iban-nummer" en de Iban-nummer van de gebruiker  --}}
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

                  {{--   toont de woord "Bedrijfsnaam" en de Bedrijfsnaam van de gebruiker  --}}
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

                  {{--   toont de woord "Soort gebruiker" en de Soort gebruiker van de gebruiker  --}}
                  <div class="row justify-content-center">
                      <div class="col-8 col-sm-5">
                          <strong>Soort gebruiker:</strong>
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

        @csrf
        @method('DELETE')

    </div>
    </div>
    </div>
    </div>
    </section>
@endsection


