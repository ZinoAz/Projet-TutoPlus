<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/MessageModel.php';
require_once __DIR__ . '/../../../controller/MessageController.php';

$controller = new MessageController($pdo);
$messages = $controller->getMessagesByClientId($_GET['client_id']);
echo json_encode(['success' => true, 'data' => $messages]);
exit;
?>