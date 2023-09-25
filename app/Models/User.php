<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @property int $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property null|Collection<Event> $events
 * @property string $register_at
 * @property null|string $birthday_at
 * @property null|string $created_at
 * @property null|string $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'register_at',
        'birthday_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
