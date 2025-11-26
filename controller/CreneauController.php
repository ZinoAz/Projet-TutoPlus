<?php
class CreneauController {
    private $creneauModel;

    public function __construct($pdo) {
        $this->creneauModel = new CreneauModel($pdo);
    }

    public function getCreneauxByService($serviceId) {
        return $this->creneauModel->getCreneauxByService($serviceId);
    }

    public function creerCreneau() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Non connecté']);
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $tuteurId = $_SESSION['user_id'];
        
        $result = $this->creneauModel->creerCreneau(
            $tuteurId,
            $data['service_id'],
            $data['date'],
            $data['heure'],
            $data['duree'],
            $data['commentaire'] ?? null
        );
        
        echo json_encode(['success' => $result, 'message' => 'Créneau ajouté']);
    }

    public function getMesCreneaux() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Non connecté']);
            return;
        }
        
        $tuteurId = $_SESSION['user_id'];
        $creneaux = $this->creneauModel->getCreneauxByTuteur($tuteurId);
        echo json_encode(['success' => true, 'creneaux' => $creneaux]);
    }

    public function supprimerCreneau() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Non connecté']);
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $tuteurId = $_SESSION['user_id'];
        
        $result = $this->creneauModel->supprimerCreneau($data['creneau_id'], $tuteurId);
        
        echo json_encode(['success' => $result, 'message' => 'Créneau supprimé']);
    }

    public function reserverCreneau() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Non connecté']);
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $clientId = $_SESSION['user_id'];
        
        $result = $this->creneauModel->reserverCreneau($data['creneau_id'], $clientId);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Créneau réservé avec succès']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la réservation']);
        }
    }

  // --- ADMIN ---
    public function getTousLesRendezVous() {
        return $this->creneauModel->getTousLesRendezVous();
    }

    public function supprimerDisponibilite($id) {
        return $this->creneauModel->supprimerDisponibilite($id);
    }

    public function libererReservation($id) {
        return $this->creneauModel->libererReservation($id);
    }

}
?> 