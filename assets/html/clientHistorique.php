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
        <div class="logo">
            <img src="images/logo-collège-ahuntsic.png" alt="Logo Collège Ahuntsic">
        </div>
        <nav class="bar de navigation">
            <a href="index.php">Accueil</a>
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