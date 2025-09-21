<?php
class Intervention {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer toutes les interventions liées aux rendez-vous d’un technicien
    public function getByTechnicien($technicienId) {
        $sql = "SELECT i.*, rv.date AS rv_date, rv.heure AS rv_heure, 
                       u.nom AS client_nom, u.prenom AS client_prenom, 
                       s.type AS service_type
                FROM Intervention i
                JOIN RendezVous rv ON i.rendezvous_id = rv.id
                JOIN Utilisateur u ON rv.client_id = u.id
                JOIN Service s ON rv.service_id = s.id
                WHERE rv.technicien_id = ?
                ORDER BY rv.date ASC, rv.heure ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$technicienId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une intervention
    public function create($rendezvous_id, $date_debut, $date_fin, $observations, $statut) {
        $sql = "INSERT INTO Intervention (rendezvous_id, date_debut, date_fin, observations, statut)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$rendezvous_id, $date_debut, $date_fin, $observations, $statut]);
    }

    // Mettre à jour une intervention
    public function update($id, $date_debut, $date_fin, $observations, $statut) {
        $sql = "UPDATE Intervention 
                SET date_debut=?, date_fin=?, observations=?, statut=? 
                WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$date_debut, $date_fin, $observations, $statut, $id]);
    }

    // Récupérer une intervention par id
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Intervention WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
