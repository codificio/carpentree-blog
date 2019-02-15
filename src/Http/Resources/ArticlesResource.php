<?php

namespace Carpentree\Blog\Http\Resources;

use Carpentree\Core\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'body' => $this->body,
            'excerpt' => $this->excerpt,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Categories
            'categories' => CategoryResource::collection($this->resource->categories)
        ];
    }

}
