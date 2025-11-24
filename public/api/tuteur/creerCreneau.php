<?php
    header('Content-Type: application/json');
    session_start();

    require_once __DIR__ . '/../../../config/database.php';
    require_once __DIR__ . '/../../../models/CreneauModel.php';
    require_once __DIR__ . '/../../../controller/CreneauController.php';

    $controller = new CreneauController($pdo);
    $controller->creerCreneau();
    exit;
?>