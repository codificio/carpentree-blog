<?php

namespace Carpentree\Blog\Http\Resources;

use Carpentree\Core\Http\Resources\MediaResource;
use Carpentree\Core\Http\Resources\Relationships\CategoryResourceRelationship;
use Carpentree\Core\Http\Resources\Relationships\MetaResourceRelationship;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

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
            // Article field
            'type' => 'articles',
            'id' => $this->id,
            'locale' => App::getLocale(),

            'attributes' => [
                'slug' => $this->slug,
                'title' => $this->title,
                'body' => $this->body,
                'excerpt' => $this->excerpt,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],

            'relationships' => [

                'categories' => [
                    'data' => $this->whenLoaded('categories', CategoryResourceRelationship::collection($this->categories), array())
                ],

                'meta' => [
                    'data' => $this->whenLoaded('meta', MetaResourceRelationship::collection($this->meta), array())
                ],

                'media' => [
                    'data' => $this->whenLoaded('media', MediaResource::collection($this->media), array())
                ]

            ],

        ];
    }

}
