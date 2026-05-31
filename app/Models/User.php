<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 'super_admin';

    public const ROLE_ADMIN = 'admin';

    public const ROLE_STAFF = 'staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'username',
        'email',
        'role',
        'password',
        'profile_picture',
        'gender',
        'phone',
        'birthdate',
        'country',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate' => 'date',
    ];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function canDelete(): bool
    {
        return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN], true);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStaff(): bool
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function canManageRoles(): bool
    {
        return $this->canDelete();
    }

    public function canManageUsers(): bool
    {
        return $this->canDelete();
    }

    public function canEditProfile(): bool
    {
        return $this->canDelete();
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            self::ROLE_SUPER_ADMIN => 'Super admin',
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_STAFF => 'Staff',
            default => 'Staff',
        };
    }

    public function canEditUser(User $target): bool
    {
        if ($this->isStaff() || ! $this->canManageUsers()) {
            return false;
        }

        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->isAdmin() && $target->isStaff();
    }

    public function canDeleteUser(User $target): bool
    {
        if ($this->id === $target->id || ! $this->canDelete()) {
            return false;
        }

        if ($this->isSuperAdmin()) {
            return $target->isAdmin() || $target->isStaff();
        }

        return $this->isAdmin() && $target->isStaff();
    }

    public function canCreateCustomers(): bool
    {
        return ! $this->isStaff();
    }

    public function canEditCustomers(): bool
    {
        return true;
    }

    public static function assignableRolesFor(?User $actor, ?User $target = null): array
    {
        if ($actor?->isSuperAdmin()) {
            if ($target?->isSuperAdmin()) {
                return [
                    self::ROLE_SUPER_ADMIN => 'Super admin',
                    self::ROLE_ADMIN => 'Admin',
                    self::ROLE_STAFF => 'Staff',
                ];
            }

            if ($target?->isAdmin()) {
                return [
                    self::ROLE_ADMIN => 'Admin',
                    self::ROLE_STAFF => 'Staff',
                ];
            }

            return [
                self::ROLE_SUPER_ADMIN => 'Super admin',
                self::ROLE_ADMIN => 'Admin',
                self::ROLE_STAFF => 'Staff',
            ];
        }

        if ($actor?->isAdmin() && (! $target || $target->isStaff())) {
            return [
                self::ROLE_STAFF => 'Staff',
            ];
        }

        return [];
    }
}
