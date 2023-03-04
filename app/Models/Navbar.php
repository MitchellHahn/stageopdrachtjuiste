<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
    /**
     * model voor elementen van navbar
     */
{

    use HasFactory;

    protected $fillable = [
        'name', 'route', 'ordering'
    ];
}

