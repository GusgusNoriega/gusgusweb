<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use SoftDeletes;

    public const SITEMAP_CHUNKS_CACHE_KEY = 'seo:sitemap:blog-post-chunks:v1';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_id',
        'meta_title',
        'meta_description',
        'canonical_url',
        'is_published',
        'published_at',
        'is_featured',
        'view_count',
        'reading_time',
        'author_id',
        'source',
        'no_index',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'no_index' => 'boolean',
        'published_at' => 'datetime',
        'view_count' => 'integer',
        'reading_time' => 'integer',
    ];

    protected static function booted(): void
    {
        $forgetSitemapCache = static function (): void {
            Cache::forget(self::SITEMAP_CHUNKS_CACHE_KEY);
        };

        static::saved($forgetSitemapCache);
        static::deleted($forgetSitemapCache);
        static::restored($forgetSitemapCache);
        static::forceDeleted($forgetSitemapCache);
    }

    /**
     * Relación con la imagen destacada (1:1 con media_assets)
     */
    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'featured_image_id');
    }

    /**
     * Relación con el autor (1:N con users)
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Relación con categorías (N:N)
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_category_post', 'blog_post_id', 'blog_category_id')
            ->withTimestamps();
    }

    /**
     * Scope para posts publicados
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope para posts destacados
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope para posts que se pueden indexar
     */
    public function scopeIndexable($query)
    {
        return $query->published()
            ->where('no_index', false);
    }

    /**
     * Scope para ordenar por fecha de publicación
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Obtener los nombres de las categorías como array
     */
    public function getCategoryNamesAttribute(): array
    {
        return $this->categories->pluck('name')->toArray();
    }
}
