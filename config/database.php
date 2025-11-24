<?php
$dsn = 'mysql:host=localhost:3306;dbname=tuto;charset=utf8';
$adminDB = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $adminDB, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Échec de la connexion : ' . $e->getMessage());
}

return $pdo;
