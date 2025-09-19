<?php
// models/Utilisateur.php
require_once __DIR__ . "/../db/connexion.php";

class Utilisateur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT id, nom, email, role FROM utilisateurs");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
         
     // Récupérer un utilisateur par ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($nom, $email, $password, $role = "client") {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO utilisateurs (nom, email, password, role)
                                     VALUES (:nom, :email, :password, :role)");
        return $stmt->execute([
            'nom' => $nom,
            'email' => $email,
            'password' => $hash,
            'role' => $role
        ]);
    }

    // Mettre à jour le profil d'un utilisateur
    public function update($id, $nom, $prenom, $email, $telephone, $adresse) {
        $stmt = $this->pdo->prepare("UPDATE utilisateur 
                                     SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, adresse = :adresse 
                                     WHERE id = :id");
        return $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone,
            'adresse' => $adresse,
            'id' => $id
        ]);
    }

    // Supprimer un utilisateur
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}