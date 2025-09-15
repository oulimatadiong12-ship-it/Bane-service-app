<?php
class Abonnement {
    private $id;
    private $client_id;
    private $date_debut;
    private $date_fin;
    private $statut; // actif, suspendu, expiré

    public function __construct($client_id, $date_debut, $date_fin, $statut = "actif") {
        $this->client_id = $client_id;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->statut = $statut;
    }

    // Getters et setters
    public function getId() { return $this->id; }
    public function getClientId() { return $this->client_id; }
    public function getDateDebut() { return $this->date_debut; }
    public function getDateFin() { return $this->date_fin; }
    public function getStatut() { return $this->statut; }

    public function setStatut($statut) { $this->statut = $statut; }
}