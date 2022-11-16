<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "post.name" => [
                'nullable',
                "unique:posts,name",
            ],
            "post.slug" => [
                'nullable',
            ],
            "post.content" => [
                'nullable',
            ],
            "post.description" => [
                'nullable',
            ],
            "post.meta_title" => [
                'nullable',
            ],
            "post.meta_description" => [
                'nullable',
            ],
            "post.meta_keywords" => [
                'nullable',
            ],
            "post.publish_at" => [
                'nullable',
            ],
            "post.is_authenticated" => [
                'nullable',
                'boolean',
            ],
            "categories" => [
                'nullable',
                'array',
            ],
            "categories.*" => [
                'integer'
            ],
            "tags" => [
                'nullable',
                'array',
            ],
            "tags.*" => [
                'integer'
            ],
            "image" => [
                'nullable',
                'image',
            ],

        ];
    }
}
