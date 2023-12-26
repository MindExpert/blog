<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int          $id
 * @property string       $username
 * @property string       $avatar
 * @property string       $email
 * @property string       $mobile
 * @property string       $password
 * @property boolean      $is_admin
 * @property string|null  $remember_token
 * @property Carbon|null  $email_verified_at
 * @property Carbon|null  $created_at
 * @property Carbon|null  $updated_at
 * @property Carbon|null  $deleted_at
 * # Accessors
 * @property array        $toSearchableArray
 * # Relations
 * @property User                $user
 * @property Collection|Post[]   $posts
 * @property Collection|Post[]   $feedPosts
 * @property Collection|Follow[] $followers
 * @property Collection|Follow[] $following_users
 *
// * @mixin UserQueryBuilder
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

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
        'password'          => 'hashed',
        'is_admin'          => 'boolean',
    ];

    protected function avatar(): Attribute {
        return Attribute::make(get: function($value) {
            return $value ? '/storage/avatars/' . $value : '/fallback-avatar.jpg';
        });
    }

    public function feedPosts(): HasManyThrough
    {
        return $this->hasManyThrough(
            Post::class,
            Follow::class,
            'user_id',
            'user_id',
            'id',
            'followed_user_id'
        );
    }

    public function followers(): HasMany
    {
        return $this->hasMany(Follow::class, 'followed_user_id', 'id');
    }

    public function following_users(): HasMany
    {
        return $this->hasMany(Follow::class, 'user_id', 'id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }
}
