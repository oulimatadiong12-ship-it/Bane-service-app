<?php
// models/LigneCommande.php

class LigneCommande {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Ajouter une ligne de commande
    public function create($commande_id, $produit_id, $quantite, $prix_unitaire) {
        $stmt = $this->pdo->prepare("
            INSERT INTO lignecommande (commande_id, produit_id, quantite, prix_unitaire) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$commande_id, $produit_id, $quantite, $prix_unitaire]);
    }

    // Récupérer les lignes d'une commande
    public function getByCommande($commande_id) {
        $stmt = $this->pdo->prepare("
            SELECT lc.*, p.nom as produit_nom, p.image
            FROM lignecommande lc
            LEFT JOIN produits p ON lc.produit_id = p.id
            WHERE lc.commande_id = ?
        ");
        $stmt->execute([$commande_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer les lignes d'une commande
    public function deleteByCommande($commande_id) {
        $stmt = $this->pdo->prepare("DELETE FROM lignecommande WHERE commande_id = ?");
        return $stmt->execute([$commande_id]);
    }
}