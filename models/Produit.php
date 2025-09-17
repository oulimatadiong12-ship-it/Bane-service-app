<?php
// models/Produit.php

class Produit {
    private $db;

    // Constructeur : on passe la connexion PDO
    public function __construct($db) {
        $this->db = $db;
    }

    // ------------------------
    // Créer un produit
    // ------------------------
    public function create($nom, $prix, $description, $image) {
        $sql = "INSERT INTO produits (nom, prix, description, image) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nom, $prix, $description, $image]);
    }

    // ------------------------
    // Récupérer tous les produits
    // ------------------------
    public function getAll() {
        $sql = "SELECT * FROM produits ORDER BY created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }

    // ------------------------
    // Récupérer un produit par ID
    // ------------------------
    public function getById($id) {
        $sql = "SELECT * FROM produits WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ------------------------
    // Modifier un produit
    // ------------------------
    public function update($id, $nom, $prix, $description, $image) {
        $sql = "UPDATE produits SET nom=?, prix=?, description=?, image=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nom, $prix, $description, $image, $id]);
    }

    // ------------------------
    // Supprimer un produit
    // ------------------------
    public function delete($id) {
        $sql = "DELETE FROM produits WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

// ------------------------
// Rechercher des produits par mot-clé
// ------------------------
public function search($keyword) {
    $sql = "SELECT * FROM produits WHERE nom LIKE ? OR description LIKE ? ORDER BY created_at DESC";
    $stmt = $this->db->prepare($sql);
    $like = "%" . $keyword . "%";
    $stmt->execute([$like, $like]);
    return $stmt->fetchAll();
}




}
