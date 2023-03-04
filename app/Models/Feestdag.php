<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Feestdag extends Model
{
    use HasFactory;

    // gebruikt tabel feestdagen van de databse
    protected $table = 'feestdagen';

    // de kolomen dat van tabel "feestdagen" worden gebruikt
    protected $fillable = [
        'datum', 'naam'
    ];

}
