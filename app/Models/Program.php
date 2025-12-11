<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\EnrollmentFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'limit',
        'difficulty',
        'logo',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function enrolled(): BelongsToMany {
        return $this->belongsToMany(User::class, 'enrollments_programs', 'program_id', 'user_id');
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class, 'programs_tags', 'program_id', 'tag_id');
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany(Categories::class, 'categories_programs', 'program_id', 'category_id');
    }
}
