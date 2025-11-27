<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/MessageModel.php';
require_once __DIR__ . '/../../../controller/MessageController.php';

parse_str(file_get_contents("php://input"), $_DELETE);

$controller = new MessageController($pdo);
$controller->deleteMessage($_DELETE['id']);
exit;
?>