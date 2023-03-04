<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Lab404\Impersonate\Models\Impersonate;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    // standaard laravel functies gebruiken
    use HasApiTokens, HasFactory, Notifiable, Impersonate;

    // gebruikt tabel users van de databse
    protected $table = 'users';

    /**
     * de kolomen dat van tabel users worden gebruikt
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'tussenvoegsel', 'achternaam', 'email', 'telefoonnumer', 'straat', 'huisnummer', 'toevoeging', 'postcode', 'stad', 'land', 'password', 'account_type', 'kvknummer', 'btwnummer', 'ibannummer', 'bedrijfsnaam',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',

    ];

    // geen extra spatie als de gebruikersnaam geen tussen voegsel heeft
    public function getLastName(): ?string {
        $nameLast = $this->achternaam;

        if($this->tussenvoegsel) {
            return $this->tussenvoegsel.' '.$nameLast;
        }

        return $nameLast;
    }

    // een gebruiker is gekoppelt aan meerdere toeslagen
    // via vreemde sleutel kloppelen aan "Toeslag" model of class
    public function toeslagen()
    {
        return $this->hasMany( related: Toeslag::class);
    }

    // een gebruiker is gekoppelt aan meerdere tijden
    // via vreemde sleutel kloppelen aan "Tijd" model of class
    public function tijden()
    {
        return $this->hasMany( Tijd::class );
    }

    // een gebruiker is gekoppelt aan meerdere tarieven
    // via vreemde sleutel kloppelen aan "tarief" model of class
    public function tarief()
    {
        return $this->hasMany( Tarief::class );
    }

    // een gebruiker is gekoppelt aan meerdere bedrijven
    // via vreemde sleutel kloppelen aan "bedrijven" model of class
    public function bedrijven()
    {
        return $this->hasMany(Bedrijf::class );
    }

    // een gebruiker is gekoppelt aan 1 brouwerscontact
    // via vreemde sleutel kloppelen aan "brouwerscontact" model of class
    public function brouwerscontact()
    {
        return $this->hasOne(Brouwerscontact::class );
    }

    // een gebruiker is gekoppelt aan meerdere facturen
    // via vreemde sleutel kloppelen aan "factuur" model of class
    public function factuur()
    {
        return $this->hasOne(Factuur::class );
    }
}
