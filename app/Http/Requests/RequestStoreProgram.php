<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreProgram extends FormRequest
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
        ];
    }
}
