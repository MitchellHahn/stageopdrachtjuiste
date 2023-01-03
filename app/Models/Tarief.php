<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarief extends Model
{
    use HasFactory;

    protected $table = 'tarieven';

    protected $fillable = [
        //table toeslag
        'bedrag', 'user_id',

    ];


    public function toeslagen()
    {
        return $this->hasMany(Toeslag::class );
    }

    public function tijden()
    {
        return $this->hasManyThrough(Tijd::class,Toeslag::class );
    }

//    public function users()
//    {
//        return $this->hasOneThrough(User::class,Toeslag::class );
//    }

    public function users()
    {
        return $this->hasOne(User::class );
    }

}
