<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'envoi - Tuto+</title>
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body>

    <header>
        <?php include __DIR__ . '/includes/header.php'; ?>
        
        <nav class="bar de navigation">
            <a href="index.php">Accueil</a>
            <a href="index.php?action=client">Réserver une Séance</a>
            <a href="index.php?action=historique">Mon Historique</a>
            <a href="index.php?action=formulaireContact">Contacter un Tuteur</a>
            <a href="index.php?action=deconnexion">Déconnexion</a>
        </nav>
    </header>

    <main class="confirmation-container">

        <h1>Message envoyé avec succès</h1>

        <div class="info-box">
            <p><strong>Votre message a été envoyé !</strong> Le tuteur recevra votre message et vous répondra dans les plus brefs délais. Vous pouvez consulter les détails de votre message ci-dessous.</p>
        </div>

        <div class="reservation-details">
            <h2>Détails du message</h2>

            <table>
                <thead>
                    <tr>
                        <th>Destinataire</th>
                        <th>Sujet</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($_GET['tuteur'] ?? '') ?></td>
                        <td><?= htmlspecialchars($_GET['sujet'] ?? '') ?></td>
                        <td><?= htmlspecialchars($_GET['message'] ?? '') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="index.php?action=formulaireContact" style="display: inline-block; background: #c8102e; color: white; padding: 0.8rem 2rem; text-decoration: none; border-radius: 5px;">Envoyer un autre message</a>
        </div>

    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>