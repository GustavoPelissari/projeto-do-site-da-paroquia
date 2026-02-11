<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property-read Group $group
 */
class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
        'title',
        'description',
        'pdf_path',
        'pdf_filename',
        'start_date',
        'end_date',
        'metadata',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'metadata' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        // Ao criar uma nova escala, verificar limite de 5 PDFs
        static::created(function ($schedule) {
            $schedule->enforceFileLimit();
        });

        // Ao deletar uma escala, remover o arquivo PDF
        static::deleting(function ($schedule) {
            if ($schedule->pdf_path && Storage::exists($schedule->pdf_path)) {
                Storage::delete($schedule->pdf_path);
            }
        });
    }

    public function enforceFileLimit(): void
    {
        $group = $this->group;
        $schedules = $group->schedules()
            ->orderBy('created_at', 'desc')
            ->get();

        if ($schedules->count() > 5) {
            $toDelete = $schedules->slice(5);
            
            foreach ($toDelete as $oldSchedule) {
                // Log da exclusão automática
                AuditLog::create([
                    'user_id' => $this->user_id,
                    'action' => 'auto_delete_schedule',
                    'resource_type' => 'Schedule',
                    'resource_id' => $oldSchedule->id,
                    'description' => "Escala removida automaticamente (limite de 5 PDFs) - {$oldSchedule->title}",
                    'ip_address' => request()->ip(),
                ]);

                $oldSchedule->delete();
            }
        }
    }

    public function getPdfUrl(): ?string
    {
        if ($this->pdf_path && Storage::exists($this->pdf_path)) {
            return Storage::url($this->pdf_path);
        }
        
        return null;
    }

    public function getPdfSize(): ?string
    {
        if ($this->pdf_path && Storage::exists($this->pdf_path)) {
            $bytes = Storage::size($this->pdf_path);
            return $this->formatBytes($bytes);
        }
        
        return null;
    }

    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }

    public function isCurrentlyActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now()->toDateString();
        
        return $now >= $this->start_date->toDateString() && 
               $now <= $this->end_date->toDateString();
    }

    public function getStatusBadge(): array
    {
        if (!$this->is_active) {
            return ['text' => 'Inativo', 'color' => 'gray'];
        }

        $now = now()->toDateString();
        $start = $this->start_date->toDateString();
        $end = $this->end_date->toDateString();

        if ($now < $start) {
            return ['text' => 'Futuro', 'color' => 'blue'];
        } elseif ($now > $end) {
            return ['text' => 'Expirado', 'color' => 'red'];
        } else {
            return ['text' => 'Ativo', 'color' => 'green'];
        }
    }

    public function notifyGroupMembers(): void
    {
        $title = "Nova Escala: {$this->title}";
        $message = "Uma nova escala foi publicada para {$this->group->name}";
        
        $data = [
            'schedule_id' => $this->id,
            'group_id' => $this->group_id,
            'group_name' => $this->group->name,
            'start_date' => $this->start_date->format('d/m/Y'),
            'end_date' => $this->end_date->format('d/m/Y'),
        ];

        Notification::createForGroup(
            $this->group, 
            Notification::TYPE_NEW_SCHEDULE, 
            $title, 
            $message, 
            $data
        );
    }

    // Relationships
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForGroup($query, $groupId)
    {
        return $query->where('group_id', $groupId);
    }

    public function scopeCurrent($query)
    {
        $now = now()->toDateString();
        return $query->where('is_active', true)
                    ->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '>', now()->toDateString());
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now()->toDateString());
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
