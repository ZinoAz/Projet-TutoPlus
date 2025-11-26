<?php
class AuthController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new UserModel($pdo);
    }

    // Gérer la connexion
   public function login() {
    $data = json_decode(file_get_contents('php://input'), true);

    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email et mot de passe requis']);
        return;
    }

    $user = $this->userModel->verifierConnexion($email, $password);

    if ($user === 'inactive') {
        echo json_encode([
            'success' => false,
            'message' => 'Votre compte est désactivé. Contactez un administrateur.'
        ]);
        return;
    }
    if ($user && is_array($user)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $user['type_utilisateur'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_prenom'] = $user['prenom'];
        
        echo json_encode([
            'success' => true,
            'user_type' => $user['type_utilisateur'],
            'message' => 'Connexion réussie'
        ]);
        return;
    }
    echo json_encode([
        'success' => false,
        'message' => 'Email ou mot de passe incorrect'
    ]);
}


    // Gérer l'inscription
    public function register() {
        $data = json_decode(file_get_contents('php://input'), true);

        $nom = $data['nom'] ?? '';
        $prenom = $data['prenom'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $type = $data['type_utilisateur'] ?? '';

        // Validation
        if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($type)) {
            echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
            return;
        }

        // Vérifier si l'email existe déjà
        if ($this->userModel->emailExiste($email)) {
            echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé']);
            return;
        }

        // Créer le compte
        $result = $this->userModel->creerUtilisateur($nom, $prenom, $email, $password, $type);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Compte créé avec succès'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la création du compte'
            ]);
        }
    }

    // Gérer la déconnexion
    public function logout() {
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Déconnexion réussie']);
    }
}
?>