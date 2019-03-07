<?php

namespace Carpentree\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'attributes.slug' => 'required|string',
            'attributes.title' => 'required|string',
            'attributes.body' => 'nullable|string',
            'attributes.excerpt' => 'nullable|string',
            'attributes.status' => 'required|string',

            // Categories
            'relationships.categories.data' => 'array',
            'relationships.categories.data.*.id' => 'exists:categories,id',

            // Meta fields
            'relationships.meta.data' => 'array',
            'relationships.meta.data.*.attributes.key' => 'string',
            'relationships.meta.data.*.attributes.value' => 'required_with:relationships.meta.data.*.attributes.key|string',

            // Media
            'relationships.media.data' => 'array',
            'relationships.media.data.*.id' => 'integer',
            'relationships.media.data.*.meta.tag' => 'string',
            'relationships.media.data.*.meta.order' => 'integer'
        ];
    }
}
