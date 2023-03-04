<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Toeslag;


class Tijd extends Model
{
    use HasFactory;

    // gebruikt tabel tijden van de databse
    protected $table = 'tijden';

    // de kolomen dat van tabel tijden worden gebruikt
    protected $fillable = [
        'datum', 'begintijd', 'eindtijd', 'toeslag_idavond', 'toeslag_idnacht', 'toeslag_idavond', 'bedrijf_id', 'tarief_id', 'user_id'
    ];

    // datum in een bepaalde formaat tonen
    protected $casts = [
        'datum' => 'date:Y-m-d',
    ];

    // een Tijd (dag) is gekoppelt aan meerdere toeslagen
    // via vreemde sleutel kloppelen aan "toeslag" model of class
    public function toeslag()
    {
    return $this->belongsToMany(Toeslag::class );
    }

    // een Tijd (dag) is gekoppelt aan 1 ochtend toeslag
    // via vreemde sleutel "toeslag_idochtend" kloppelen aan "toeslag" model of class
    public function toeslagochtend()
    {
    return $this->belongsTo(Toeslag::class, 'toeslag_idochtend');
    }

    // een Tijd (dag) is gekoppelt aan 1 avond toeslag
    // via vreemde sleutel "toeslag_idavond" kloppelen aan "toeslag" model of class
    public function toeslagavond()
    {
    return $this->belongsTo(Toeslag::class, 'toeslag_idavond');
    }

    // een Tijd (dag) is gekoppelt aan 1 nacht toeslag
    // via vreemde sleutel "toeslag_idnacht" kloppelen aan "toeslag" model of class
    public function toeslagnacht()
    {
    return $this->belongsTo(Toeslag::class, 'toeslag_idnacht');
    }

    // een Tijd (dag) is gekoppelt aan 1 tarief
    // via vreemde sleutel koppelen aan "tarief" model of class
    public function tarief()
    {
    return $this->hasOne(Tarief::class);
    }

    // een Tijd (dag) is gekoppelt aan 1 gebruiker
    // via vreemde sleutel koppelen aan "user" model of class
    public function user()
    {
        return $this->belongsTo(User::class );
    }

    // een Tijd (dag) is gekoppelt aan 1 bedrijf
    // via vreemde sleutel koppelen aan "bedrijf" model of class
    public function bedrijf()
    {
        return $this->belongsTo(Bedrijf::class );
    }
}
