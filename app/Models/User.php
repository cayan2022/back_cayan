<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Resources\UserResource;
 use Illuminate\Support\Facades\Hash;

/**
 * User Class
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     *
     */
    public const ADMIN = 'admin';

    /**
     *
     */
    public const MODERATOR = 'moderator';

    /**
     *
     */
    public const MALE = 'male';

    /**
     *
     */
    public const FEMALE = 'female';

    /**
     *
     */
    public const TYPES = [
        self::ADMIN,
        self::MODERATOR,
    ];

    /**
     *
     */
    public const GENDERS = [
        self::MALE,
        self::FEMALE,
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'type', 'phone' , 'gender', 'password', 'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->type = self::MODERATOR;
            $user->is_active = true;
        });
    }

    /*Mutators*/
    /**
     * @param $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /*Helpers*/
    /**
     * @return UserResource
     */
    public function getResource(): UserResource
    {
        return new UserResource($this);
    }
    /**
     * Get the access token currently associated with the user. Create a new.
     *
     * @param  string|null  $device
     * @return string
     */
    public function createTokenForDevice(string $device = null): string
    {
        $device = $device ?: 'Unknown Device';

        $this->tokens()->where('name', $device)->delete();

        return $this->createToken($device)->plainTextToken;
    }

    public function isAdmin(): bool
    {
        return $this->type===self::ADMIN;
    }

    public function isModerator(): bool
    {
        return $this->type===self::MODERATOR;
    }
    /*Relations*/

    /**
     * @return HasMany
     */
    public function orderHistories(): HasMany
    {
        return $this->hasMany(OrderHistory::class);
    }

}
