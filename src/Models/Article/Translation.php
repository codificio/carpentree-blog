<?php

namespace Carpentree\Blog\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    public $timestamps = false;

    protected $table = 'article_translations';

    protected $fillable = [
        'slug',
        'title',
        'body',
        'excerpt'
    ];

}
