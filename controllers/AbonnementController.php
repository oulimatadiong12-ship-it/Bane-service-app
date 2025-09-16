<?php
require_once 'models/Abonnement.php';
require_once 'models/PaiementAbonnement.php';

class AbonnementController {

    public function ajouter($client_id, $date_debut, $date_fin) {
        $abonnement = new Abonnement($client_id, $date_debut, $date_fin);
        
        return $abonnement;
    }

    public function renouveler($abonnement, $nouvelle_date_fin) {
        $abonnement->setStatut("actif");
       
        return $abonnement;
    }

    public function suspendre($abonnement) {
        $abonnement->setStatut("suspendu");
       
        return $abonnement;
    }

    public function payer($abonnement_id, $montant) {
        $paiement = new PaiementAbonnement($abonnement_id, $montant, date("Y-m-d"));
        
        return $paiement;
    }

    public function liste() {
       
        $pdo = new PDO('mysql:host=localhost;dbname=ta_base', 'user', 'password');
        $sql = "SELECT a.id, a.formule, a.prix, a.date_debut, a.date_fin, a.statut, 
                       u.nom, u.prenom
                FROM abonnements a
                JOIN utilisateurs u ON a.utilisateur_id = u.id";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
