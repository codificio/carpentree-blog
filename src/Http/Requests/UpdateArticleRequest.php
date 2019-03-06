<?php

namespace Carpentree\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:articles',

            'attributes.slug' => 'string|filled',
            'attributes.title' => 'string|filled',
            'attributes.body' => 'string|filled',
            'attributes.excerpt' => 'string|filled',
            'attributes.status' => 'required|string',

            // Categories: Multiple relation
            'relationships.categories.data' => 'array',
            'relationships.categories.data.*.id' => 'exists:categories,id',

            // Meta fields
            'relationships.meta.data' => 'array',
            'relationships.meta.data.*.attributes.key' => 'string',
            'relationships.meta.data.*.attributes.value' => 'required_with:relationships.meta.data.*.attributes.key|string'
        ];
    }
}
