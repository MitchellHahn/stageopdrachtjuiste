<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toeslag extends Model
{
    use HasFactory;

    protected $table = 'toeslagen';

    protected $fillable = [
        //table toeslag
        'datum', 'toeslagbegintijd', 'toeslageindtijd', 'toeslagsoort', 'toeslagpercentage', 'tarief_id', 'user_id', 'soort',// 'tijd_id',

    ];

    public function tijden()
    {
        return $this->hasMany(Tijd::class, );
    }

    public function users()
    {
        return $this->belongsTo( related: User::class);
    }

    public function tarief()
    {
        return $this->belongsTo(Tarief::class);
    }

    public function bedrijf()
    {
        return $this->hasOneThrough( related: Bedrijf::class, through: Tijd::class);
    }

}
