<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logo extends Model


{
    use HasFactory;

    // gebruikt tabel logo van de databse
    protected $table = 'logo';

    // de kolomen dat van tabel "logo" worden gebruikt
    protected $fillable = [
        'blogo',

    ];
}
