<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read User $user
 */
class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
        'email_sent',
        'email_sent_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'email_sent' => 'boolean',
        'email_sent_at' => 'datetime',
    ];

    // Notification types
    const TYPE_REQUEST_APPROVED = 'request_approved';
    const TYPE_REQUEST_REJECTED = 'request_rejected';
    const TYPE_NEW_SCHEDULE = 'new_schedule';
    const TYPE_NEW_POST = 'new_post';
    const TYPE_NEW_COMMENT = 'new_comment';
    const TYPE_SCHEDULE_UPDATED = 'schedule_updated';
    const TYPE_GROUP_ANNOUNCEMENT = 'group_announcement';
    const TYPE_SYSTEM_ALERT = 'system_alert';

    public static function getTypes(): array
    {
        return [
            self::TYPE_REQUEST_APPROVED => 'Solicitação Aprovada',
            self::TYPE_REQUEST_REJECTED => 'Solicitação Rejeitada',
            self::TYPE_NEW_SCHEDULE => 'Nova Escala',
            self::TYPE_NEW_POST => 'Nova Publicação',
            self::TYPE_NEW_COMMENT => 'Novo Comentário',
            self::TYPE_SCHEDULE_UPDATED => 'Escala Atualizada',
            self::TYPE_GROUP_ANNOUNCEMENT => 'Anúncio do Grupo',
            self::TYPE_SYSTEM_ALERT => 'Alerta do Sistema',
        ];
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function markAsRead(): void
    {
        if (!$this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }

    public function markAsUnread(): void
    {
        $this->update(['read_at' => null]);
    }

    public function shouldSendEmail(): bool
    {
        return $this->user->email_notifications_enabled && 
               !$this->email_sent &&
               in_array($this->type, [
                   self::TYPE_REQUEST_APPROVED,
                   self::TYPE_REQUEST_REJECTED,
                   self::TYPE_SYSTEM_ALERT,
               ]);
    }

    public function markEmailAsSent(): void
    {
        $this->update([
            'email_sent' => true,
            'email_sent_at' => now(),
        ]);
    }

    public function getIcon(): string
    {
        return match($this->type) {
            self::TYPE_REQUEST_APPROVED => '✅',
            self::TYPE_REQUEST_REJECTED => '❌',
            self::TYPE_NEW_SCHEDULE => '📅',
            self::TYPE_NEW_POST => '📝',
            self::TYPE_NEW_COMMENT => '💬',
            self::TYPE_SCHEDULE_UPDATED => '🔄',
            self::TYPE_GROUP_ANNOUNCEMENT => '📢',
            self::TYPE_SYSTEM_ALERT => '⚠️',
            default => '🔔',
        };
    }

    public function getColor(): string
    {
        return match($this->type) {
            self::TYPE_REQUEST_APPROVED => 'green',
            self::TYPE_REQUEST_REJECTED => 'red',
            self::TYPE_NEW_SCHEDULE => 'blue',
            self::TYPE_NEW_POST => 'indigo',
            self::TYPE_NEW_COMMENT => 'purple',
            self::TYPE_SCHEDULE_UPDATED => 'orange',
            self::TYPE_GROUP_ANNOUNCEMENT => 'yellow',
            self::TYPE_SYSTEM_ALERT => 'red',
            default => 'gray',
        };
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Static methods
    public static function createForUser(User $user, string $type, string $title, string $message, array $data = []): self
    {
        return self::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function createForGroup(Group $group, string $type, string $title, string $message, array $data = []): void
    {
        $users = User::where('parish_group_id', $group->id)->get();
        
        foreach ($users as $user) {
            self::createForUser($user, $type, $title, $message, $data);
        }
    }
}
