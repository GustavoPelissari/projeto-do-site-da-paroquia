<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read User $user
 * @property-read Group $group
 */
class GroupRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'status',
        'message',
        'response_message',
        'approved_by',
        'approved_at',
        'rejected_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pendente',
            self::STATUS_APPROVED => 'Aprovada',
            self::STATUS_REJECTED => 'Rejeitada',
        ];
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }
    
    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
    
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }
    
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function approve(User $approver, ?string $message = null): void
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'approved_by' => $approver->id,
            'approved_at' => now(),
            'response_message' => $message,
        ]);

        // Adicionar usuário ao grupo
        $this->user->update([
            'parish_group_id' => $this->group_id
        ]);

        // Criar notificação para o usuário
        Notification::create([
            'user_id' => $this->user_id,
            'type' => 'request_approved',
            'title' => 'Solicitação Aprovada',
            'message' => "Sua solicitação para entrar em {$this->group->name} foi aprovada!",
            'data' => [
                'group_id' => $this->group_id,
                'group_name' => $this->group->name,
                'approved_by' => $approver->name,
            ]
        ]);

        // Log de auditoria
        AuditLog::create([
            'user_id' => $approver->id,
            'action' => 'approve_group_request',
            'resource_type' => 'GroupRequest',
            'resource_id' => $this->id,
            'description' => "Aprovou solicitação de {$this->user->name} para {$this->group->name}",
            'ip_address' => request()->ip(),
        ]);
    }

    public function reject(User $rejector, ?string $message = null): void
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'approved_by' => $rejector->id,
            'rejected_at' => now(),
            'response_message' => $message,
        ]);

        // Criar notificação para o usuário
        Notification::create([
            'user_id' => $this->user_id,
            'type' => 'request_rejected',
            'title' => 'Solicitação Rejeitada',
            'message' => "Sua solicitação para entrar em {$this->group->name} foi rejeitada.",
            'data' => [
                'group_id' => $this->group_id,
                'group_name' => $this->group->name,
                'rejected_by' => $rejector->name,
                'reason' => $message,
            ]
        ]);

        // Log de auditoria
        AuditLog::create([
            'user_id' => $rejector->id,
            'action' => 'reject_group_request',
            'resource_type' => 'GroupRequest',
            'resource_id' => $this->id,
            'description' => "Rejeitou solicitação de {$this->user->name} para {$this->group->name}",
            'ip_address' => request()->ip(),
        ]);
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeForGroup($query, $groupId)
    {
        return $query->where('group_id', $groupId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
