<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Toeslag;


class Tijd extends Model
{
    use HasFactory;

    protected $table = 'tijden';

    protected $fillable = [
        //table tijd
        'datum', 'begintijd', 'eindtijd', 'toeslag_idavond', 'toeslag_idnacht', 'toeslag_idavond', 'bedrijf_id', 'tarief_id',
    ];

    protected $casts = [
        'datum' => 'date:Y-m-d',
    ];

//    public function bedrijf()
//    {
//        return $this->belongsTo(Bedrijf::class );
//    }

    public function toeslag()
    {
    return $this->belongsToMany(Toeslag::class );
    }

    public function toeslagochtend()
    {
    return $this->belongsTo(Toeslag::class, 'toeslag_idochtend');
    }

    public function toeslagavond()
    {
    return $this->belongsTo(Toeslag::class, 'toeslag_idavond');
    }

    public function toeslagnacht()
    {
    return $this->belongsTo(Toeslag::class, 'toeslag_idnacht');
    }


    public function tarief()
    {
    return $this->hasOneThrough(Tarief::class, Toeslag::class );
    }

    public function users()
    {
    return $this->hasOneThrough( related: User::class, through: Toeslag::class );
    }

    public function bedrijf()
    {
        return $this->belongsTo(Bedrijf::class );
    }
}
