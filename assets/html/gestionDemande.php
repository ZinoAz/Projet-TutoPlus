<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes demandes - Tuto+</title>
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body>

    <header>
        <?php include __DIR__ . '/includes/header.php'; ?>
        
        <nav class="bar de navigation">
            <a href="index.php">Accueil</a>
            <a href="index.php?action=tuteur">Mes disponibilités</a>
            <a href="index.php?action=gestionDemande">Mes demandes</a>
            <a href="index.php?action=statistiques">Mes statistiques</a>
            <a href="index.php?action=deconnexion">Déconnexion</a>
        </nav>
    </header>

    <main class="confirmation-container">

        <h1>Mes demandes</h1>

        <div class="info-box">
            <p><strong>Voici vos demandes en cours !</strong> Vous pouvez consulter le statut de chaque réservation,
            les détails de vos créneaux et accéder à votre historique à tout moment. Pensez à vérifier régulièrement
            vos demandes pour rester à jour.</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Réservé par</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Durée</th>
                    <th>Service</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="creneauxBody">
            </tbody>
        </table>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="js/gestionDemande.js"></script>
</body>
</html>
