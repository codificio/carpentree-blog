<?php

namespace Carpentree\Blog\Models;

use Carpentree\Core\Models\Category\Translation;
use Carpentree\Core\Traits\Categorizable;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Article extends Model implements HasMedia
{
    use Translatable, Categorizable, HasMediaTrait;

    public $translationModel = Translation::class;

    public $translatedAttributes = [
        'slug',
        'title',
        'body',
        'excerpt'
    ];
}
