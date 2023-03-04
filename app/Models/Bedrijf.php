<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Toeslag;


class Bedrijf extends Model
{
    use HasFactory;

    // gebruikt tabel bedrijven van de databse
    protected $table = 'bedrijven';

    // de kolomen dat van tabel ""bedrijven worden gebruikt
    protected $fillable = [
        //table tijd
        'bedrijfsnaam', 'debnummer', 'straat', 'huisnummer', 'toevoeging', 'postcode', 'stad', 'land', 'land', 'email', 'contactpersoon'
    ];

    // een bedrijf is gekoppelt meerder tijden (gewerktedagen) (uren)
    // via vreemde sleutel kloppelen aan "tijd" model of class
    public function tijden()
    {
        return $this->hasMany(Tijd::class );
    }

    // een bedrijf is gekoppelt aan meerdere toeslagen
    // via vreemde sleutel van "tijd" kloppelen aan "toeslag" model of class
    public function toeslag()
    {
    return $this->hasManyThrough(Toeslag::class, through: Tijd::class);
    }

    // een bedrijf is gekoppelt 1 gebruiker
    // via vreemde sleutel kloppelen aan "user" model of class
    public function user()
    {
        return $this->belongsTo(User::class );
    }

    // een bedrijf is gekoppelt meerdere facturen
    // via vreemde sleutel kloppelen aan "factuur" model of class
    public function facturen()
    {
        return $this->hasMany(Factuur::class );
    }
}
