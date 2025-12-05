<?php

// Usuários de teste que devem ser mantidos
$testEmails = [
    'admin@paroquia.test',
    'coord.coroinhas@paroquia.test',
    'administrativo@paroquia.test',
    'maria@paroquia.test',
    'pedro.coroinha@paroquia.test'
];

// Conectar ao banco de dados SQLite
try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/database/database.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Buscar todos os usuários
    $stmt = $pdo->query("SELECT id, email FROM users");
    $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "=== USUÁRIOS NO SISTEMA ===\n";
    foreach ($allUsers as $u) {
        $status = in_array($u['email'], $testEmails) ? "✓ MANTER" : "✗ DELETAR";
        echo "[{$u['id']}] {$u['email']} - {$status}\n";
    }
    
    echo "\n=== DELETANDO USUÁRIOS EXTRAS ===\n";
    
    // Deletar usuários que não estão na lista de teste
    foreach ($allUsers as $user) {
        if (!in_array($user['email'], $testEmails)) {
            // Deletar notificações primeiro (foreign key)
            $pdo->prepare("DELETE FROM notifications WHERE user_id = ?")->execute([$user['id']]);
            
            // Deletar solicitações de grupo
            $pdo->prepare("DELETE FROM group_requests WHERE user_id = ?")->execute([$user['id']]);
            
            // Deletar email verifications
            $pdo->prepare("DELETE FROM email_verifications WHERE user_id = ?")->execute([$user['id']]);
            
            // Finalmente deletar o usuário
            $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$user['id']]);
            
            echo "✓ Deletado: {$user['email']} (ID: {$user['id']})\n";
        }
    }
    
    echo "\n=== CONCLUSÃO ===\n";
    echo "✓ Limpeza concluída! Apenas usuários de teste foram mantidos.\n";
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
}
?>
