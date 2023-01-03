<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Brouwerscontact extends Model
{
    use HasFactory;

    protected $table = 'brouwerscontacten';

    protected $fillable = [
        //table tijd
        'email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class );
//        return $this->hasOne(User::class );
    }
}
