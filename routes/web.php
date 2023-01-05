<?php

use App\Http\Controllers\SessionController;
use App\Models\Tijd;
use App\Models\Toeslag;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Middleware\Admin;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\TijdController;
use App\Http\Controllers\ToeslagController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('layouts.master');
//});

Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('user.index');


/////////inloggen///////
Route::get('login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('login', [SessionController::class, 'store'])->middleware('guest');
/////uitloggen/////
Route::post('logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');
/////inglogd als//////
Route::get('loggedinas', [\App\Http\Controllers\LoggedisasController::class, 'index'])->name('loggedinas');
//Route::get('loggedinas', [\App\Http\Controllers\SessionController::class, 'loggedinas'])->name('loggedinas');


////////////controleren als het admin of gebruiker is///////////
///////// route middleware - kernel - homecontroller - redirect voor admin(B-medewerker)(account type 1)(inloggen)/////////////
Route::get('admin', [HomeController::class, 'admin'])->middleware('admin');
/// route middleware - kernel - homecontroller - redirect voor user(ZZPer)(account type 0)(inloggen)//////////
Route::get('/', [HomeController::class, 'home'])->middleware('user');

/////////// route voor de menu balk en buttons en paginas voor zpper op pc///////////////
Route::get('MijnProfiel', [\App\Http\Controllers\FrontController::class, 'MijnProfiel'])->name('BProfiel');

//Route::get('Klanten', [\App\Http\Controllers\FrontController::class, 'Klanten'])->name('Klanten.index');

//Route::get('Factuur', [\App\Http\Controllers\FrontController::class, 'Factuur'])->name('Factuur.index');

Route::get('Toevoegen', [\App\Http\Controllers\FrontController::class, 'Toevoegen'])->name('UToevoegen.index');

Route::get('IngediendeToeslag', [\App\Http\Controllers\FrontController::class, 'IngediendeToeslag'])->name('UToevoegenToeslag.index');

///////////rout voor ZZPer module, pagina, venster en functie tijd indienen//////////
//Route::get('UenTToevoegen', [\App\Http\Controllers\UenTToevoegenController::class, 'UenTToevoegen']);
Route::get('tijden', [\App\Http\Controllers\TijdController::class, 'index'])->name('UToevoegen.index');;
Route::post('tijden', [\App\Http\Controllers\TijdController::class, 'store'])->name('UToevoegen.store');;

Route::patch('tijden/edit{tijd}/update', [\App\Http\Controllers\TijdController::class, 'update'])->name('UToevoegen.update');;

Route::get('tijden/create', [\App\Http\Controllers\TijdController::class, 'create'])->name('UToevoegen.create');;
Route::get('tijden/layout', [\App\Http\Controllers\TijdController::class, 'layout'])->name('UToevoegen.layouts');;

Route::delete('tijden{tijd}', [\App\Http\Controllers\TijdController::class, 'destroy'])->name('UToevoegen.destroy');;
Route::get('tijden/show{tijd}', [\App\Http\Controllers\TijdController::class, 'show'])->name('UToevoegen.show');;
Route::get('tijden/edit{tijd}', [\App\Http\Controllers\TijdController::class, 'edit'])->name('UToevoegen.edit');;


//Route::get('toeslagen{tijd}', [\App\Http\Controllers\TijdController::class, 'index'])->name('UToevoegen.index');;

///////////rout voor ZZPer module, pagina, venster en functie toeslag indienen//////////
Route::get('toeslagen', [\App\Http\Controllers\ToeslagController::class, 'index'])->name('UToevoegenToeslag.index');;

Route::post('toeslagen/store', [\App\Http\Controllers\ToeslagController::class, 'store'])->name('UToevoegenToeslag.store');;

//Route::patch('toeslagen/update', [\App\Http\Controllers\ToeslagController::class, 'update'])->name('UToevoegenToeslag.update');;

Route::patch('toeslagen/edit/{toeslag}/update', [\App\Http\Controllers\ToeslagController::class, 'update'])->name('UToevoegenToeslag.update');;

Route::get('toeslagen/create', [\App\Http\Controllers\ToeslagController::class, 'create'])->name('UToevoegenToeslag.create');;
Route::get('toeslagen/layout', [\App\Http\Controllers\ToeslagController::class, 'layout'])->name('UToevoegenToeslag.layouts');;

Route::delete('toeslagen{toeslag}', [\App\Http\Controllers\ToeslagController::class, 'destroy'])->name('UToevoegenToeslag.destroy');;
Route::get('toeslagen/show/{toeslag}', [\App\Http\Controllers\ToeslagController::class, 'show'])->name('UToevoegenToeslag.show');;
Route::get('toeslagen/edit/{toeslag}', [\App\Http\Controllers\ToeslagController::class, 'edit'])->name('UToevoegenToeslag.edit');;

////////////////////route voor bedrijven pagina(zzpermodule)//////////////////////
Route::get('klanten', [\App\Http\Controllers\BedrijfController::class, 'index'])->name('Klanten.index');;

Route::post('klanten/store', [\App\Http\Controllers\BedrijfController::class, 'store'])->name('Klanten.store');;

//Route::patch('bedrijven/update', [\App\Http\Controllers\BedrijfController::class, 'update'])->name('Bedrijven.update');;

Route::patch('klanten/edit/{bedrijf}/update', [\App\Http\Controllers\BedrijfController::class, 'update'])->name('Klanten.update');;

Route::get('klanten/create', [\App\Http\Controllers\BedrijfController::class, 'create'])->name('Klanten.create');;
Route::get('klanten/layout', [\App\Http\Controllers\BedrijfController::class, 'layout'])->name('Klanten.layouts');;

Route::delete('klanten{bedrijf}', [\App\Http\Controllers\BedrijfController::class, 'destroy'])->name('Klanten.destroy');;
Route::get('klanten/show/{bedrijf}', [\App\Http\Controllers\BedrijfController::class, 'show'])->name('Klanten.show');;
Route::get('klanten/edit/{bedrijf}', [\App\Http\Controllers\BedrijfController::class, 'edit'])->name('Klanten.edit');;

////////////////////route voor factuur pagina(zzpermodule)//////////////////////
Route::get('factuur/{bedrijf}', [\App\Http\Controllers\FactuurController::class, 'index'])->name('Factuur.index');;
Route::get('factuur/{bedrijf}/select', [\App\Http\Controllers\FactuurController::class, 'getBedrijf'])->name('Factuur.select');;

Route::get('factuur/{bedrijf}/create', [\App\Http\Controllers\FactuurController::class, 'getDate'])->name('Factuurmaand.select');;

Route::get('downloadPDF/{factuur}/send', '\App\Http\Controllers\FactuurController@sendPDF')->name('Factuursend.pdf');

Route::get('downloadPDF/{factuur}', '\App\Http\Controllers\FactuurController@downloadPDF')->name('Factuur.pdf');

//Route::delete('factuur/{bedrijf}/downloadPDF/{user}', '\App\Http\Controllers\FactuurController@getuserinfo')->name('Factuuruser.pdf');;

///////////////rout voor profiel pagina (zzpermodule)//////////////////
Route::get('factuur/contact/new', [\App\Http\Controllers\FactuurController::class, 'create'])->name('Factuuremail.create');
Route::post('factuur/contact', [\App\Http\Controllers\FactuurController::class, 'store'])->name('Factuuremail.store');
Route::get('factuur/contact/{brouwerscontact}', [\App\Http\Controllers\FactuurController::class, 'edit'])->name('Factuuremail.edit');
Route::patch('factuur/contact/{brouwerscontact}', [\App\Http\Controllers\FactuurController::class, 'update'])->name('Factuuremail.update');;
Route::delete('factuur/contact/{brouwerscontact}', [\App\Http\Controllers\FactuurController::class, 'destroy'])->name('Factuuremail.destroy');;


///////////////rout voor profiel pagina (zzpermodule)//////////////////
Route::get('user/bprofiel', [\App\Http\Controllers\UserProfielController::class, 'index'])->name('BProfiel.index');;

//Route::post('user/bprofiel/store', [\App\Http\Controllers\UserProfielController::class, 'store'])->name('BProfiel.store');;
//Route::get('user/bprofiel/create', [\App\Http\Controllers\UserProfielController::class, 'create'])->name('BProfiel.create');;

Route::get('user/bprofiel/layout', [\App\Http\Controllers\UserProfielController::class, 'layout'])->name('BProfiel.layouts');;
Route::delete('user/bprofiel/{user}', [\App\Http\Controllers\UserProfielController::class, 'destroy'])->name('BProfiel.destroy');;
//Route::get('user/show/{user}', [\App\Http\Controllers\UserProfielController::class, 'show'])->name('BProfiel.show');;
Route::get('user/bprofiel/edit/{user}', [\App\Http\Controllers\UserProfielController::class, 'edit'])->name('BProfiel.edit');;
Route::patch('user/bprofiel/edit/{user}/update', [\App\Http\Controllers\UserProfielController::class, 'update'])->name('BProfiel.update');;
/////////////////////////route voor tariefen///////////////////////////////////
//Route::get('user/bprofiel/tarief', [\App\Http\Controllers\TariefController::class, 'index'])->name('BProfieltarief.index');;
Route::get('user/bprofiel/create', [\App\Http\Controllers\TariefController::class, 'create'])->name('BProfieltarief.create');;
Route::post('user/bprofiel/store', [\App\Http\Controllers\TariefController::class, 'store'])->name('BProfieltarief.store');;
///////////////////route voor CC: email op profiel////////////////
//Route::get('user/contact/new', [\App\Http\Controllers\FactuurController::class, 'create'])->name('Brouwerscontact.create');
//Route::post('user/contact', [\App\Http\Controllers\FactuurController::class, 'store'])->name('Brouwerscontact.store');
//Route::get('user/contact/{brouwerscontact}', [\App\Http\Controllers\FactuurController::class, 'edit'])->name('Brouwerscontact.edit');
//Route::patch('user/contact/{brouwerscontact}', [\App\Http\Controllers\FactuurController::class, 'update'])->name('Brouwerscontact.update');;
//Route::delete('user/contact/{brouwerscontact}', [\App\Http\Controllers\FactuurController::class, 'destroy'])->name('Brouwerscontact.destroy');;

/////////////alleen data van tabel tijd voor ingelogde gebruiker tonen(user/zpper)//////////////
Route::get('tijden/user', function () {
    $users = auth()->user();
    return $users->tijden()->get();
});

Route::get('tijden/{id}', function ($id) {

    $tijd = Tijd::findOrFail($id);
    if($tijd->user_id == auth()->id()){
        return $tijd;
    }
    return "Only the ZPPer can see his note.";
});

/////////////alleen data van tabel toeslag voor ingelogde gebruiker tonen(user/zpper)//////////////
Route::get('toeslagen/user', function () {
    $users = auth()->user();
    return $users->toeslagen()->get();
});

Route::get('toeslagen/{id}', function ($id) {

    $toeslag = Toeslag::findOrFail($id);
    if($toeslag->user_id == auth()->id()){
        return $toeslag;
    }
    return "Only the ZPPer can see his note.";
});

////////////////user_id automatisch invullen bij het invoeren van een toeslag/////////////

Route::post('toeslagen/user{user_id}', function (\Illuminate\Http\Request $request) {
    $toeslag = new Toeslag();
    $toeslag-> datum = $request->datum;

    return redirect()->route('UToevoegenToeslag.index')
       ->with('success', ' toeslag is opgeslagen');
});

////////////////toeslag_id automatisch invullen bij het invoeren van een tijd/////////////
////////////////datum automatisch invullen bij het invoeren van een tijd/////////////

$toeslag = 'user_id' ;
$user = $toeslag ;
$user = 'id';
$tijd = $toeslag;
$tijd = 'toeslag_id';

Route::post('tijden/toeslag{toeslag_id}', function (\Illuminate\Http\Request $request) use ($toeslag, $user) {

    $tijd = new Tijd();
    $tijd-> begintijd = $request->begintijd;


    return redirect()->route('UToevoegenToeslag.index')
        ->with('success', ' toeslag is opgeslagen');
});

/////////////user_id automatisch invullen bij het invoeren van een toeslag//////////////
Route::get('bedrijven/user', function () {
    $users = auth()->user();
    return $users->bedrijven()->get();
});
Route::get('bedrijven/{id}', function ($id) {

    $bedrijf = Bedrijf::findOrFail($id);
    if($bedrijf->user_id == auth()->id()){
        return $bedrijf;
    }
    return "Only the ZPPer can see his note.";
});
Route::post('bedrijven/user{user_id}', function (\Illuminate\Http\Request $request) {
    $bedrijf = new Bedrijf();
    $bedrijf-> bedrijfsnaam;

    return redirect()->route('Bedrijven.index')
        ->with('success', ' bedrijf is geregistreerd');
});

////////////////toeslag_id automatisch invullen bij het invoeren van een tijd/////////////
////////////////datum automatisch invullen bij het invoeren van een tijd/////////////
$bedrijf = 'user_id' ;
$user = $bedrijf ;
$user = 'id';
$tijd = $bedrijf;
$tijd = 'bedrijf_id';

Route::post('tijden/bedrijf{bedrijf_id}', function (\Illuminate\Http\Request $request) use ($bedrijf, $user) {

//    $tijd = new Tijd();
//    $tijd-> begintijd = $request->begintijd;


    return redirect()->route('Bedrijf.index')
        ->with('success', ' bedrijf_id is opgeslagen');
});

/////////////////////////////////////////////////////////////////////
////////////////////////////admin routs//////////////////////////////
/////////////////////////////////////////////////////////////////////

///////////////////////navbar//////////////////////
Route::get('Profiel', [\App\Http\Controllers\FrontController::class, 'Profiel'])->name('AProfiel');
Route::get('Registratie', [\App\Http\Controllers\FrontController::class, 'Registratie'])->name('Registratie.index');
Route::get('Gebruikers', [\App\Http\Controllers\FrontController::class, 'Gebruikers'])->name('Gebruikers');

/////////////pagina profiel voor admin module ///////////////////////
Route::get('user/', [\App\Http\Controllers\AdminProfielController::class, 'index'])->name('AProfiel.index');;

//Route::post('user/', [\App\Http\Controllers\AdminProfielController::class, 'store'])->name('AProfiel.store');;
//Route::get('user/create', [\App\Http\Controllers\AdminProfielController::class, 'create'])->name('AProfiel.create');;

Route::get('user/layout', [\App\Http\Controllers\AdminProfielController::class, 'layout'])->name('AProfiel.layouts');;
Route::delete('user{user}', [\App\Http\Controllers\AdminProfielController::class, 'destroy'])->name('AProfiel.destroy');;
Route::get('user/show/{user}', [\App\Http\Controllers\AdminProfielController::class, 'show'])->name('AProfiel.show');;
Route::get('user/edit/{user}', [\App\Http\Controllers\AdminProfielController::class, 'edit'])->name('AProfiel.edit');;
Route::patch('user/edit/{user}/update', [\App\Http\Controllers\AdminProfielController::class, 'update'])->name('AProfiel.update');;

/////////////pagina registratie voor admin module ///////////////////////
Route::get('user/registratie', [\App\Http\Controllers\RegistratieController::class, 'index'])->name('Registratie.index');;
Route::post('user/registratie', [\App\Http\Controllers\RegistratieController::class, 'store'])->name('Registratie.store');;
Route::get('user/registratie/create', [\App\Http\Controllers\RegistratieController::class, 'create'])->name('Registratie.create');;

///////////////pagina gebruikers voor DMIN MODULE////////////////////
Route::get('user/lijst', [\App\Http\Controllers\GebruikerController::class, 'index'])->name('Gebruikers.index');;
Route::post('user/lijst', [\App\Http\Controllers\GebruikerController::class, 'store'])->name('Gebruikers.store');;

//Route::get('tijden/lijstcreate', [\App\Http\Controllers\GebruikerController::class, 'create'])->name('Gebruikers.create');;
//Route::get('user/layout', [\App\Http\Controllers\GebruikerController::class, 'layout'])->name('Gebruikers.layouts');;

Route::delete('user/lijst/{user}', [\App\Http\Controllers\GebruikerController::class, 'destroy'])->name('Gebruikers.destroy');;
Route::get('user/lijst/show/{user}', [\App\Http\Controllers\GebruikerController::class, 'show'])->name('Gebruikers.show');;
Route::get('user/lijst/edit/{user}', [\App\Http\Controllers\GebruikerController::class, 'edit'])->name('Gebruikers.edit');;
Route::patch('user/lijst/edit/{user}/update', [\App\Http\Controllers\GebruikerController::class, 'update'])->name('Gebruikers.update');;

///////////////routes voor user impersonate functie/////////////////////
Route::group(['middleware' => ['auth']], function () {
   Route::get('user/lijst/takeover',   [\App\Http\Controllers\GebruikerController::class, 'index'])->name('index');
   Route::get('/impersonate/{id}',  [\App\Http\Controllers\GebruikerController::class, 'impersonate'])->name('impersonate');
   Route::get('/impersonate_leave',  [\App\Http\Controllers\GebruikerController::class, 'impersonate_leave'])->name('impersonate.leave');

});

