<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int          $id
 * @property int          $user_id
 * @property string       $title
 * @property string       $body
 * @property Carbon|null  $created_at
 * @property Carbon|null  $updated_at
 * @property Carbon|null  $deleted_at
 * # Accessors
 * @property array        $toSearchableArray
 * # Relations
 * @property User         $user
 *
// * @mixin PostQueryBuilder
 */
class Post extends Model
{
    use Searchable;

    protected $guarded = ['id'];

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('postCount');
        });

        static::deleted(function () {
            Cache::forget('postCount');
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'body'  => $this->body
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
