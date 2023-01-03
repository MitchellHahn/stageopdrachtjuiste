<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Lab404\Impersonate\Models\Impersonate;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Impersonate;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'tussenvoegsel', 'achternaam', 'email', 'telefoonnumer', 'straat', 'huisnummer', 'toevoeging', 'postcode', 'stad', 'land', 'password', 'account_type', 'kvknummer', 'btwnummer', 'ibannummer', 'bedrijfsnaam',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',

    ];

    public function getLastName(): ?string {
        $nameLast = $this->achternaam;

        if($this->tussenvoegsel) {
            return $this->tussenvoegsel.' '.$nameLast;
        }

        return $nameLast;
    }

    public function toeslagen()
    {
        return $this->hasMany( related: Toeslag::class);
    }

    public function tijden()
    {
        return $this->hasManyThrough( related: Tijd::class, through: Toeslag::class );
    }

//    public function tarief()
//    {
//        return $this->hasManyThrough( Tarief::class, Toeslag::class );
//    }

    public function tarief()
    {
        return $this->hasMany( Tarief::class );
    }


    public function bedrijven()
    {
        return $this->hasMany(Bedrijf::class );
    }

    public function brouwerscontact()
    {
        return $this->hasOne(Brouwerscontact::class );
    }

    public function factuur()
    {
        return $this->hasOne(Factuur::class );
    }
}
