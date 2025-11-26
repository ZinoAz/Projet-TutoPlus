<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès refusé - Tuto+</title>
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body>

    <header>
        <?php include __DIR__ . '/includes/header.php'; ?>
        
        <nav class="bar de navigation">
            <a href="index.php">Accueil</a>
        </nav>
    </header>

    <main class="confirmation-container">

        <h1>Erreur 403 – Accès interdit</h1>

        <div class="info-box">
            <p>
                <strong>Vous n’avez pas l’autorisation d’accéder à cette page.</strong><br>
                Il se peut que vous n’ayez pas les permissions nécessaires, ou que votre session ait expiré.
            </p>

            <p>
                <a href="index.php" style="color:#c0392b; font-weight:bold;">Retourner à l’accueil</a>
            </p>
        </div>

    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
