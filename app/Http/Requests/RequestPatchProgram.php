<?php

namespace App\Http\Requests;

class RequestPatchProgram extends Base
{
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
            'category'      => 'required|in:' . implode(',', config('tables.categories.title')),
            'logo'          => 'sometimes|mimes:jpg,bmp,png|image',
            'schedule'      => 'required|json'
        ];
    }
}
