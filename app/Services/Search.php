<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Search {

    public function __invoke(Model|string $model, array $conditions, bool $strict = false, bool $paginate = false)
    {

        // Prepare the query builder
        $query = is_string($model) ? $model::query() : $model->newQuery();

        foreach ($conditions as $column => $value) {
            if ($strict) {
                $query->where($column, $value);
            } else {
                $query->where($column, 'LIKE', "%{$value}%");
            }
        }

        return $paginate ? $query->paginate(5) : $query->get();
    }

}

