<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'login',
        'email',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
        'first_name',
        'middle_name',
        'last_name',
        'pivot',
    ];

    protected $appends = [
        'firstName',
        'middleName',
        'lastName',
        'fullName',
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

    public function getFirstNameAttribute(): ?string
    {
        return $this->attributes['first_name'];
    }

    public function getLastNameAttribute(): ?string
    {
        return $this->attributes['last_name'];
    }

    public function getMiddleNameAttribute(): ?string
    {
        return $this->attributes['middle_name'];
    }

    public function getFullNameAttribute(): ?string
    {
        if (empty($this->getFirstNameAttribute())
            && empty($this->getMiddleNameAttribute())
            && empty($this->getLastNameAttribute())) {
            return null;
        }
        return $this->getLastNameAttribute() . ' ' . $this->getFirstNameAttribute() . ' ' . $this->getMiddleNameAttribute();
    }

    public function jsonSerialize(bool $printToken = false): array
    {
        $user = self::toArray();
        if ($printToken) {
            $user['token'] = $this->remember_token;
        }
        return $user;
    }
}
