<?php
class RendezVous {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer tous les rendez-vous pour un technicien
    public function getByTechnicien($technicienId) {
        $sql = "SELECT rv.*, 
                       u.nom AS client_nom, u.prenom AS client_prenom, 
                       s.type AS service_type
                FROM RendezVous rv
                JOIN Utilisateur u ON rv.client_id = u.id
                JOIN Service s ON rv.service_id = s.id
                WHERE rv.technicien_id = ?
                ORDER BY rv.date ASC, rv.heure ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$technicienId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre à jour le statut du rendez-vous
    public function updateStatut($id, $statut) {
        $stmt = $this->db->prepare("UPDATE RendezVous SET statut=? WHERE id=?");
        return $stmt->execute([$statut, $id]);
    }

    // Récupérer un rendez-vous par id
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM RendezVous WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
