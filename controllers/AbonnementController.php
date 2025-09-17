<?php
require_once 'models/Abonnement.php';
require_once 'models/PaiementAbonnement.php';

class AbonnementController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function ajouter($client_id, $date_debut, $date_fin) {
        $abonnement = new Abonnement($client_id, $date_debut, $date_fin);
        $sql = "INSERT INTO abonnements (utilisateur_id, date_debut, date_fin, statut) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$client_id, $date_debut, $date_fin, 'actif']);
        $abonnement->setId($this->pdo->lastInsertId());
        $abonnement->setStatut('actif');
        return $abonnement;
    }

    public function renouveler($abonnement_id, $nouvelle_date_fin) {
        $sql = "UPDATE abonnements SET date_fin = ?, statut = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nouvelle_date_fin, 'actif', $abonnement_id]);
        // Charge l’abonnement mis à jour
        return $this->getAbonnement($abonnement_id);
    }

    public function suspendre($abonnement_id) {
        $sql = "UPDATE abonnements SET statut = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['suspendu', $abonnement_id]);
        return $this->getAbonnement($abonnement_id);
    }

    public function payer($abonnement_id, $montant) {
        $paiement = new PaiementAbonnement($abonnement_id, $montant, date("Y-m-d"));
        $sql = "INSERT INTO paiements_abonnement (abonnement_id, montant, date_paiement) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$abonnement_id, $montant, $paiement->getDatePaiement()]);
        $paiement->setId($this->pdo->lastInsertId());
        return $paiement;
    }

    public function liste() {
        $sql = "SELECT a.id, a.formule, a.prix, a.date_debut, a.date_fin, a.statut, u.nom, u.prenom
                FROM abonnements a
                JOIN utilisateurs u ON a.utilisateur_id = u.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getAbonnement($id) {
        $sql = "SELECT * FROM abonnements WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $abonnement = new Abonnement($data['utilisateur_id'], $data['date_debut'], $data['date_fin']);
            $abonnement->setId($data['id']);
            $abonnement->setStatut($data['statut']);
            return $abonnement;
        }
        
    }
}