<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/MessageModel.php';
require_once __DIR__ . '/../../../controller/MessageController.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

// Récupérer le client_id depuis la session
$client_id = $_SESSION['user_id'];
$tuteur_id = $_POST['tuteur_id'] ?? null;
$sujet = $_POST['sujet'] ?? null;
$message = $_POST['message'] ?? null;

// Validation
if (!$tuteur_id || !$sujet || !$message) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit;
}

$controller = new MessageController($pdo);
$result = $controller->createMessage($client_id, $tuteur_id, $sujet, $message);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Message envoyé avec succès']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi du message']);
}
exit;
?>