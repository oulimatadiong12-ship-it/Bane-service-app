<?php
class Utilisateur {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // 🔹 Récupérer tous les utilisateurs
    public function getAll() {
        $stmt = $this->db->query("SELECT id, nom, prenom, email, role FROM Utilisateur ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Récupérer un utilisateur par ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Utilisateur WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 Récupérer un utilisateur par email
    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM Utilisateur WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 Ajouter un utilisateur avec vérification d'email
    public function add($nom, $prenom, $email, $password, $role = 'client') {
        // Vérifier si l'email existe déjà
        if ($this->getByEmail($email)) {
            return false; // Email déjà utilisé
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO Utilisateur (nom, prenom, email, password, role) 
                                    VALUES (:nom, :prenom, :email, :password, :role)");
        return $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $hash,
            'role' => $role
        ]);
    }

    // 🔹 Mettre à jour un utilisateur
    public function update($id, $nom, $prenom, $email, $telephone = null, $adresse = null) {
        $stmt = $this->db->prepare("UPDATE Utilisateur 
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

    // 🔹 Supprimer un utilisateur
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Utilisateur WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // 🔹 Récupérer uniquement clients et abonnés
    public function getAllClients() {
        $stmt = $this->db->query("
            SELECT id, nom, prenom, email, telephone, role 
            FROM Utilisateur 
            WHERE role = 'client' OR role = 'abonne'
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
