<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreferenceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'categories' => 'nullable|array',
            'sources' => 'nullable|array',
            'authors' => 'nullable|array',
        ];
    }
}
