<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'is_public',
        'published_at',
    ];

    protected $casts = [
        'is_public' => 'bool',
        'published_at' => 'datetime',
    ];

    // 記事公開のみ表示
    public function scopePublic(Builder $query)
    {
        return $query->where('is_public', true);
    }

    // 記事一覧習得
    public function scopePublicList(Builder $query, string $tagSlug = null)
    {
        if ($tagSlug) {
            $query->whereHas('tags', function ($query) use ($tagSlug) {
                $query->where('slug', $tagSlug);
            });
        }
        return $query
            ->with('tags')
            ->public()
            ->latest('published_at')
            ->paginate(10);
    }

    // 記事をIDで習得
    public function scopePublicFindById(Builder $query, Int $id)
    {
        return $query
            ->public()
            ->findOrFail($id);
    }

    // 公開日を年月日
    public function getPublishedFormatAttribute()
    {
        return $this->published_at->format('y年m月d日');
    }

    /**
     *
     * @return void
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    protected static function boot()
    {
        parent::boot();

        self::saving(function ($post) {
            $post->user_id = \Auth::id();
        });
    }
}
