<?php 

     class ServiceModel {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function getAllServices() {
            $stmt = $this->pdo->prepare("SELECT * FROM services");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>