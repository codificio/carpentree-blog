<?php

namespace Carpentree\Blog\Models;

use Carpentree\Core\Models\Category\Translation;
use Carpentree\Core\Traits\Categorizable;
use Carpentree\Core\Traits\HasMeta;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carpentree\Core\Scout\Searchable;

class Article extends Model implements HasMedia
{
    use Translatable, Categorizable, HasMediaTrait, HasMeta, SoftDeletes, Searchable;

    public $translationModel = Translation::class;

    public $translatedAttributes = [
        'slug',
        'title',
        'body',
        'excerpt',
        'status'
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'articles_index';
    }

    /**
     * Return true if you want to store this model in localized index.
     *
     * @return bool
     */
    public static function localizedSearchable()
    {
        return true;
    }

}
