<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacter un Tuteur - Tuto+</title>
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
        <h1>Contacter un tuteur</h1>

        <div class="info-box">
            <p>Consultez la liste des tuteurs disponibles ci-dessous et cliquez sur le tuteur pour voir ses coordonnées ou le contacter.</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tuteurListe">
                <tr><td colspan="4">Chargement...</td></tr>
            </tbody>
        </table>

        <div class="contact-form-wrapper" style="display: none;">
            <h2>Envoyer un message à <span id="tuteurNom"></span></h2>

            <form id="contactForm">
                <input type="hidden" id="tuteurId" name="tuteurId">

                <div class="form-group">
                    <label for="nom">Votre nom :</label>
                    <input type="text" id="nom" name="nom" required>
                </div>

                <div class="form-group">
                    <label for="prenom">Votre prénom :</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>

                <div class="form-group">
                    <label for="sujet">Sujet :</label>
                    <input type="text" id="sujet" name="sujet" required>
                </div>

                <div class="form-group">
                    <label for="message">Message :</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Envoyer</button>
                    <button type="button" id="cancelFormBtn" class="btn-cancel">Annuler</button>
                </div>
            </form>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="js/formulaire.js"></script>
</body>
</html>