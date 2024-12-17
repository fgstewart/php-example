<?php
// init-database.php
$attempts = 0;
$maxAttempts = 10;

while ($attempts < $maxAttempts) {
    try {
        // Database connection parameters
        $host = getenv('DB_HOST') ?: 'db';
        $dbname = getenv('DB_NAME') ?: 'myapp';
        $username = getenv('DB_USER') ?: 'appuser';
        $password = getenv('DB_PASS') ?: 'apppassword';

        // Create PDO connection
        $pdo = new PDO("mysql:host=$host", $username, $password);
        
        // Set error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create database if not exists
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
        
        // Connect to the specific database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        // Execute schema creation
        $schemaFile = '/var/www/mysql-init/01-schema.sql';
        if (file_exists($schemaFile)) {
            $schemaSql = file_get_contents($schemaFile);
            $pdo->exec($schemaSql);
            echo "Schema created successfully\n";
        }

        // Execute data seeding
        $seedFile = '/var/www/mysql-init/02-seed-data.sql';
        if (file_exists($seedFile)) {
            $seedSql = file_get_contents($seedFile);
            $pdo->exec($seedSql);
            echo "Data seeded successfully\n";
        }

        break; // Success, exit loop
    } catch (PDOException $e) {
        $attempts++;
        echo "Connection attempt $attempts failed: " . $e->getMessage() . "\n";
        
        if ($attempts >= $maxAttempts) {
            echo "Failed to connect after $maxAttempts attempts\n";
            exit(1);
        }
        
        // Wait before retrying
        sleep(5);
    }
}