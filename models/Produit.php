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
        $produits = $this->db->query($sql)->fetchAll();

        foreach ($produits as &$p) {
            $p['image_url'] = $this->getImageUrl($p['image']);
            $p['image_alt'] = empty($p['image'])
                ? "Pas d'image pour " . htmlspecialchars($p['nom'])
                : "Image du produit " . htmlspecialchars($p['nom']);
        }

        return $produits;
    }

    // ------------------------
    // Récupérer un produit par ID
    // ------------------------
    public function getById($id) {
        $sql = "SELECT * FROM produits WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $p = $stmt->fetch();

        if ($p) {
            $p['image_url'] = $this->getImageUrl($p['image']);
            $p['image_alt'] = empty($p['image'])
                ? "Pas d'image pour " . htmlspecialchars($p['nom'])
                : "Image du produit " . htmlspecialchars($p['nom']);
        }

        return $p;
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
        $produits = $stmt->fetchAll();

        foreach ($produits as &$p) {
            $p['image_url'] = $this->getImageUrl($p['image']);
            $p['image_alt'] = empty($p['image'])
                ? "Pas d'image pour " . htmlspecialchars($p['nom'])
                : "Image du produit " . htmlspecialchars($p['nom']);
        }

        return $produits;
    }

    // ------------------------
    // Gestion des images
    // ------------------------
    private function getImageUrl($image) {
        $imagePath = __DIR__ . "/../uploads/produits/" . $image;

        if (!empty($image) && file_exists($imagePath)) {
            return BASE_URL . "/uploads/produits/" . $image;
        }

        return "https://via.placeholder.com/300x200?text=Pas+d'image";
    }
}
