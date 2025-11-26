<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = include __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/CreneauModel.php';

$model = new CreneauModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$id = $_POST['id'] : 0;

    if ($id > 0) {
        $model->supprimerDisponibilite($id);
    }

    header('Location: ../../index.php?action=admin_reservations');
    exit;
}

header('Location: ../../index.php');
exit;
