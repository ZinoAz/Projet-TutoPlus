<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = include __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/UserModel.php';

$userModel = new UserModel($pdo);

$id = (int)($_GET['id'] ?? 0);
$utilisateur = $id > 0 ? $userModel->getUserById($id) : null;

if (!$utilisateur) {
    header('Location: ../../public/index.php?action=admin');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur - Tuto+</title>
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="images/logo-collège-ahuntsic.png" alt="Logo Collège Ahuntsic">
    </div>
    <nav class="bar de navigation">
        <a href="index.php?action=admin">Retour au dashboard</a>
    </nav>
</header>

<main>
    <h1>Modifier l'utilisateur #<?= htmlspecialchars($utilisateur['id']) ?></h1>

    <form method="POST" action="api/admin/updateUtilisateur.php">
        <input type="hidden" name="id" value="<?= (int)$utilisateur['id'] ?>">

        <div>
            <label>Nom :</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($utilisateur['nom']) ?>" required>
        </div>
        <div>
            <label>Prénom :</label>
            <input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur['prenom']) ?>" required>
        </div>
        <div>
            <label>Email :</label>
            <input type="email" name="email" value="<?= htmlspecialchars($utilisateur['email']) ?>" required>
        </div>
        <div>
            <label>Type d'utilisateur :</label>
            <select name="type_utilisateur" required>
                <option value="admin"   <?= $utilisateur['type_utilisateur']==='admin'   ? 'selected' : '' ?>>Admin</option>
                <option value="tuteur"  <?= $utilisateur['type_utilisateur']==='tuteur'  ? 'selected' : '' ?>>Tuteur</option>
                <option value="etudiant"<?= $utilisateur['type_utilisateur']==='etudiant'? 'selected' : '' ?>>Étudiant</option>
            </select>
        </div>

        <button type="submit">Enregistrer les modifications</button>
    </form>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
