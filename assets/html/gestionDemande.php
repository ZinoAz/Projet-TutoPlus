<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de réservation - Tuto+</title>
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body>

    <header>
        <?php include __DIR__ . '/includes/header.php'; ?>
        
        <nav class="bar de navigation">
            <a href="index.php">Accueil</a>
            <a href="index.php?action=statistiques">Mes statistiques</a>
            <a href="index.php?action=tuteur">Mes disponibilités</a>
            <a href="index.php?action=deconnexion">Déconnexion</a>
        </nav>
    </header>

    <main class="confirmation-container">

        <h1>Réservation confirmée</h1>

        <div class="info-box">
            <p><strong>Votre réservation est confirmée !</strong> Merci d’avoir réservé votre créneau. Vous pouvez consulter les détails ci-dessous et retrouver vos réservations à tout moment dans votre historique. Pensez à noter la date et l’heure de votre rendez-vous.</p>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
