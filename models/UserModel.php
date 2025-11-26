<?php
class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Vérifier les identifiants de connexion
    public function verifierConnexion($email, $password) {
    $sql = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $sql->execute(['email' => $email]);
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    }
    if (isset($user['actif']) && $user['actif'] == 0) {
        return 'inactive';
    }
    if (password_verify($password, $user['mot_de_passe'])) {
        return $user;
    }
    return false;
}


    // Vérifier si l'email existe déjà
    public function emailExiste($email) {
        $sql = $this->pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
        $sql->execute(['email' => $email]);
        return $sql->fetch() !== false;
    }

    // Créer un nouvel utilisateur
    public function creerUtilisateur($nom, $prenom, $email, $password, $type) {
        $sql = $this->pdo->prepare("
            INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, type_utilisateur) 
            VALUES (:nom, :prenom, :email, :mot_de_passe, :type)
        ");
        
        return $sql->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'mot_de_passe' => password_hash($password, PASSWORD_DEFAULT),
            'type' => $type
        ]);
    }

    // Récupérer un utilisateur par son ID
    public function getUserById($id) {
        $sql = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id");
        $sql->execute(['id' => $id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

     public function getAllUtilisateurs() {
        $sql = $this->pdo->query("
            SELECT id, nom, prenom, email, type_utilisateur, date_creation, actif
            FROM utilisateurs
            ORDER BY id ASC
        ");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
     // Mettre à jour un utilisateur existant
    public function mettreAJourUtilisateur($id, $nom, $prenom, $email, $type) {
        $sql = $this->pdo->prepare("
            UPDATE utilisateurs
            SET nom = :nom,
                prenom = :prenom,
                email = :email,
                type_utilisateur = :type
            WHERE id = :id
        ");

        return $sql->execute([
            'id'    => $id,
            'nom'   => $nom,
            'prenom'=> $prenom,
            'email' => $email,
            'type'  => $type,
        ]);
    }

    // Supprimer un utilisateur
    public function supprimerUtilisateur($id) {
        $sql = $this->pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
        return $sql->execute(['id' => $id]);
    }

    //mettre utilisateur actif/inactif
    public function setActif($id, $actif) {
    $sql = $this->pdo->prepare("
        UPDATE utilisateurs
        SET actif = :actif
        WHERE id = :id
    ");
    return $sql->execute([
        'id'    => $id,
        'actif' => $actif
    ]);
}

}
?>