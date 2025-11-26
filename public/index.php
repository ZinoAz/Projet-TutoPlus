<?php
    session_start();
    
    require_once __DIR__ . '/../config/database.php';

    //Model
    require_once __DIR__ . '/../models/ServiceModel.php';
    require_once __DIR__ . '/../models/CreneauModel.php';

    //Controller
    require_once __DIR__ . '/../controller/ServiceController.php';
    require_once __DIR__ . '/../controller/CreneauController.php';

    $controller = new ServiceController($pdo);
    $services = $controller->getServices();

    // ROUTER SIMPLE
    $action = $_GET['action'] ?? 'home';

    if ($action === 'tuteur') {     
        include __DIR__ . '/../assets/html/tuteurDashboard.php';
        exit;
    } else if ($action === 'client') {
        include __DIR__ . '/../assets/html/clientDashboard.php';
        exit;
    } else if ($action === 'historique') {  
        include __DIR__ . '/../assets/html/clientHistorique.php';
        exit;
    } else if ($action === 'admin') {
        include __DIR__ . '/../assets/html/adminDashboard.php';
        exit;
    }
    else if ($action === 'admin_reservations') {
    include __DIR__ . '/../assets/html/adminReservations.php';
    exit;
    } else if ($action === 'editUser') {
    include __DIR__ . '/../assets/html/editUser.php';
    exit;
    } else if ($action === 'connexion') {
        include __DIR__ . '/../assets/html/mainLogin.php';
        exit;
    } else if ($action === 'deconnexion') {
        session_destroy();
        header('Location: index.php');
        exit;
    } else if ($action === 'statistiques') {
    include __DIR__ . '/../assets/html/statistiques.php';
    exit;
    }

    $isConnected = isset($_SESSION['user_id']);
    $userType = $_SESSION['user_type'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuto+</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- HEADER -->
    <header>

        <div class="logo">
            <img src="images/logo-collège-ahuntsic.png" alt="Logo du Collège Ahuntsic">
        </div>

        <div class="bar de navigation">
            <a href="index.php">Accueil</a>
            
            <?php if ($isConnected): ?>
                <?php if ($userType === 'etudiant'): ?>
                    <a href="index.php?action=client">Espace Client</a>
                <?php elseif ($userType === 'tuteur'): ?>
                    <a href="index.php?action=tuteur">Espace Tuteur</a>
                <?php elseif ($userType === 'admin'): ?>
                    <a href="index.php?action=admin">Gestion des comptes</a>
                    <a href="index.php?action=admin_reservations">Gestion des rendez-vous</a>
                <?php endif; ?>
                <a href="index.php?action=deconnexion">Déconnexion</a>
            <?php else: ?>
                <a href="index.php?action=connexion">Connexion</a>
            <?php endif; ?>
        </div>

    </header>

    <!-- MAIN -->
    <main>

        <div class="description">
            
        <h1>Nos services</h1>

            <div class="aide-devoir">
                <h4>Aide au devoir</h4>
                <p>
                    Nous offrons une assistance personnalisée pour vos devoirs dans diverses matières, 
                    du primaire à l'université. Nos tuteurs vous accompagnent pas à pas pour comprendre 
                    les notions clés, corriger vos erreurs et renforcer votre autonomie. 
                    Que ce soit en mathématiques, en français, en sciences ou en langues, 
                    nous vous aidons à progresser efficacement tout en reprenant confiance en vos capacités.
                </p>

                <button id="découvrir">Découvrir</button>
            </div>
            
            <div class="tutorat-en-ligne">
                <h4>Tutorat en ligne</h4>
                <p>
                    Accédez à des tuteurs qualifiés depuis le confort de votre maison grâce à notre plateforme 
                    interactive. Les séances se déroulent en visioconférence avec partage d'écran et outils 
                    collaboratifs pour un apprentissage dynamique et efficace. 
                    Vous pouvez planifier vos cours selon votre emploi du temps et suivre votre progression 
                    à travers un accompagnement régulier et personnalisé.
                </p>

                <button id="savoirPlus">En savoir plus</button>
            </div>

            <div class="enseignement">
                <h4>Enseignement personnalisé</h4>
                <p>
                    Nos programmes d'enseignement sont conçus sur mesure pour répondre à vos objectifs 
                    éducatifs et à votre rythme d'apprentissage. Après une évaluation de vos besoins, 
                    nous élaborons un plan d'étude adapté, intégrant des ressources pédagogiques modernes 
                    et des exercices ciblés. Que vous souhaitiez combler des lacunes, préparer un examen 
                    ou approfondir une matière, nous vous accompagnons vers la réussite scolaire et personnelle.
                </p>

                <button id="plusInfo">Plus d'infos</button>
            </div>

        </div>

    </main>

    <!-- FOOTER -->
    <?php include '../assets/html/includes/footer.php'; ?>

</body>
</html>