<?php

namespace App\Models;

use App\Models\Vote;
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

    protected $fillable = ['title', 'excerpt', 'thumbnail', 'author_id', 'slug', 'body', 'created_at'];
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

    public function scopeFilter($query, array $filters)
    {
        // Filter berdasarkan pencarian judul
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        // Filter berdasarkan kategori
        if (!empty($filters['category'])) {
            $query->whereHas('categories', function ($query) use ($filters) {
                $query->where('slug', $filters['category']);
            });
        }

        // Filter berdasarkan penulis
        if (!empty($filters['author'])) {
            $query->whereHas('author', function ($query) use ($filters) {
                $query->where('username', $filters['author']);
            });
        }
    }


    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function upvotes()
    {
        return $this->votes()->where('vote', 'up')->count();
    }

    public function downvotes()
    {
        return $this->votes()->where('vote', 'down')->count();
    }




}
