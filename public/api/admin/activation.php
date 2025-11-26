<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

$pdo = include __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/UserModel.php';

$userModel = new UserModel($pdo);

// Lire le JSON envoyé par fetch()
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

if ($data === null) {
    echo json_encode([
        'success' => false,
        'message' => 'JSON invalide reçu'
    ]);
    exit;
}

$id    = isset($data['id']) ? (int)$data['id'] : 0;
$actif = !empty($data['actif']) ? 1 : 0;

if ($id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'ID utilisateur invalide'
    ]);
    exit;
}

$ok = $userModel->setActif($id, $actif);

echo json_encode([
    'success' => (bool)$ok
]);
exit;
