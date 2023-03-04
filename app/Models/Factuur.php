<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Toeslag;


class Factuur extends Model
{
    use HasFactory;

    // gebruikt tabel facturen van de databse
    protected $table = 'facturen';

    // de kolomen dat van tabel "facturen" worden gebruikt
    protected $fillable = [
        'bedrijf_id', 'naam', 'startdatum', 'einddatum',
    ];

    // data van tabel facturen wordt getoont in een bepaalde formaat
    protected $casts = [
        'startdatum' => 'date:Y-m-d',
        'einddatum' => 'date:Y-m-d',
    ];

    // een factuur is gekoppelt 1 gebruiker
    // via vreemde sleutel kloppelen aan "User" model of class
    public function user()
    {
        return $this->belongsTo(User::class );
    }

    // een factuur is gekoppelt 1 bedrijf
    // via vreemde sleutel kloppelen aan "Bedrijf" model of class
    public function bedrijf()
    {
        return $this->belongsTo(Bedrijf::class );
    }
}
