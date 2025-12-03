<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function notifyUsers($users, string $type, string $title, string $message, array $data = []): void
    {
        foreach ($users as $user) {
            if (! $user instanceof User) {
                continue;
            }

            Notification::create([
                'user_id' => $user->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
            ]);
        }
    }

    public static function notifyUser(User $user, string $type, string $title, string $message, array $data = []): void
    {
        Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    // Specific helpers
    public static function groupRequestStatusChanged(User $candidate, string $groupName, string $status, ?string $approverName = null, ?string $responseMessage = null): void
    {
        $title = 'Status da Solicitação Alterado';
        $message = "Sua solicitação para {$groupName} foi {$status}.";
        if ($responseMessage) {
            $message .= " Resposta: " . $responseMessage;
        }
        self::notifyUser($candidate, 'group_request_status_changed', $title, $message, [
            'group_name' => $groupName,
            'status' => $status,
            'approver_name' => $approverName,
        ]);
    }

    public static function scalePublished(array $users, string $groupName, string $titleScale): void
    {
        $title = 'Nova Escala Publicada';
        $message = "Nova escala publicada em {$groupName}: {$titleScale}";
        self::notifyUsers($users, 'scale_published', $title, $message, [
            'group_name' => $groupName,
            'scale_title' => $titleScale,
        ]);
    }
}
