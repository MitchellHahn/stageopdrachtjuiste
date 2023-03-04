<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Brouwerscontact extends Model
{
    use HasFactory;

    // gebruikt tabel brouwerscontacten van de databse
    protected $table = 'brouwerscontacten';

    // de kolomen dat van tabel "brouwerscontacten" worden gebruikt
    protected $fillable = [
        'email'
    ];

    // een brouwerscontact is gekoppelt 1 gebruiker
    // via vreemde sleutel kloppelen aan "User" model of class
    public function user()
    {
        return $this->belongsTo(User::class );
    }
}
