<?php
session_start();
header('Content-Type: application/json');

require_once '../../../config/database.php';

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'etudiant') {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}

try {
    // Récupérer toutes les disponibilités réservées par l'étudiant
    $stmt = $pdo->prepare("
        SELECT 
            d.id,
            d.date_creneau,
            d.heure_debut,
            d.duree_minutes,
            d.statut,
            d.notes,
            s.nom_service as service_nom,
            CONCAT(u.prenom, ' ', u.nom) as tuteur_nom
        FROM disponibilites d
        INNER JOIN services s ON d.service_id = s.id
        INNER JOIN utilisateurs u ON d.tuteur_id = u.id
        WHERE d.client_id = :client_id
        ORDER BY d.date_creneau DESC, d.heure_debut DESC
    ");
    
    $stmt->execute(['client_id' => $_SESSION['user_id']]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'reservations' => $reservations
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur: ' . $e->getMessage()
    ]);
}