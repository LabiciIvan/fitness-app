<?php

namespace App\Http\Requests;

class RequestStoreReview extends Base
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content'   => 'required|max:400',
            'rating'    => 'required|between:1,5',
        ];
    }
}
