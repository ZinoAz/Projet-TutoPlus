<?php
class ServiceController {
    private $serviceModel;

    public function __construct($pdo) {
        $this->serviceModel = new ServiceModel($pdo);
    }

    public function getServices() {
        return $this->serviceModel->getAllServices();
    }
}
?>