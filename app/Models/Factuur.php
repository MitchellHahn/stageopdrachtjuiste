<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Toeslag;


class Factuur extends Model
{
    use HasFactory;

    protected $table = 'facturen';

    protected $fillable = [
        //table facturen
        'bedrijf_id', 'naam', 'startdatum', 'einddatum',
    ];

    protected $casts = [
//        'startdatum' => 'datetime:Y-m-d',
        'startdatum' => 'date:Y-m-d',
//        'einddatum' => 'datetime:Y-m-d',
        'einddatum' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class );
    }

    public function bedrijf()
    {
        return $this->belongsTo(Bedrijf::class );
    }
}
