<?php 

class MessageModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createMessage($client_id, $tuteur_id, $sujet, $message) {
        $stmt = $this->pdo->prepare("INSERT INTO messages (client_id, tuteur_id, sujet, message) 
                                      VALUES (:client_id, :tuteur_id, :sujet, :message)");
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':tuteur_id', $tuteur_id);
        $stmt->bindParam(':sujet', $sujet);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }

    public function getAllMessages() {
        $stmt = $this->pdo->prepare("SELECT * FROM messages ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessageById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMessagesByClientId($client_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE client_id = :client_id ORDER BY id DESC");
        $stmt->bindParam(':client_id', $client_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessagesByTuteurId($tuteur_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE tuteur_id = :tuteur_id ORDER BY id DESC");
        $stmt->bindParam(':tuteur_id', $tuteur_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteMessage($id) {
        $stmt = $this->pdo->prepare("DELETE FROM messages WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

?>