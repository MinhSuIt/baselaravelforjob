<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
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
                "unique:tags,name,".$this->tag //from param of api route
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
        ];
    }
}
