<?php
// models/Produit.php

class Produit {
    private $db;

    public function __construct($db = null) {
        if ($db) {
            $this->db = $db;
        } else {
            require_once __DIR__ . '/../db/connexion.php';
            $this->db = $pdo;
        }
    }

    // Créer un produit
    public function create($libelle, $categorie, $prixAchat, $prixVente, $stock, $seuilAlerte, $description, $fournisseur) {
        $sql = "INSERT INTO Produit (libelle, categorie, prixAchat, prixVente, stock, seuil_alerte, description, fournisseur)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $libelle, $categorie, $prixAchat, $prixVente, $stock, $seuilAlerte, $description, $fournisseur
        ]);
    }

    // Modifier un produit
    public function update($id, $libelle, $categorie, $prixAchat, $prixVente, $stock, $seuilAlerte, $description, $fournisseur) {
        $sql = "UPDATE Produit SET 
                    libelle = ?, 
                    categorie = ?, 
                    prixAchat = ?, 
                    prixVente = ?, 
                    stock = ?, 
                    seuil_alerte = ?, 
                    description = ?, 
                    fournisseur = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $libelle, $categorie, $prixAchat, $prixVente, $stock, $seuilAlerte, $description, $fournisseur, $id
        ]);
    }

    // Supprimer un produit
    public function delete($id) {
        $sql = "DELETE FROM Produit WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Récupérer tous les produits
    public function getAllProduits() {
        $sql = "SELECT * FROM Produit ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un produit par ID
    public function getProduitById($id) {
        $sql = "SELECT * FROM Produit WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Rechercher un produit
    public function search($keyword) {
        $sql = "SELECT * FROM Produit WHERE libelle LIKE ? OR description LIKE ?";
        $stmt = $this->db->prepare($sql);
        $like = "%$keyword%";
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
