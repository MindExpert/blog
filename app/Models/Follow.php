<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Follow
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $followed_user_id
 * @property User $userDoingTheFollowing
 * @property User $userBeingFollowed
 */
class Follow extends Model
{
    protected $fillable = [
        'user_id',
        'followed_user_id',
    ];

    public function userDoingTheFollowing(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userBeingFollowed(): BelongsTo
    {
        return $this->belongsTo(User::class, 'followed_user_id');
    }

}
