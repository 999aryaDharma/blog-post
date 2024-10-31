<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Post extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['title', 'excerpt', 'thumbnail', 'author_id', 'slug', 'body'];
    protected $with = ['author', 'categories'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories(): BelongsToMany
    {
         return $this->belongsToMany(Category::class, 'category_post', 'post_id', 'category_id')->withTimestamps();
    }


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function scopeFilter(Builder $query, array $filters): void {

        $query->when($filters['search'] ?? false, 
            fn ($query, $search) =>
            $query->where('title', 'like', '%' . $search . '%')
        );

        $query->when($filters['category'] ?? false, 
            fn ($query, $category) =>
            $query->whereHas('categories', 
                fn ($query) =>
                $query->where('name', $category)
            )
        );

        $query->when($filters['author'] ?? false, 
            fn ($query, $author) =>
            $query->whereHas('author', 
                fn ($query) =>
                $query->where('username', $author)
            )
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }



}
