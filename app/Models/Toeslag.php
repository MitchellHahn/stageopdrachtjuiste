<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toeslag extends Model
{
    use HasFactory;

    // gebruikt tabel toeslagen van de databse
    protected $table = 'toeslagen';

    // de kolomen dat van tabel "toeslagen" worden gebruikt
    protected $fillable = [
        'datum', 'toeslagbegintijd', 'toeslageindtijd', 'toeslagsoort', 'toeslagpercentage', 'tarief_id', 'user_id', 'soort',// 'tijd_id',

    ];

    // een Toeslag is gekoppelt meerdere tijden (gewerktedagen) (uren)
    // via vreemde sleutel kloppelen aan "tijd" model of class
    public function tijden()
    {
        return $this->hasMany(Tijd::class );
    }

    // een Toeslag is gekoppelt 1 gebruiker
    // via vreemde sleutel kloppelen aan "user" model of class
    public function users()
    {
        return $this->belongsTo( related: User::class);
    }

    // een Toeslag is gekoppelt 1 bedrijf (klant)
    // via vreemde sleutel "tijd" kloppelen aan "Bedrijf" model of class
    public function bedrijf()
    {
        return $this->hasOneThrough( related: Bedrijf::class, through: Tijd::class);
    }

}
