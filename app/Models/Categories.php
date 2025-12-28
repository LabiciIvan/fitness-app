<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categories extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriesFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    public function programs(): BelongsToMany {
        return $this->belongsToMany(Program::class, 'categories_programs', 'category_id', 'program_id');
    }
}
