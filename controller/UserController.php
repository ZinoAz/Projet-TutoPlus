<?php
class UserController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new UserModel($pdo);
    }

    public function getAllTuteurs() {
        $utilisateurs = $this->userModel->getAllUtilisateurs();

        $tuteurs = array_filter($utilisateurs, function($user) {
            return $user['type_utilisateur'] === 'tuteur';
        });

        echo json_encode([
            'success' => true,
            'tuteurs' => array_values($tuteurs)
        ]);
    }
}
?>