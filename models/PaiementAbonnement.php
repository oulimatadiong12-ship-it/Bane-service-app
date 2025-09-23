<?php
class PaiementAbonnement {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Ajouter un paiement
    public function create($abonnement_id, $montant, $date_paiement, $prochain_paiement = null) {
        $stmt = $this->db->prepare("INSERT INTO PaiementAbonnement (abonnement_id, montant, date_paiement, prochain_paiement)
                                    VALUES (:aboId, :montant, :datePaiement, :prochainPaiement)");
        return $stmt->execute([
            'aboId' => $abonnement_id,
            'montant' => $montant,
            'datePaiement' => $date_paiement,
            'prochainPaiement' => $prochain_paiement
        ]);
    }

    // Récupérer les paiements d’un abonnement
    public function getByAbonnement($abonnement_id) {
        $stmt = $this->db->prepare("SELECT * FROM PaiementAbonnement 
                                    WHERE abonnement_id = :aboId
                                    ORDER BY date_paiement DESC");
        $stmt->execute(['aboId' => $abonnement_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les paiements d’un utilisateur via ses abonnements
    public function getByUser($userId) {
        $stmt = $this->db->prepare("SELECT p.* 
                                    FROM PaiementAbonnement p
                                    JOIN Abonnement a ON p.abonnement_id = a.id
                                    WHERE a.utilisateur_id = :userId
                                    ORDER BY p.date_paiement DESC");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
