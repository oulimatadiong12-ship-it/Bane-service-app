<?php
// models/Commande.php

class Commande {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les commandes (admin)
    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT c.*, u.nom, u.prenom, u.email 
            FROM commande c 
            JOIN utilisateur u ON c.utilisateur_id = u.id 
            ORDER BY c.date_commande DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public function getByUser($utilisateur_id) {
    $stmt = $this->pdo->prepare("
        SELECT c.*, u.nom, u.prenom, u.email
        FROM commande c
        JOIN utilisateur u ON c.utilisateur_id = u.id
        WHERE c.utilisateur_id = ?
        ORDER BY c.date_commande DESC
    ");
    $stmt->execute([$utilisateur_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    // Récupérer une commande par ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT c.*, u.nom, u.prenom, u.email 
            FROM commande c 
            JOIN utilisateur u ON c.utilisateur_id = u.id 
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer une commande
    public function create($utilisateur_id, $montant_total, $statut = 'en attente') {
        $stmt = $this->pdo->prepare("
            INSERT INTO commande (utilisateur_id, date_commande, montant_total, statut)
            VALUES (?, NOW(), ?, ?)
        ");
        $stmt->execute([$utilisateur_id, $montant_total, $statut]);
        return $this->pdo->lastInsertId();
    }

    // Mettre à jour le statut
    public function updateStatut($id, $statut) {
        $stmt = $this->pdo->prepare("UPDATE commande SET statut = ? WHERE id = ?");
        return $stmt->execute([$statut, $id]);
    }

    // Supprimer une commande
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM commande WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
