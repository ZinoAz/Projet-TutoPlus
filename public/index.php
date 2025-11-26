<?php
session_start();

require_once __DIR__ . '/../config/database.php';

// Model
require_once __DIR__ . '/../models/ServiceModel.php';
require_once __DIR__ . '/../models/CreneauModel.php';

// Controller
require_once __DIR__ . '/../controller/ServiceController.php';
require_once __DIR__ . '/../controller/CreneauController.php';

// Chargement des services
$controller = new ServiceController($pdo);
$services = $controller->getServices();

// Vérification de connexion
$isConnected = isset($_SESSION['user_id']);
$userType = $_SESSION['user_type'] ?? null;

/**
 * Vérifie si un utilisateur est du bon type.
 * Redirige vers la page de connexion si non autorisé.
 */
function requireUserType($expectedType) {
    global $isConnected, $userType;

    if (!$isConnected) {
        header("Location: index.php?action=connexion");
        exit;
    }

    if ($userType !== $expectedType) {
        throw new Exception("Forbidden", 403);
    }
}

// ROUTER
$action = $_GET['action'] ?? 'home';
$pageContent = null;

try {

    switch ($action) {

        // === ESPACE TUTEUR ===
        case 'tuteur':
            requireUserType('tuteur');
            $pageContent = __DIR__ . '/../assets/html/tuteurDashboard.php';
            break;

        case 'gestionDemande':
            requireUserType('tuteur');
            $pageContent = __DIR__ . '/../assets/html/gestionDemande.php';
            break;

        // === ESPACE ÉTUDIANT ===
        case 'client':
            requireUserType('etudiant');
            $pageContent = __DIR__ . '/../assets/html/clientDashboard.php';
            break;

        case 'historique':
            requireUserType('etudiant');
            $pageContent = __DIR__ . '/../assets/html/clientHistorique.php';
            break;

        case 'confirmationReservation':
            requireUserType('etudiant');

            if (isset($_GET['creneau_id'])) {
                $creneauId = (int) $_GET['creneau_id'];
                $creneauController = new CreneauController($pdo);
                $creneau = $creneauController->getCreneauById($creneauId);
                $pageContent = __DIR__ . '/../assets/html/confirmationReservation.php';
            }
            break;

        // === ADMIN ===
        case 'admin':
            requireUserType('admin');
            $pageContent = __DIR__ . '/../assets/html/adminDashboard.php';
            break;

        case 'admin_reservations':
            requireUserType('admin');
            $pageContent = __DIR__ . '/../assets/html/adminReservations.php';
            break;

        case 'editUser':
            requireUserType('admin');
            $pageContent = __DIR__ . '/../assets/html/editUser.php';
            break;

        case 'statistiques':
            requireUserType('tuteur');
            $pageContent = __DIR__ . '/../assets/html/statistiques.php';
            break;

        // PUBLIC
        case 'connexion':
            $pageContent = __DIR__ . '/../assets/html/mainLogin.php';
            break;

        case 'deconnexion':
            session_destroy();
            header('Location: index.php');
            exit;

        // Page d'accueil
        case 'home':
            $pageContent = null; // Affiche le contenu HTML en bas
            break;

        // Action introuvable
        default:
            throw new Exception("Page not found", 404);
    }

} catch (Exception $e) {

    if ($e->getCode() === 403) {
        http_response_code(403);
        $pageContent = __DIR__ . '/../assets/html/nonAutorise.php';
    } elseif ($e->getCode() === 404) {
        http_response_code(404);
        $pageContent = __DIR__ . '/../assets/html/pageIntrouvable.php';
    } else {
        throw $e;
    }
}

// Si une page spécifique doit être chargée, on l'affiche puis on stoppe l'exécution
if ($pageContent !== null) {
    include $pageContent;
    exit;
}
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

        <?php include __DIR__ . '/../assets/html/includes/header.php'; ?>

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