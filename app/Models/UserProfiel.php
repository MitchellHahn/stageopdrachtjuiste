<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfiel extends Model
//word gebruikt in admin en user controller
{
    use HasFactory;

    // gebruikt tabel users van de databse
    protected $table = 'users';

    // de kolomen dat van tabel users worden gebruikt
    protected $fillable = [
        'name', 'tussenvoegsel', 'achternaam', 'email', 'telefoonnumer', 'straat', 'huisnummer', 'toevoeging', 'postcode', 'stad', 'land', 'password', "kvknummer", "btwnummer", "logo", 'ibannummer', 'bedrijfsnaam',
    ];

    // een gebruiker is gekoppelt aan meerdere toeslagen
    // via vreemde sleutel kloppelen aan "toeslag" model of class
    public function toeslag()
    {
        return $this->hasMany( related: Toeslag::class);
    }

    // een gebruiker is gekoppelt aan meerdere bedrijven
    // via vreemde sleutel kloppelen aan "bedrijf" model of class
    public function bedrijven()
    {
        return $this->hasMany(Bedrijf::class );
    }
}
