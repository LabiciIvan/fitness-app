<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    protected $fillable = [
        'tag'
    ];

    public function programs(): BelongsToMany {
        return $this->belongsToMany(Program::class, 'programs_tags', 'tag_id', 'program_id');
    }
}
