<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'coordinator_name',
        'coordinator_phone',
        'coordinator_email',
        'meeting_info',
        'image',
        'is_active',
        'requires_scale',
        'max_members',
        'coordinator_id',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'requires_scale' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeWithSchedules(Builder $query): Builder
    {
        return $query->where('requires_scale', true);
    }

    public function scopeWithoutSchedules(Builder $query): Builder
    {
        return $query->where('requires_scale', false);
    }

    public function getCategoryNameAttribute(): string
    {
        $categories = [
            'liturgy' => 'Liturgia',
            'liturgia' => 'Liturgia',
            'pastoral' => 'Pastoral',
            'service' => 'Serviço',
            'caridade' => 'Caridade',
            'formation' => 'Formação',
            'catequese' => 'Catequese',
            'youth' => 'Juventude',
            'jovens' => 'Juventude',
            'family' => 'Família',
            'geral' => 'Geral',
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    public function hasCoordinator(): bool
    {
        return $this->coordinator_id !== null;
    }

    public function isCoordinatedBy(User $user): bool
    {
        return $this->coordinator_id === $user->id;
    }

    public function getMembersCount(): int
    {
        return $this->members()->count();
    }

    public function getPendingRequestsCount(): int
    {
        return $this->groupRequests()->where('status', GroupRequest::STATUS_PENDING)->count();
    }

    public function getCurrentSchedule(): ?Schedule
    {
        /** @var Schedule|null $schedule */
        $schedule = $this->schedules()->where('is_active', true)
            ->where('start_date', '<=', now()->toDateString())
            ->where('end_date', '>=', now()->toDateString())
            ->first();

        return $schedule;
    }

    public function getActiveSchedules()
    {
        return $this->schedules()->where('is_active', true)
            ->orderBy('start_date', 'desc')
            ->get();
    }

    public function isFull(): bool
    {
        // Se não tem limite de membros, nunca está cheio
        if (!isset($this->max_members) || $this->max_members === null) {
            return false;
        }

        // Verifica se o número de membros atingiu o limite
        return $this->getMembersCount() >= $this->max_members;
    }

    // Relationships
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members(): HasMany
    {
        return $this->hasMany(User::class, 'parish_group_id');
    }

    public function groupRequests(): HasMany
    {
        return $this->hasMany(GroupRequest::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
