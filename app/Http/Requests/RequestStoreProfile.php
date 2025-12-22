<?php

namespace App\Http\Requests;

class RequestStoreProfile extends Base
{
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
