<?php
declare(strict_types=1);

$databaseConnected = false;
$databaseVersion = null;
$errorMessage = null;

try {
    $connection = new PDO(
        sprintf(
            'mysql:host=%s;dbname=%s;charset=utf8mb4',
            getenv('DB_HOST'),
            getenv('DB_NAME')
        ),
        getenv('DB_USER'),
        getenv('DB_PASSWORD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $databaseVersion = $connection->query('SELECT VERSION()')->fetchColumn();
    $databaseConnected = true;
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    $errorMessage = 'No fue posible conectar con la base de datos.';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hola mundo</title>
</head>
<body>
    <h1>Hola mundo</h1>
    <?php if ($databaseConnected): ?>
        <p>Conexión a MySQL: correcta.</p>
        <p>Versión de MySQL: <?= htmlspecialchars((string) $databaseVersion, ENT_QUOTES, 'UTF-8') ?></p>
    <?php else: ?>
        <p><?= htmlspecialchars((string) $errorMessage, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
</body>
</html>
