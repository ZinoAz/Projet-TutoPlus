<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion / Inscription - Tuto+</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo-collège-ahuntsic.png" alt="Logo Collège Ahuntsic">
        </div>
        <nav class="bar de navigation">
            <a href="index.php">Accueil</a>
        </nav>
    </header>

    <main>
        <!-- CÔTÉ GAUCHE - CONNEXION -->
        <div class="left-side">
            <h2>Connexion</h2>
            <p class="subtitle">Connectez-vous à votre compte Tuto+</p>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" name="login" class="btn btn-primary">Se connecter</button>
            </form>
        </div>

        <!-- CÔTÉ DROIT - INSCRIPTION -->
        <div class="right-side">
            <h2>Inscription</h2>
            <p class="subtitle">Créez votre compte Tuto+</p>
            
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>

                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email_register">Email</label>
                    <input type="email" id="email_register" name="email_register" required>
                </div>

                <div class="form-group">
                    <label for="password_register">Mot de passe</label>
                    <input type="password" id="password_register" name="password_register" required>
                </div>

                <div class="form-group">
                    <div class="button-group">
                        <button type="submit" name="register_client" class="btn btn-client">S'inscrire en tant que Client</button>
                        <button type="submit" name="register_tuteur" class="btn btn-tuteur">S'inscrire en tant que Tuteur</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="js/login.js"></script>
</body>
</html>