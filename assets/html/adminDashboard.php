<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = include __DIR__ . '/../../config/database.php';

require_once __DIR__ . '/../../models/UserModel.php';

$userModel = new UserModel($pdo);

// $utilisateurs sera toujours défini (au pire : tableau vide)
$utilisateurs = $userModel->getAllUtilisateurs();

// Fonction pour formater le type d'utilisateur
function formatTypeUtilisateur($type) {
    $types = [
        'admin' => 'Admin',
        'etudiant' => 'Étudiant',
        'tuteur' => 'Tuteur'
    ];
    return isset($types[$type]) ? $types[$type] : ucfirst($type);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard admin - Tuto+</title>
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="images/logo-collège-ahuntsic.png" alt="Logo Collège Ahuntsic">
    </div>
    <nav class="bar de navigation">
        <a href="index.php">Accueil</a>
        <a href="index.php?action=admin_reservations">Gestion des Rendez-vous</a>
        <a href="index.php?action=admin">Gestion des Comptes</a>
        <a href="index.php?action=deconnexion">Déconnexion</a>
    </nav>
</header>

<main>
    <h1>Liste des comptes</h1>

    <!-- CRÉATION D'UN UTILISATEUR -->
    <div class="contact-form-wrapper">
        <h2>Créer un nouvel utilisateur</h2>
        <form id="createUserForm" method="POST" action="api/admin/createUtilisateur.php">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            
            <div class="form-group">
                <label for="type_utilisateur">Type d'utilisateur :</label>
                <select id="type_utilisateur" name="type_utilisateur" required>
                    <option value="admin">Admin</option>
                    <option value="tuteur">Tuteur</option>
                    <option value="etudiant">Étudiant</option>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-submit">Créer l'utilisateur</button>
            </div>
        </form>
    </div>

    <br >

    <hr>

    <!-- LISTE DES UTILISATEURS -->
    <section>
        <h2>Liste des utilisateurs</h2>

        <table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Date d'inscription</th>
                <th>Actif</th> 
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($utilisateurs)): ?>
                <?php foreach ($utilisateurs as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['id']) ?></td>
                        <td><?= htmlspecialchars($u['nom']) ?></td>
                        <td><?= htmlspecialchars($u['prenom']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars(formatTypeUtilisateur($u['type_utilisateur'])) ?></td>
                        <td><?= htmlspecialchars($u['date_creation']) ?></td>
                        
                        <td>
                            <input type="checkbox"
                                   class="toggle-actif"
                                   data-id="<?= (int)$u['id'] ?>"
                                   <?= !empty($u['actif']) ? 'checked' : '' ?>>
                        </td>
                        
                        <td>
                            <!-- Bouton modifier -->
                            <form action="index.php" method="GET" style="display:inline;">
                                <input type="hidden" name="action" value="editUser">
                                <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                                <button type="submit">Modifier</button>
                            </form>
                            <br>
                            <!-- Bouton supprimer -->
                            <form method="POST"
                                  action="api/admin/deleteUtilisateur.php"
                                  style="display:inline"
                                  onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8">Aucun utilisateur trouvé.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script src="js/clientCreneau.js"></script>
<script src="js/adminActivation.js"></script>
</body>
</html>