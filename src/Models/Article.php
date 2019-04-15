<?php

namespace Carpentree\Blog\Models;

use Carpentree\Blog\Models\Article\Translation;
use Carpentree\Core\Scout\Searchable;
use Carpentree\Core\Traits\Categorizable;
use Carpentree\Core\Traits\HasMeta;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
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
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = [
            'id' => $this->id, // TNTSearch needs id
            'title' => $this->title,
            'body' => Str::limit(strip_tags($this->body), 200),
            'excerpt' => Str::limit(strip_tags($this->excerpt), 200),
            'meta' => $this->meta->pluck('value'),
            'categories' => $this->categories->pluck('name')
        ];

        return $array;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

}
