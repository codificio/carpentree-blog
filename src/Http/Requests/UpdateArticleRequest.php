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

            // Categories: Multiple relation
            'relationships.categories.*.id' => 'exists:categories,id',

            // Status: Single relation
            'relationships.status.name' => 'string|filled',
        ];
    }
}
