<?php
class PaiementAbonnement {
    private $id;
    private $abonnement_id;
    private $montant;
    private $date_paiement;

    public function __construct($abonnement_id, $montant, $date_paiement) {
        $this->abonnement_id = $abonnement_id;
        $this->montant = $montant;
        $this->date_paiement = $date_paiement;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getAbonnementId() { return $this->abonnement_id; }
    public function getMontant() { return $this->montant; }
    public function getDatePaiement() { return $this->date_paiement; }

    // Setter 
    public function setId($id) { $this->id = $id; }
}