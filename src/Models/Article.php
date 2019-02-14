<?php

namespace Carpentree\Blog\Models;

use Carpentree\Core\Models\Category\Translation;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Translatable;

    public $translationModel = Translation::class;

    public $translatedAttributes = [
        'slug',
        'title',
        'body',
        'excerpt'
    ];
}
