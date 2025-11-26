<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Historique - Tuto+</title>
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
        <h1>Historique de mes réservations</h1>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Horaire</th>
                    <th>Durée</th>
                    <th>Service</th>
                    <th>Tuteur</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="listeHistorique">
                <tr>
                    <td colspan="6" style="text-align: center;">
                        Chargement...
                    </td>
                </tr>
            </tbody>
        </table>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="js/clientHistorique.js"></script>
</body>
</html>