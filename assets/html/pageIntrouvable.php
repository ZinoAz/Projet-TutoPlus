<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page introuvable - Tuto+</title>
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

        <h1>Erreur 404 – Page introuvable</h1>

        <div class="info-box">
            <p>
                <strong>La page que vous recherchez n'existe pas ou a été déplacée.</strong><br>
                Vérifiez l’URL ou retournez à l’accueil du site.
            </p>

            <p>
                <a href="index.php" style="color:#c0392b; font-weight:bold;">Retourner à l’accueil</a>
            </p>
        </div>

    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
