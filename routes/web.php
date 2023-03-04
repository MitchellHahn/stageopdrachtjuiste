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


/////////inloggen///////
Route::get('login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('login', [SessionController::class, 'store'])->middleware('guest');
/////uitloggen/////
Route::post('logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');
/////inglogd als//////
Route::get('loggedinas', [\App\Http\Controllers\LoggedisasController::class, 'index'])->name('loggedinas');


////////////controleren als het admin of gebruiker is///////////
///////// route middleware - kernel - homecontroller - redirect voor admin(B-medewerker)(account type 1)(inloggen)/////////////
Route::get('admin', [HomeController::class, 'admin'])->middleware('admin');
/// route middleware - kernel - homecontroller - redirect voor user(ZZPer)(account type 0)(inloggen)//////////
Route::get('/', [HomeController::class, 'home'])->middleware('user');

/////////// route voor de menu balk en buttons en paginas voor zpper op pc///////////////
Route::get('MijnProfiel', [\App\Http\Controllers\FrontController::class, 'MijnProfiel'])->name('BProfiel');


Route::get('Toevoegen', [\App\Http\Controllers\FrontController::class, 'Toevoegen'])->name('UToevoegen.overzicht_gewerkte_dagen');

Route::get('IngediendeToeslag', [\App\Http\Controllers\FrontController::class, 'IngediendeToeslag'])->name('UToevoegenToeslag.index');

///////////rout voor ZZPer module, pagina, venster en functie tijd indienen//////////
//Route::get('UenTToevoegen', [\App\Http\Controllers\UenTToevoegenController::class, 'UenTToevoegen']);
Route::get('tijden', [\App\Http\Controllers\TijdController::class, 'overzicht_van_alle_gewerkte_dagen_van_zpper'])->name('UToevoegen.overzicht_gewerkte_dagen');;
Route::post('tijden', [\App\Http\Controllers\TijdController::class, 'opslaan'])->name('UToevoegen.opslaan');;

Route::patch('tijden/wijzigen{tijd}/WijzigingOpslaan', [\App\Http\Controllers\TijdController::class, 'WijzigingOpslaan'])->name('UToevoegen.WijzigingOpslaan');;

Route::get('tijden/aanmaken', [\App\Http\Controllers\TijdController::class, 'aanmaken'])->name('UToevoegen.aanmaken');;
Route::get('tijden/layout', [\App\Http\Controllers\TijdController::class, 'layout'])->name('UToevoegen.layouts');;

Route::delete('tijden{tijd}', [\App\Http\Controllers\TijdController::class, 'verwijderen'])->name('UToevoegen.verwijderen');;
Route::get('tijden/tonen{tijd}', [\App\Http\Controllers\TijdController::class, 'tonen'])->name('UToevoegen.tonen');;
Route::get('tijden/wijzigen{tijd}', [\App\Http\Controllers\TijdController::class, 'wijzigen'])->name('UToevoegen.wijzigen');;



///////////rout voor ZZPer module, pagina, venster en functie toeslag indienen//////////
Route::get('toeslagen', [\App\Http\Controllers\ToeslagController::class, 'overzicht_van_alle_toeslagen_van_zpper'])->name('UToevoegenToeslag.overzicht_alle_toeslagen');;


////////////////////route voor bedrijven pagina(zzpermodule)//////////////////////
Route::get('klanten', [\App\Http\Controllers\BedrijfController::class, 'overzicht_van_alle_klanten'])->name('Klanten.overzicht_alle_klanten');;

Route::post('klanten/opslaan', [\App\Http\Controllers\BedrijfController::class, 'opslaan'])->name('Klanten.opslaan');;


Route::patch('klanten/wijzigen/{bedrijf}/WijzigingOpslaan', [\App\Http\Controllers\BedrijfController::class, 'WijzigingOpslaan'])->name('Klanten.WijzigingOpslaan');;

Route::get('klanten/aanmaken', [\App\Http\Controllers\BedrijfController::class, 'aanmaken'])->name('Klanten.aanmaken');;
Route::get('klanten/layout', [\App\Http\Controllers\BedrijfController::class, 'layout'])->name('Klanten.layouts');;

Route::delete('klanten{bedrijf}', [\App\Http\Controllers\BedrijfController::class, 'verwijderen'])->name('Klanten.verwijderen');;
Route::get('klanten/tonen/{bedrijf}', [\App\Http\Controllers\BedrijfController::class, 'tonen'])->name('Klanten.tonen');;
Route::get('klanten/wijzigen/{bedrijf}', [\App\Http\Controllers\BedrijfController::class, 'wijzigen'])->name('Klanten.wijzigen');;

////////////////////route voor factuur pagina(zzpermodule)//////////////////////
//Route::get('factuur/{bedrijf}', [\App\Http\Controllers\FactuurController::class, 'index'])->name('Factuur.index');;
Route::get('factuur/{bedrijf}/maand_selecteren', [\App\Http\Controllers\FactuurController::class, 'gemaakte_facturen_van_klant_tonen'])->name('Factuur.gemaakte_facturen_van_klant_tonen');;

Route::get('factuur/{bedrijf}/factuur_opties', [\App\Http\Controllers\FactuurController::class, 'uren_van_maand_tonen'])->name('Factuurmaand.uren_van_maand_tonen');;

Route::get('factuur_verzenden/{factuur}', '\App\Http\Controllers\FactuurController@factuur_maken_en_verzenden')->name('Factuurverzenden.pdf');

Route::get('factuur_downloaden/{factuur}', '\App\Http\Controllers\FactuurController@factuur_maken_en_downloaden')->name('Factuurdownloaden.pdf');


///////////////rout voor CC: e-mail aanmaken pagina pagina (zzpermodule)//////////////////
Route::get('factuur/contact/new', [\App\Http\Controllers\FactuurController::class, 'CC_aanmaken'])->name('Factuuremail.CC_aanmaken');
Route::post('factuur/contact', [\App\Http\Controllers\FactuurController::class, 'CC_opslaan'])->name('Factuuremail.CC_opslaan');
Route::get('factuur/contact/{brouwerscontact}', [\App\Http\Controllers\FactuurController::class, 'CC_wijzigen'])->name('Factuuremail.CC_wijzigen');
Route::patch('factuur/contact/{brouwerscontact}', [\App\Http\Controllers\FactuurController::class, 'CC_wijziging_opslaan'])->name('Factuuremail.CC_wijziging_opslaan');;
Route::delete('factuur/contact/{brouwerscontact}', [\App\Http\Controllers\FactuurController::class, 'CC_verwijderen'])->name('Factuuremail.CC_verwijderen');;


///////////////rout voor profiel pagina (zzpermodule)//////////////////
Route::get('user/bprofiel', [\App\Http\Controllers\UserProfielController::class, 'overzicht_profiel_gegevens'])->name('BProfiel.overzicht_profiel_gegevens');;

Route::get('user/bprofiel/layout', [\App\Http\Controllers\UserProfielController::class, 'layout'])->name('BProfiel.layouts');;
Route::delete('user/bprofiel/{user}', [\App\Http\Controllers\UserProfielController::class, 'verwijderen'])->name('BProfiel.verwijderen');;
//Route::get('user/show/{user}', [\App\Http\Controllers\UserProfielController::class, 'show'])->name('BProfiel.show');;
Route::get('user/bprofiel/wijzigen/{user}', [\App\Http\Controllers\UserProfielController::class, 'wijzigen'])->name('BProfiel.wijzigen');;
Route::patch('user/bprofiel/wijzigen/{user}/WijzigingOpslaan', [\App\Http\Controllers\UserProfielController::class, 'WijzigingOpslaan'])->name('BProfiel.WijzigingOpslaan');;
/////////////////////////route voor tariefen///////////////////////////////////
//Route::get('user/bprofiel/tarief', [\App\Http\Controllers\TariefController::class, 'index'])->name('BProfieltarief.index');;
Route::get('user/bprofiel/aanmaken', [\App\Http\Controllers\TariefController::class, 'aanmaken'])->name('BProfieltarief.aanmaken');;
Route::post('user/bprofiel/opslaan', [\App\Http\Controllers\TariefController::class, 'opslaan'])->name('BProfieltarief.opslaan');;

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


    return redirect()->route('Bedrijf.index')
        ->with('success', ' bedrijf_id is opgeslagen');
});

/////////////////////////////////////////////////////////////////////
////////////////////////////admin/b-medewerker routs//////////////////////////////
/////////////////////////////////////////////////////////////////////

///////////////////////navbar//////////////////////
Route::get('Profiel', [\App\Http\Controllers\FrontController::class, 'Profiel'])->name('AProfiel');
Route::get('Registratie', [\App\Http\Controllers\FrontController::class, 'Registratie'])->name('Registratie.index');
Route::get('Gebruikers', [\App\Http\Controllers\FrontController::class, 'Gebruikers'])->name('Gebruikers');

/////////////pagina profiel voor admin module ///////////////////////
Route::get('user/', [\App\Http\Controllers\AdminProfielController::class, 'overzicht_profiel_gegevens'])->name('AProfiel.profiel');;

Route::get('user/layout', [\App\Http\Controllers\AdminProfielController::class, 'layout'])->name('AProfiel.layouts');;
Route::delete('user{user}', [\App\Http\Controllers\AdminProfielController::class, 'destroy'])->name('AProfiel.destroy');;
Route::get('user/gegevens_wijzigen/{user}', [\App\Http\Controllers\AdminProfielController::class, 'gegevens_wijzigen'])->name('AProfiel.gegevens_wijzigen');;
Route::patch('user/gegevens_wijzigen/{user}/wijziging_opslaan', [\App\Http\Controllers\AdminProfielController::class, 'wijziging_opslaan'])->name('AProfiel.wijziging_opslaan');;

/////////////pagina registratie voor admin module ///////////////////////
Route::get('user/registratie', [\App\Http\Controllers\RegistratieController::class, 'registratie_formulier'])->name('Registratie.registratie_formulier');;
Route::post('user/registratie', [\App\Http\Controllers\RegistratieController::class, 'gebruiker_registreren'])->name('Registratie.gebruiker_registreren');;

///////////////pagina toeslagen voor DMIN MODULE////////////////////
Route::get('user/toeslag', [\App\Http\Controllers\GebruikerController::class, 'overzicht_van_alle_zppers'])->name('Toeslagen.zppers');;

Route::get('user/toeslag/aanmaken/{user}', [\App\Http\Controllers\GebruikerController::class, 'toeslagaanmaken'])->name('Toeslagen.aanmaken');;
Route::post('user/toeslag/{user}', [\App\Http\Controllers\GebruikerController::class, 'gebruikerstoeslagopslaan'])->name('Toeslagen.gebruikerstoeslagopslaan');;

////////////////////////pagina gebruikers voor ADMIN Module ///////////////////////////////////
Route::get('user/lijst', [\App\Http\Controllers\GebruikerController::class, 'overzicht_van_alle_gebruikers'])->name('Gebruikers.overzicht');;

Route::delete('user/lijst/{user}', [\App\Http\Controllers\GebruikerController::class, 'gebruiker_verwijderen'])->name('Gebruikers.gebruiker_verwijderen');;
Route::get('user/lijst/tonen/{user}', [\App\Http\Controllers\GebruikerController::class, 'gegevens_tonen'])->name('Gebruikers.gegevens_tonen');;
Route::get('user/lijst/wijzigen/{user}', [\App\Http\Controllers\GebruikerController::class, 'gegevens_wijzigen'])->name('Gebruikers.gegevens_wijzigen');;
Route::patch('user/lijst/wijzigen/{user}/wijziging_opslaan', [\App\Http\Controllers\GebruikerController::class, 'wijziging_opslaan'])->name('Gebruikers.wijziging_opslaan');;

///////////////routes voor user impersonate(overnemen) functie/////////////////////
Route::group(['middleware' => ['auth']], function () {
   Route::get('user/lijst/overnemen',   [\App\Http\Controllers\GebruikerController::class, 'index'])->name('index');
   Route::get('/gebruiker_overnemen/{id}',  [\App\Http\Controllers\GebruikerController::class, 'gebruiker_overnemen'])->name('gebruiker_overnemen');
   Route::get('/overname_stoppen',  [\App\Http\Controllers\GebruikerController::class, 'overname_stoppen'])->name('overname_stoppen');

});

