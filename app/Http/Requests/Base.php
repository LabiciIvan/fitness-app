<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Base extends FormRequest {

    protected ?array $validatedData = null;

    private array $mappedData = [];

    public function authorize(): bool {
        return true;
    }

    public function attribute(string $attribute) {
        if ($this->validatedData === null) {
            $validated = $this->validated();

            foreach ($validated as $key => $value) {
                $this->validatedData[$key] = $value;
            }
        }

        return $this->validatedData[$attribute] ?? null;
    }

    /**
     * Get only specific validated attributes
     */
    public function onlyData(array $fields): array
    {
        return array_intersect_key(
            $this->validated(),
            array_flip($fields)
        );
    }

    /**
     * Get validated attributes based on rules keys
     */
    public function mapped(): array
    {
        return array_intersect_key(
            $this->validated(),
            $this->rules()
        );
    }
}