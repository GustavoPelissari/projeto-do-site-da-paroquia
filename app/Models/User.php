<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\CustomResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property-read Group|null $group
 * @property-read Group|null $parishGroup
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'phone_verified_at',
        'birth_date',
        'address',
        'parish_group_id',
        'email_notifications_enabled',
        'profile_photo_path',
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
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
        'role' => UserRole::class,
    ];

    // Role helper methods
    public function hasRole(UserRole|string $role): bool
    {
        if (is_string($role)) {
            $role = UserRole::from($role);
        }

        return $this->role === $role;
    }

    public function isAdminGlobal(): bool
    {
        return $this->role === UserRole::ADMIN_GLOBAL;
    }

    public function isAdministrativo(): bool
    {
        return $this->role === UserRole::ADMINISTRATIVO;
    }

    public function isCoordenador(): bool
    {
        return $this->role === UserRole::COORDENADOR_PASTORAL;
    }

    public function isUsuarioPadrao(): bool
    {
        return $this->role === UserRole::USUARIO_PADRAO;
    }

    public function canManageUsers(): bool
    {
        return $this->role->canManageUsers();
    }

    public function canManageMasses(): bool
    {
        return $this->role->canManageMasses();
    }

    public function canCreateNews(): bool
    {
        return $this->role->canCreateNews();
    }

    public function canManageGroups(): bool
    {
        return $this->role->canManageGroups();
    }

    public function canManageOwnGroup(): bool
    {
        return $this->role->canManageOwnGroup();
    }

    public function canManageSchedules(): bool
    {
        return $this->role->canManageSchedules();
    }

    public function canApproveRequests(): bool
    {
        return $this->role && $this->role->canApproveRequests();
    }

    public function canDeleteGroups(): bool
    {
        return $this->role->canDeleteGroups();
    }

    public function canManageGroup(Group $group): bool
    {
        if ($this->isAdminGlobal()) {
            return true;
        }

        if ($this->isCoordenador() && $this->parish_group_id === $group->id) {
            return true;
        }

        return false;
    }

    public function isVerified(): bool
    {
        return $this->email_verified_at !== null && $this->phone_verified_at !== null;
    }

    public function getVerificationStatusAttribute(): string
    {
        $emailVerified = $this->email_verified_at !== null;
        $phoneVerified = $this->phone_verified_at !== null;

        if ($emailVerified && $phoneVerified) {
            return 'verified';
        } elseif ($emailVerified || $phoneVerified) {
            return 'partial';
        } else {
            return 'unverified';
        }
    }

    // Relationships
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function parishGroup(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'parish_group_id');
    }

    public function groupRequests(): HasMany
    {
        return $this->hasMany(GroupRequest::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    // Scopes
    public function scopeCoordinators($query)
    {
        return $query->where('role', UserRole::COORDENADOR_PASTORAL);
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at')
            ->whereNotNull('phone_verified_at');
    }
}
