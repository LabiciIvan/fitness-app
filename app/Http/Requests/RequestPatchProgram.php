<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestPatchProgram extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'required|',
            'description'   => 'required|max:200',
            'price'         => 'required|',
            'limit'         => 'required|',
            'difficulty'    => 'required|in:' . implode(',', config('tables.programs.difficulty')),
            'logo'          => 'sometimes|mimes:jpg,bmp,png|image',
        ];
    }
}
