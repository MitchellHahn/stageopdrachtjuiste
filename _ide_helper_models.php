<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Bedrijf
 *
 * @property int $id
 * @property string $bedrijfsnaam
 * @property int $debnummer
 * @property string $straat
 * @property int $huisnummer
 * @property string $toevoeging
 * @property string $postcode
 * @property string $stad
 * @property string $land
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $email
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Factuur[] $facturen
 * @property-read int|null $facturen_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tijd[] $tijden
 * @property-read int|null $tijden_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Toeslag[] $toeslag
 * @property-read int|null $toeslag_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereBedrijfsnaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereDebnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereHuisnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereLand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereStad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereStraat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereToevoeging($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bedrijf whereUserId($value)
 */
	class Bedrijf extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Brouwerscontact
 *
 * @property int $id
 * @property int $user_id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Brouwerscontact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brouwerscontact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brouwerscontact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brouwerscontact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brouwerscontact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brouwerscontact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brouwerscontact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brouwerscontact whereUserId($value)
 */
	class Brouwerscontact extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Factuur
 *
 * @property int $id
 * @property int $bedrijf_id
 * @property string $naam
 * @property \Illuminate\Support\Carbon|null $startdatum
 * @property \Illuminate\Support\Carbon|null $einddatum
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bedrijf $bedrijf
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Factuur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Factuur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Factuur query()
 * @method static \Illuminate\Database\Eloquent\Builder|Factuur whereBedrijfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Factuur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Factuur whereEinddatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Factuur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Factuur whereNaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Factuur whereStartdatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Factuur whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Factuur whereUserId($value)
 */
	class Factuur extends \Eloquent {}
}

namespace App\Models{
/**
 * model voor elementen van navbar ZZPer/user
 *
 * @property int $id
 * @property string $name
 * @property string $route
 * @property int $ordering
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_type
 * @method static \Illuminate\Database\Eloquent\Builder|Navbar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Navbar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Navbar query()
 * @method static \Illuminate\Database\Eloquent\Builder|Navbar whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Navbar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Navbar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Navbar whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Navbar whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Navbar whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Navbar whereUpdatedAt($value)
 */
	class Navbar extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tarief
 *
 * @property int $id
 * @property string $bedrag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tijd[] $tijden
 * @property-read int|null $tijden_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Toeslag[] $toeslagen
 * @property-read int|null $toeslagen_count
 * @property-read \App\Models\User|null $users
 * @method static \Illuminate\Database\Eloquent\Builder|Tarief newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tarief newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tarief query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tarief whereBedrag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tarief whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tarief whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tarief whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tarief whereUserId($value)
 */
	class Tarief extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tijd
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $datum
 * @property string|null $begintijd
 * @property string|null $eindtijd
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $toeslag_id
 * @property int|null $bedrijf_id
 * @property-read \App\Models\Bedrijf|null $bedrijf
 * @property-read \App\Models\Tarief|null $tarief
 * @property-read \App\Models\Toeslag|null $toeslag
 * @property-read \App\Models\User|null $users
 * @method static \Illuminate\Database\Eloquent\Builder|Tijd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tijd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tijd query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tijd whereBedrijfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tijd whereBegintijd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tijd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tijd whereDatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tijd whereEindtijd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tijd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tijd whereToeslagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tijd whereUpdatedAt($value)
 */
	class Tijd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Toeslag
 *
 * @property int $id
 * @property string $datum
 * @property string|null $toeslagbegintijd
 * @property string|null $toeslageindtijd
 * @property string|null $toeslagsoort
 * @property int|null $toeslagpercentage
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $tarief_id
 * @property-read \App\Models\Bedrijf|null $bedrijf
 * @property-read \App\Models\Tarief|null $tarief
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tijd[] $tijden
 * @property-read int|null $tijden_count
 * @property-read \App\Models\User|null $users
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag whereDatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag whereTariefId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag whereToeslagbegintijd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag whereToeslageindtijd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag whereToeslagpercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag whereToeslagsoort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Toeslag whereUserId($value)
 */
	class Toeslag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $account_type
 * @property string|null $achternaam
 * @property string|null $straat
 * @property int|null $huisnummer
 * @property string|null $toevoeging
 * @property string|null $postcode
 * @property string|null $stad
 * @property string|null $land
 * @property string|null $telefoonnumer
 * @property string|null $tussenvoegsel
 * @property int|null $kvknummer
 * @property string|null $btwnummer
 * @property string|null $logo
 * @property string|null $ibannummer
 * @property string|null $bedrijfsnaam
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bedrijf[] $bedrijven
 * @property-read int|null $bedrijven_count
 * @property-read \App\Models\Brouwerscontact|null $brouwerscontact
 * @property-read \App\Models\Factuur|null $factuur
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tarief[] $tarief
 * @property-read int|null $tarief_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tijd[] $tijden
 * @property-read int|null $tijden_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Toeslag[] $toeslagen
 * @property-read int|null $toeslagen_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAchternaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBedrijfsnaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBtwnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHuisnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIbannummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereKvknummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStraat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTelefoonnumer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereToevoeging($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTussenvoegsel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserProfiel
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $account_type
 * @property string|null $achternaam
 * @property string|null $straat
 * @property int|null $huisnummer
 * @property string|null $toevoeging
 * @property string|null $postcode
 * @property string|null $stad
 * @property string|null $land
 * @property string|null $telefoonnumer
 * @property string|null $tussenvoegsel
 * @property int|null $kvknummer
 * @property string|null $btwnummer
 * @property string|null $logo
 * @property string|null $ibannummer
 * @property string|null $bedrijfsnaam
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bedrijf[] $bedrijven
 * @property-read int|null $bedrijven_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tijd[] $tijden
 * @property-read int|null $tijden_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Toeslag[] $toeslag
 * @property-read int|null $toeslag_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereAchternaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereBedrijfsnaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereBtwnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereHuisnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereIbannummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereKvknummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereLand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereStad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereStraat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereTelefoonnumer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereToevoeging($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereTussenvoegsel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfiel whereUpdatedAt($value)
 */
	class UserProfiel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\logo
 *
 * @property string|null $blogo
 * @method static \Illuminate\Database\Eloquent\Builder|logo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|logo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|logo query()
 * @method static \Illuminate\Database\Eloquent\Builder|logo whereBlogo($value)
 */
	class logo extends \Eloquent {}
}

