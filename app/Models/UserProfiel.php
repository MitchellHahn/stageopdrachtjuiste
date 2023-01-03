<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfiel extends Model
//word gebruikt door admin en user controller
{
    use HasFactory;
    protected $table = 'users';

    protected $fillable = [
        //table tijd
        'name', 'tussenvoegsel', 'achternaam', 'email', 'telefoonnumer', 'straat', 'huisnummer', 'toevoeging', 'postcode', 'stad', 'land', 'password', "kvknummer", "btwnummer", "logo", 'ibannummer', 'bedrijfsnaam',
    ];
    public function toeslag()
    {
        return $this->hasMany( related: Toeslag::class);
    }

    public function tijden()
    {
        return $this->hasManyThrough( related: Tijd::class, through: Toeslag::class );
    }

    public function bedrijven()
    {
        return $this->hasMany(Bedrijf::class );
    }
}
