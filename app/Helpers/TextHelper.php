<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class TextHelper
{
    public static function limitBodyContent($posts, $limit = 50)
    {
        return $posts->map(function ($post) use ($limit) {
            $post->body = Str::limit($post->body, $limit, '...');
            return $post;
        });
    }
}
