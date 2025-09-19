<?php

class Abonnement {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer tous les abonnements avec infos utilisateur (soft delete)
    public function getAll() {
        $sql = "SELECT a.id, a.formule, a.prix, a.date_debut, a.date_fin, a.statut, u.nom, u.prenom
            FROM abonnement a
            JOIN utilisateur u ON a.utilisateur_id = u.id
            WHERE a.statut != 'supprimé'
            ORDER BY a.date_debut DESC";
       return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    // Ajouter un abonnement
    public function create($utilisateur_id, $formule, $prix, $date_debut, $date_fin) {
        $sql = "INSERT INTO abonnement (utilisateur_id, formule, prix, date_debut, date_fin, statut) 
                VALUES (?, ?, ?, ?, ?, 'actif')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$utilisateur_id, $formule, $prix, $date_debut, $date_fin]);
    }

    // Renouveler un abonnement
    public function renew($id, $nouvelle_date_fin) {
        $sql = "UPDATE abonnement SET date_fin = ?, statut='actif' WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nouvelle_date_fin, $id]);
    }

    // Suspendre un abonnement
    public function suspend($id) {
        $sql = "UPDATE abonnement SET statut='suspendu' WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Supprimer un abonnement
    public function delete($id) {
    $sql = "UPDATE abonnement SET statut = 'supprimé' WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$id]);
}

}
?>
