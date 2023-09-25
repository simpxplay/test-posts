<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool)Post::where('user_id',auth()->user()->id);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'sometimes',
                'string',
                'min:3',
                'max:255',
            ],
            'body' => [
                'sometimes',
                'string',
            ]
        ];
    }
}
