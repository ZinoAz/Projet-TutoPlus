<?php
session_start();
header('Content-Type: application/json');
require_once '../../../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

$stmt = $pdo->prepare("UPDATE disponibilites SET statut='disponible', client_id=NULL WHERE id=? AND client_id=?");
$stmt->execute([$data['id'], $_SESSION['user_id']]);

echo json_encode(['success' => true, 'message' => 'Réservation annulée']);