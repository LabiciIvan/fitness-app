<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function types(): BelongsToMany {
        return $this->belongsToMany(Type::class);
    }

    public function profile(): HasOne {
        return $this->hasOne(Profile::class);
    }

    public function programs(): HasMany {
        return $this->hasMany(Program::class);
    }

    public function enrollments(): BelongsToMany {
        return $this->belongsToMany(Program::class, 'enrollments_programs', 'user_id', 'program_id');
    }

    public function notifications(): HasMany {
        return $this->hasMany(Notification::class, 'user_id')->orderByDesc('id');
    }

    public function unreadNotifications() {
        return $this->notifications()->where('read', false);
    }

}
