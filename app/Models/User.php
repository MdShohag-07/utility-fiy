<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Statement; // Important: Import the Statement model for the relationship

class User extends Authenticatable implements MustVerifyEmail // Remove 'implements MustVerifyEmail' if not used
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';

    protected $fillable = [
        'first_name',
        'last_name',
        'secondary_first_name',
        'secondary_last_name',
        'username',
        'email',
        'password',
        'address',
        'city',
        'state',
        'zip_code',
        'phone_number',
        'role',
        'account_number',
        'service_type',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function statements()
    {
        return $this->hasMany(Statement::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Accessor for the user's full name.
     * Allows you to use $user->full_name
     */
    public function getFullNameAttribute(): string // <--- RENAMED (was getPrimaryFullNameAttribute)
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Accessor for the user's secondary full name.
     * Allows you to use $user->secondary_full_name in Blade.
     */
    public function getSecondaryFullNameAttribute(): ?string
    {
        if (!empty($this->secondary_first_name) || !empty($this->secondary_last_name)) {
            return trim("{$this->secondary_first_name} {$this->secondary_last_name}");
        }
        return null;
    }

    /**
     * Accessor for combined account holder names for display on statements.
     * Allows $user->account_holder_names
     */
    public function getAccountHolderNamesAttribute(): string
    {
        $names = $this->getFullNameAttribute(); // Now uses getFullNameAttribute
        $secondaryName = $this->getSecondaryFullNameAttribute();
        if ($secondaryName) {
            $names .= " & {$secondaryName}";
        }
        return $names;
    }

    /**
     * Accessor for a general display name (e.g., for admin lists, user dropdowns).
     * Allows you to use $user->display_name
     */
    public function getDisplayNameAttribute(): string
    {
        $displayName = $this->getFullNameAttribute(); // Now uses getFullNameAttribute
        if (!empty($this->username)) {
            $displayName .= " ({$this->username})";
        }
        if (!empty($this->account_number)) {
            $displayName .= " - Acct: {$this->account_number}";
        }
        return $displayName;
    }
}