<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = include __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/UserModel.php';

$userModel = new UserModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom            = trim($_POST['nom'] ?? '');
    $prenom         = trim($_POST['prenom'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $mot_de_passe   = $_POST['mot_de_passe'] ?? '';
    $type           = $_POST['type_utilisateur'] ?? '';

    if ($nom && $prenom && $email && $mot_de_passe && $type) {
        // On peut vérifier si l'email existe déjà
        if (!$userModel->emailExiste($email)) {
            $userModel->creerUtilisateur($nom, $prenom, $email, $mot_de_passe, $type);
        }
        // sinon tu pourrais mettre un message en session
    }

    header('Location: ../../index.php?action=admin');
    exit;
}

header('Location: ../../index.php');
exit;
