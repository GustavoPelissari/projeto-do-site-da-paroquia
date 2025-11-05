<!DOCTYPE html>
<html>
<head>
    <title>Teste de Upload</title>
</head>
<body>
    <h1>Teste de Upload de Imagem</h1>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<h2>Resultado:</h2>';
        echo '<pre>';
        echo "Arquivos recebidos: " . print_r($_FILES, true) . "\n\n";
        
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
            $destino = __DIR__ . '/../storage/app/public/test_' . $_FILES['imagem']['name'];
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                echo "✅ SUCESSO! Arquivo salvo em: $destino\n";
                echo "Tamanho: " . $_FILES['imagem']['size'] . " bytes\n";
            } else {
                echo "❌ ERRO ao mover o arquivo\n";
            }
        } else {
            echo "❌ Nenhum arquivo foi enviado ou houve erro\n";
            echo "Erro código: " . ($_FILES['imagem']['error'] ?? 'N/A') . "\n";
        }
        echo '</pre>';
    }
    ?>
    
    <form method="POST" enctype="multipart/form-data">
        <label>Selecione uma imagem:</label><br>
        <input type="file" name="imagem" accept="image/*" required><br><br>
        <button type="submit">Enviar Teste</button>
    </form>
    
    <hr>
    <h3>Configurações PHP:</h3>
    <pre>
upload_max_filesize: <?= ini_get('upload_max_filesize') ?>

post_max_size: <?= ini_get('post_max_size') ?>

max_file_uploads: <?= ini_get('max_file_uploads') ?>

    </pre>
</body>
</html>
