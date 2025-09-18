<?php
// models/PaiementAbonnement.php

class PaiementAbonnement {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Ajouter un paiement pour un abonnement
    public function create($abonnement_id, $montant, $date_paiement) {
        $sql = "INSERT INTO paiementabonnement (abonnement_id, montant, date_paiement) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$abonnement_id, $montant, $date_paiement]);
    }

    // Récupérer les paiements d’un abonnement
    public function getByAbonnement($abonnement_id) {
        $sql = "SELECT * FROM paiementabonnement WHERE abonnement_id=? ORDER BY date_paiement DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$abonnement_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
