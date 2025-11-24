<?php
    header('Content-Type: application/json');
    session_start();

    require_once __DIR__ . '/../../../config/database.php';
    require_once __DIR__ . '/../../../models/UserModel.php';
    require_once __DIR__ . '/../../../controller/AuthController.php';

    $controller = new AuthController($pdo);
    $controller->login();
    exit;
?>