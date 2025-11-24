<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/CreneauModel.php';
require_once __DIR__ . '/../../../controller/CreneauController.php';

$serviceId = $_GET['service_id'] ?? null;

if (!$serviceId) {
    echo json_encode(['error' => 'Service ID manquant']);
    exit;
}

$controller = new CreneauController($pdo);
$creneaux = $controller->getCreneauxByService($serviceId);

echo json_encode($creneaux);
exit;
?>