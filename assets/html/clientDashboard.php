<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver une séance - Tuto+</title>
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body>
    <header>
        <?php include __DIR__ . '/includes/header.php'; ?>

        <nav class="bar de navigation">
            <a href="index.php">Accueil</a>
            <a href="index.php?action=client">Réserver une Séance</a>
            <a href="index.php?action=historique">Mon Historique</a>
            <a href="index.php?action=formulaireContact">Concacter un Tuteur</a>
            <a href="index.php?action=deconnexion">Déconnexion</a>
        </nav>
    </header>

    <main>
        <h1>Réserver une séance de tutorat</h1>

        <div class="info-box">
            <p><strong>Comment ça marche :</strong> Sélectionnez un service, puis choisissez un créneau disponible parmi ceux proposés par nos tuteurs.</p>
        </div>

        <h2>Sélectionnez un service</h2>
        
        <div class="form-group">
            <label for="serviceSelect">Service de tutorat *</label>
            <select id="serviceSelect">
                <option value="">-- Choisissez un service --</option>

                <!-- Récupère la liste des services -->
                <?php foreach ($services as $service): ?>
                    <option value="<?= htmlspecialchars($service['id']) ?>">
                        <?= htmlspecialchars($service['nom_service']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <h2>Choisissez un créneau disponible</h2>

        <div id="messageCreneaux" style="text-align: center; padding: 2rem; color: #666;">
            <p>Veuillez d'abord sélectionner un service</p>
        </div>

        <div id="listeCreneaux" style="display: none;">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Horaire</th>
                        <th>Durée</th>
                        <th>Tuteur</th>
                        <th>Service</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    
    <script src="js/clientCreneau.js"></script>
</body>
</html>