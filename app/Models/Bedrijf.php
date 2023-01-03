<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Toeslag;


class Bedrijf extends Model
{
    use HasFactory;

    protected $table = 'bedrijven';

    protected $fillable = [
        //table tijd
        'bedrijfsnaam', 'debnummer', 'straat', 'huisnummer', 'toevoeging', 'postcode', 'stad', 'land', 'land', 'email', 'contactpersoon'
    ];

    public function tijden()
    {
        return $this->hasMany(Tijd::class );
    }

    public function toeslag()
    {
    return $this->hasManyThrough(Toeslag::class, through: Tijd::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class );
    }

    public function facturen()
    {
        return $this->hasMany(Factuur::class );
    }
}
