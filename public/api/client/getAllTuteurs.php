<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/UserModel.php';
require_once __DIR__ . '/../../../controller/UserController.php';

$controller = new UserController($pdo);
$controller->getAllTuteurs();
?>
