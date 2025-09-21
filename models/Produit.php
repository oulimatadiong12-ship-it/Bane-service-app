<?php
// models/Produit.php

class Produit {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Créer un produit
    public function create($nom, $prix, $description, $image = null) {
        $sql = "INSERT INTO produits (nom, prix, description, image) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nom, $prix, $description, $image]);
    }

    // Modifier un produit
    public function update($id, $nom, $prix, $description, $image = null) {
        $sql = "UPDATE produits SET nom=?, prix=?, description=?, image=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nom, $prix, $description, $image, $id]);
    }

    // Supprimer un produit
    public function delete($id) {
        $sql = "DELETE FROM produits WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Récupérer tous les produits
    public function getAll() {
        $sql = "SELECT * FROM produits ORDER BY created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }

    // Rechercher des produits
    public function search($keyword) {
        $sql = "SELECT * FROM produits WHERE nom LIKE ? OR description LIKE ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $like = "%" . $keyword . "%";
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll();
    }

    // Gestion de l'image
    public function getImagePath($image) {
        $default = "https://via.placeholder.com/300x200?text=Pas+d'image";
        $path = __DIR__ . "/../uploads/produits/" . $image;
        if (!empty($image) && file_exists($path)) {
            return BASE_URL . "/uploads/produits/" . htmlspecialchars($image);
        }
        return $default;
    }
}
?>
