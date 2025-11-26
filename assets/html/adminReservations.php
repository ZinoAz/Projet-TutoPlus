<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sécurité : seulement les admins
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: index.php?action=connexion');
    exit;
}

$pdo = include __DIR__ . '/../../config/database.php';

require_once __DIR__ . '/../../models/CreneauModel.php';
require_once __DIR__ . '/../../controller/CreneauController.php';

$creneauController = new CreneauController($pdo);
$rendezVous = $creneauController->getTousLesRendezVous();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des rendez-vous - Tuto+</title>
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="images/logo-collège-ahuntsic.png" alt="Logo Collège Ahuntsic">
    </div>
    <nav class="bar de navigation">
        <a href="index.php">Accueil</a>
        <a href="index.php?action=admin">Gestion des comptes</a>
        <a href="index.php?action=deconnexion">Déconnexion</a>
    </nav>
</header>

<main>
    <h1>Gestion des rendez-vous</h1>

    <table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tuteur</th>
            <th>Client</th>
            <th>Date</th>
            <th>Heure début</th>
            <th>Durée (min)</th>
            <th>Statut</th>
            <th>Notes</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($rendezVous)): ?>
            <?php foreach ($rendezVous as $rdv): ?>
                <tr>
                    <!-- ID -->
                    <td><?= htmlspecialchars($rdv['id']) ?></td>

                    <!-- Tuteur -->
                    <td><?= htmlspecialchars($rdv['tuteur_prenom'] . ' ' . $rdv['tuteur_nom']) ?></td>

                    <!-- Client -->
                    <td>
                        <?php if (!empty($rdv['client_id'])): ?>
                            <?= htmlspecialchars($rdv['client_prenom'] . ' ' . $rdv['client_nom']) ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <!-- Date du créneau -->
                    <td><?= htmlspecialchars($rdv['date_creneau']) ?></td>

                    <!-- Heure début -->
                    <td><?= htmlspecialchars($rdv['heure_debut']) ?></td>

                    <!-- Durée -->
                    <td><?= htmlspecialchars($rdv['duree_minutes']) ?> min</td>

                    <!-- Statut -->
                    <td><?= htmlspecialchars($rdv['statut']) ?></td>

                    <!-- Notes -->
                    <td><?= htmlspecialchars($rdv['notes']) ?></td>

                    <!-- Actions admin -->
                    <td>
                        <!-- Libérer (si réservé) -->
                        <?php if (!empty($rdv['client_id'])): ?>
                            <form action="api/admin/libererReservation.php"
                                  method="POST"
                                  style="margin-bottom: 5px;">
                                <input type="hidden" name="id" value="<?= (int)$rdv['id'] ?>">
                                <button type="submit">Libérer</button>
                            </form>
                        <?php endif; ?>

                        <!-- Supprimer -->
                        <form action="api/admin/supprimerDisponibilite.php"
                              method="POST"
                              onsubmit="return confirm('Supprimer ce créneau ?');">
                            <input type="hidden" name="id" value="<?= (int)$rdv['id'] ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="11">Aucun rendez-vous trouvé.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
