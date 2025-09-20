<?php
// models/Utilisateur.php
require_once __DIR__ . "/../db/connexion.php";

class Utilisateur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT id, nom, prenom, email, role FROM Utilisateur");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM Utilisateur WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($nom, $prenom, $email, $password, $role = "client") {
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
        if (!$email) return false;

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO Utilisateur (nom, prenom, email, password, role)
                                     VALUES (:nom, :prenom, :email, :password, :role)");
        return $stmt->execute([
            'nom' => trim($nom),
            'prenom' => !empty($prenom) ? trim($prenom) : null,
            'email' => $email,
            'password' => $hash,
            'role' => $role
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Utilisateur WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
