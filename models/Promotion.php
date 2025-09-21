<?php
// models/Promotion.php

class Promotion {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les promotions
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM promotion ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les promotions actives
    public function getActive() {
        $stmt = $this->pdo->prepare("
            SELECT * FROM promotion 
            WHERE statut='active' 
            AND date_fin >= CURDATE() 
            ORDER BY date_debut DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une promotion par ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM promotion WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer une promotion
    public function create($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO promotion (titre, description, image_path, type, date_debut, date_fin, statut) 
            VALUES (?,?,?,?,?,?,?)
        ");
        $stmt->execute([
            $data['titre'],
            $data['description'],
            $data['image_path'] ?? null,
            $data['type'],
            $data['date_debut'],
            $data['date_fin'],
            $data['statut'] ?? 'active'
        ]);
    }

    // Mettre à jour une promotion
    public function update($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE promotion 
            SET titre=?, description=?, image_path=?, type=?, date_debut=?, date_fin=?, statut=? 
            WHERE id=?
        ");
        $stmt->execute([
            $data['titre'],
            $data['description'],
            $data['image_path'] ?? null,
            $data['type'],
            $data['date_debut'],
            $data['date_fin'],
            $data['statut'],
            $id
        ]);
    }

    // Supprimer une promotion
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM promotion WHERE id=?");
        $stmt->execute([$id]);
    }
}