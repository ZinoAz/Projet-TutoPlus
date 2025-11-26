<?php
    class CreneauModel {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

    // --- ADMIN : lister tous les rendez-vous (disponibilités) ---
    public function getTousLesRendezVous() {
    $sql = $this->pdo->query("
        SELECT 
            d.id,
            d.date_creneau,
            d.heure_debut,
            d.duree_minutes,
            d.notes,
            d.statut,
            d.date_creation,    
            d.tuteur_id,      
            d.client_id,       

            t.nom    AS tuteur_nom,
            t.prenom AS tuteur_prenom,

            c.nom    AS client_nom,
            c.prenom AS client_prenom

        FROM disponibilites d
        JOIN utilisateurs t      ON d.tuteur_id = t.id
        LEFT JOIN utilisateurs c ON d.client_id = c.id
        ORDER BY d.date_creneau DESC, d.heure_debut DESC
    ");

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}  
    // --- ADMIN : supprimer complètement un créneau ---
    public function supprimerDisponibilite($id) {
        $sql = $this->pdo->prepare("DELETE FROM disponibilites WHERE id = :id");
        return $sql->execute(['id' => $id]);
    }
    // --- ADMIN : libérer une réservation (remettre disponible) ---
    public function libererReservation($id) {
        $sql = $this->pdo->prepare("
            UPDATE disponibilites
            SET statut = 'disponible',
                client_id = NULL
            WHERE id = :id
        ");
        return $sql->execute(['id' => $id]);
    }

        public function getCreneauxByService($serviceId) {
            $sql = $this->pdo->prepare("
                SELECT 
                    d.*,
                    u.nom as tuteur_nom,
                    u.prenom as tuteur_prenom,
                    s.nom_service as service_nom
                FROM disponibilites d
                LEFT JOIN utilisateurs u ON d.tuteur_id = u.id AND u.type_utilisateur = 'tuteur'
                LEFT JOIN services s ON d.service_id = s.id
                WHERE d.service_id = :serviceId 
                AND d.statut = 'disponible'
                ORDER BY d.date_creneau, d.heure_debut
            ");
            $sql->execute(['serviceId' => $serviceId]);
            $results = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            $creneaux = [];
            foreach ($results as $row) {
                $tuteurNomComplet = trim(($row['tuteur_prenom'] ?? '') . ' ' . ($row['tuteur_nom'] ?? ''));
                if (empty($tuteurNomComplet)) {
                    $tuteurNomComplet = 'Non spécifié';
                }
                
                $creneaux[] = [
                    'id' => $row['id'],
                    'date' => $row['date_creneau'],
                    'heure' => $row['heure_debut'],
                    'duree' => $row['duree_minutes'],
                    'tuteur_nom' => $tuteurNomComplet,
                    'service_nom' => $row['service_nom'] ?? 'Non spécifié',
                    'commentaire' => $row['notes'] ?? ''
                ];
            }
            
            return $creneaux;
        }

        public function creerCreneau($tuteurId, $serviceId, $date, $heureDebut, $duree, $notes = null) {
            $sql = $this->pdo->prepare("
                INSERT INTO disponibilites (tuteur_id, service_id, date_creneau, heure_debut, duree_minutes, notes, statut)
                VALUES (:tuteur_id, :service_id, :date_creneau, :heure_debut, :duree_minutes, :notes, 'disponible')
            ");
            
            return $sql->execute([
                'tuteur_id' => $tuteurId,
                'service_id' => $serviceId,
                'date_creneau' => $date,
                'heure_debut' => $heureDebut,
                'duree_minutes' => $duree,
                'notes' => $notes
            ]);
        }

        public function getCreneauxByTuteur($tuteurId) {
            $sql = $this->pdo->prepare("
                SELECT 
                    d.*,
                    s.nom_service as service_nom
                FROM disponibilites d
                LEFT JOIN services s ON d.service_id = s.id
                WHERE d.tuteur_id = :tuteur_id
                ORDER BY d.date_creneau DESC, d.heure_debut DESC
            ");
            $sql->execute(['tuteur_id' => $tuteurId]);
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        public function supprimerCreneau($creneauId, $tuteurId) {
            $sql = $this->pdo->prepare("
                DELETE FROM disponibilites 
                WHERE id = :id 
                AND tuteur_id = :tuteur_id 
                AND statut = 'disponible'
            ");
            
            return $sql->execute([
                'id' => $creneauId,
                'tuteur_id' => $tuteurId
            ]);
        }

        public function reserverCreneau($creneauId, $clientId) {
            $sql = $this->pdo->prepare("
                UPDATE disponibilites 
                SET statut = 'reserve', 
                    client_id = :client_id 
                WHERE id = :id 
                AND statut = 'disponible'
            ");
            
            return $sql->execute([
                'id' => $creneauId,
                'client_id' => $clientId
            ]);
        }
    }
?>