<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'schedule',
    ];

    protected $casts = [
        'schedule' => 'array',
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

    public function reviews(): HasMany {
        return $this->hasMany(Reviews::class, 'program_id');
    }

    public function enrollments(): BelongsToMany {
        return $this->belongsToMany(User::class, 'enrollments_programs', 'user_id', 'program_id');
    }
}


