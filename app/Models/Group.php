<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithSchedules($query)
    {
        return $query->where('requires_scale', true);
    }

    public function scopeWithoutSchedules($query)
    {
        return $query->where('requires_scale', false);
    }
    
    public function getCategoryNameAttribute()
    {
        $categories = [
            'liturgy' => 'Liturgia',
            'pastoral' => 'Pastoral',
            'service' => 'Serviço',
            'formation' => 'Formação',
            'youth' => 'Juventude',
            'family' => 'Família',
        ];
        
        return $categories[$this->category] ?? $this->category;
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
        return $this->groupRequests()->pending()->count();
    }

    public function getCurrentSchedule(): ?Schedule
    {
        return $this->schedules()->current()->first();
    }

    public function getActiveSchedules()
    {
        return $this->schedules()->active()->orderBy('start_date', 'desc')->get();
    }

    // Relationships
    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->hasMany(User::class, 'parish_group_id');
    }

    public function groupRequests()
    {
        return $this->hasMany(GroupRequest::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
