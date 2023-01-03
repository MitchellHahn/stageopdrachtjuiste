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
        'datum', 'begintijd', 'eindtijd', 'toeslag_id', 'bedrijf_id',
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
    return $this->belongsTo(Toeslag::class );
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
