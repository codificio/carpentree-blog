<?php

namespace Carpentree\Blog\Models;

use Carpentree\Core\Models\Category\Translation;
use Carpentree\Core\Traits\Categorizable;
use Carpentree\Core\Traits\HasMeta;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carpentree\Core\Scout\Searchable;
use Plank\Mediable\Mediable;

class Article extends Model
{
    use Translatable, Categorizable, HasMeta, SoftDeletes, Searchable, Mediable;

    public $translationModel = Translation::class;

    protected $fillable = [
        'status'
    ];

    public $translatedAttributes = [
        'slug',
        'title',
        'body',
        'excerpt'
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

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = [
            'title' => $this->title,
            'body' => Str::limit(strip_tags($this->body), 200),
            'excerpt' => Str::limit(strip_tags($this->excerpt), 200),
            'meta' => $this->meta->pluck('value'),
            'categories' => $this->categories->pluck('name')
        ];

        return $array;
    }

}
