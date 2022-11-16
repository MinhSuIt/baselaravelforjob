<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            "name" => [
                'nullable',
                // 'unique:table,column,except,idColumn'
                "unique:categories,name",
            ],
            "position" => [
                'nullable',
                'integer',
            ],
            "slug" => [
                'nullable',
            ],
            "description" => [
                'nullable',
            ],
            "meta_title" => [
                'nullable',
            ],
            "meta_description" => [
                'nullable',
            ],
            "meta_keywords" => [
                'nullable',
            ],
            "status" => [
                'nullable',
            ],
        ];
    }
}
