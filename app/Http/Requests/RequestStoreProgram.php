<?php

namespace App\Http\Requests;

class RequestStoreProgram extends Base
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->has('tags')) {
            $this->merge([
                'tags' => json_decode($this->tags, true)
            ]);
        }

        return [
            'name'          => 'required|',
            'description'   => 'required|max:200',
            'price'         => 'required|',
            'limit'         => 'required|',
            'logo'          => 'required|mimes:jpg,bmp,png|image',
            'difficulty'    => 'required|in:' . implode(',', config('tables.programs.difficulty')),
            'tags'          => 'sometimes|array|exists:tags,id',
            'category'      => 'required|in:' . implode(',', config('tables.categories.title')),
        ];
    }
}
