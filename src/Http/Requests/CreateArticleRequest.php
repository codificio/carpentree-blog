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

            // Categories: Multiple relation
            'relationships.categories.*.id' => 'exists:categories,id',

            // Status: Single relation
            'relationships.status.name' => 'string|filled',
            
        ];
    }
}
