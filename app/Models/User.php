<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property string|null $anonyme_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $santa_id
 * @property string|null $last_santa_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\SantaRestriction|null $lastSanta
 * @property-read \App\Models\SantaRestriction|null $lastTarget
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $oldSantas
 * @property-read int|null $old_santas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $oldTargets
 * @property-read int|null $old_targets_count
 * @property-read string $profile_photo_url
 * @property-read User|null $santa
 * @property-read User|null $target
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAnonymeToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastSantaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSantaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'anonyme_token',
        'santa_id',
        'last_santa_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'responses',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function santa()
    {
        return $this->belongsTo(User::class, 'santa_id');
    }

    public function target()
    {
        return $this->hasOne(User::class, 'santa_id');
    }

    public function oldTargets()
    {
        return $this->hasManyThrough(
            User::class,
            SantaRestriction::class,
            'santa_id',
            'id',
            'id',
            'user_id');
    }

    public function oldSantas()
    {
        return $this->hasManyThrough(
            User::class,
            SantaRestriction::class,
            'user_id',
            'id',
            'id',
            'santa_id');
    }

    // Méthode pour récupérer la dernière Target d'un utilisateur (sans boucle infinie)
    public function lastTarget()
    {
        return $this->hasOne(SantaRestriction::class, 'santa_id')
                    ->latestOfMany()
                    ->with('target');
    }

    // Méthode pour récupérer le dernier Santa d'un utilisateur (sans boucle infinie)
    public function lastSanta()
    {
        return $this->hasOne(SantaRestriction::class, 'user_id')
                    ->latestOfMany()
                    ->with('santa');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot('response')->withTimestamps();
    }

    public function responses(): Attribute
    {
        return new Attribute(
            fn() => $this->questions->map(
                fn($question) => [
                    'id' => $question->id,
                    'question' => $question->question,
                    'response' => $question->pivot->response
                ]
            )
        );
    }
}
