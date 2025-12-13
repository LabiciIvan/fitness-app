<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreProfile extends FormRequest
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
            'sex'          => 'required|in:' . implode(',', config('tables.profiles.sex')),
            'description'  => 'sometimes|max:200',
            'country'      => 'required',
            'city'         => 'required',
            'phone'        => 'required',
            'logo'         => 'sometimes|mimes:jpg,bmp,png|image'
        ];
    }
}
