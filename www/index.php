<?php
try {
    $host = getenv('DB_HOST') ?: 'db';
    $dbname = getenv('DB_NAME') ?: 'myapp';
    $username = getenv('DB_USER') ?: 'appuser';
    $password = getenv('DB_PASS') ?: 'apppassword';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1>Users:</h1>";
    foreach ($users as $user) {
        echo "<p>{$user['username']} - {$user['email']}</p>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}