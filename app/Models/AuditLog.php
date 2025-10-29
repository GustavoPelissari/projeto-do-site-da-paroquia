<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'resource_type',
        'resource_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    // Action types
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_APPROVE_REQUEST = 'approve_group_request';
    const ACTION_REJECT_REQUEST = 'reject_group_request';
    const ACTION_UPLOAD_SCHEDULE = 'upload_schedule';
    const ACTION_DELETE_SCHEDULE = 'delete_schedule';
    const ACTION_ASSIGN_ROLE = 'assign_role';
    const ACTION_REMOVE_COORDINATOR = 'remove_coordinator';
    const ACTION_CHANGE_SETTINGS = 'change_settings';

    public static function getActions(): array
    {
        return [
            self::ACTION_CREATE => 'Criar',
            self::ACTION_UPDATE => 'Atualizar',
            self::ACTION_DELETE => 'Excluir',
            self::ACTION_LOGIN => 'Login',
            self::ACTION_LOGOUT => 'Logout',
            self::ACTION_APPROVE_REQUEST => 'Aprovar Solicitação',
            self::ACTION_REJECT_REQUEST => 'Rejeitar Solicitação',
            self::ACTION_UPLOAD_SCHEDULE => 'Upload de Escala',
            self::ACTION_DELETE_SCHEDULE => 'Excluir Escala',
            self::ACTION_ASSIGN_ROLE => 'Atribuir Papel',
            self::ACTION_REMOVE_COORDINATOR => 'Remover Coordenador',
            self::ACTION_CHANGE_SETTINGS => 'Alterar Configurações',
        ];
    }

    public function isSensitive(): bool
    {
        return in_array($this->action, [
            self::ACTION_DELETE,
            self::ACTION_DELETE_SCHEDULE,
            self::ACTION_REMOVE_COORDINATOR,
            self::ACTION_ASSIGN_ROLE,
            self::ACTION_CHANGE_SETTINGS,
        ]);
    }

    public function getActionLabel(): string
    {
        return self::getActions()[$this->action] ?? ucfirst($this->action);
    }

    public function getIcon(): string
    {
        return match($this->action) {
            self::ACTION_CREATE => '➕',
            self::ACTION_UPDATE => '✏️',
            self::ACTION_DELETE => '🗑️',
            self::ACTION_LOGIN => '🔐',
            self::ACTION_LOGOUT => '🚪',
            self::ACTION_APPROVE_REQUEST => '✅',
            self::ACTION_REJECT_REQUEST => '❌',
            self::ACTION_UPLOAD_SCHEDULE => '📅',
            self::ACTION_DELETE_SCHEDULE => '🗑️',
            self::ACTION_ASSIGN_ROLE => '👤',
            self::ACTION_REMOVE_COORDINATOR => '👥',
            self::ACTION_CHANGE_SETTINGS => '⚙️',
            default => '📝',
        };
    }

    public function getColor(): string
    {
        return match($this->action) {
            self::ACTION_CREATE => 'green',
            self::ACTION_UPDATE => 'blue',
            self::ACTION_DELETE, self::ACTION_DELETE_SCHEDULE, self::ACTION_REMOVE_COORDINATOR => 'red',
            self::ACTION_LOGIN => 'indigo',
            self::ACTION_LOGOUT => 'gray',
            self::ACTION_APPROVE_REQUEST => 'green',
            self::ACTION_REJECT_REQUEST => 'red',
            self::ACTION_UPLOAD_SCHEDULE => 'blue',
            self::ACTION_ASSIGN_ROLE => 'purple',
            self::ACTION_CHANGE_SETTINGS => 'orange',
            default => 'gray',
        };
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForResource($query, $resourceType, $resourceId = null)
    {
        $query = $query->where('resource_type', $resourceType);
        
        if ($resourceId) {
            $query->where('resource_id', $resourceId);
        }
        
        return $query;
    }

    public function scopeOfAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeSensitive($query)
    {
        return $query->whereIn('action', [
            self::ACTION_DELETE,
            self::ACTION_DELETE_SCHEDULE,
            self::ACTION_REMOVE_COORDINATOR,
            self::ACTION_ASSIGN_ROLE,
            self::ACTION_CHANGE_SETTINGS,
        ]);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Static methods
    public static function log(string $action, string $resourceType, $resourceId = null, string $description = '', array $oldValues = [], array $newValues = []): self
    {
        return self::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public static function logLogin(User $user): self
    {
        return self::create([
            'user_id' => $user->id,
            'action' => self::ACTION_LOGIN,
            'resource_type' => 'User',
            'resource_id' => $user->id,
            'description' => "Login realizado",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public static function logLogout(User $user): self
    {
        return self::create([
            'user_id' => $user->id,
            'action' => self::ACTION_LOGOUT,
            'resource_type' => 'User',
            'resource_id' => $user->id,
            'description' => "Logout realizado",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
