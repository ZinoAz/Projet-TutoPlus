<?php
class MessageController {
    private $messageModel;

    public function __construct($pdo) {
        $this->messageModel = new MessageModel($pdo);
    }

    public function createMessage($client_id, $tuteur_id, $sujet, $message) {
        return $this->messageModel->createMessage($client_id, $tuteur_id, $sujet, $message);
    }

    public function getMessages() {
        return $this->messageModel->getAllMessages();
    }

    public function getMessageById($id) {
        return $this->messageModel->getMessageById($id);
    }

    public function getMessagesByClientId($client_id) {
        return $this->messageModel->getMessagesByClientId($client_id);
    }

    public function getMessagesByTuteurId($tuteur_id) {
        return $this->messageModel->getMessagesByTuteurId($tuteur_id);
    }

    public function deleteMessage($id) {
        return $this->messageModel->deleteMessage($id);
    }
}
?>