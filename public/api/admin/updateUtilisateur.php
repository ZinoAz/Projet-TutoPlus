<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = include __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/UserModel.php';

$userModel = new UserModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id      = (int)($_POST['id'] ?? 0);
    $nom     = trim($_POST['nom'] ?? '');
    $prenom  = trim($_POST['prenom'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $type    = $_POST['type_utilisateur'] ?? '';

    if ($id > 0 && $nom && $prenom && $email && $type) {
        $userModel->mettreAJourUtilisateur($id, $nom, $prenom, $email, $type);
    }

    header('Location: ../../index.php?action=admin');
    exit;
}

header('Location: ../../index.php');
exit;
