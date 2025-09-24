<?php
require_once __DIR__ . '/../db/connexion.php';

class Utilisateur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

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

    // Récupérer un utilisateur par email
    public function getByEmail($email) {
        $sql = "SELECT * FROM Utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
