<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarief extends Model
{
    use HasFactory;

    // gebruikt tabel tarieven van de databse
    protected $table = 'tarieven';

    // de kolomen dat van tabel "tarieven" worden gebruikt
    protected $fillable = [
        'bedrag', 'user_id',

    ];

    // een Tarief is gekoppelt 1 gebruiker
    // via vreemde sleutel kloppelen aan "user" model of class
      public function users()
    {
        return $this->hasOne(User::class );
    }

}
