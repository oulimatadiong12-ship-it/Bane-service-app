<?php
require_once __DIR__ . '/../db/connexion.php';

class Utilisateur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer tous les utilisateurs
    public function getAll() {
        $stmt = $this->pdo->query("SELECT id, nom, prenom, email, role FROM Utilisateur");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un utilisateur par ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Utilisateur WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer un utilisateur par email
    public function getByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM Utilisateur WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un utilisateur
    public function add($nom, $prenom, $email, $password, $role = 'admin') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Utilisateur (nom, prenom, email, password, role) 
                VALUES (:nom, :prenom, :email, :password, :role)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':role' => $role
        ]);
    }
}
?>
