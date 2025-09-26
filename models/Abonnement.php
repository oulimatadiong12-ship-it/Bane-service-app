<?php
class Abonnement {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer tous les abonnements (admin)
    public function getAll() {
        $sql = "SELECT a.id, a.formule, a.prix, a.date_debut, a.date_fin, a.statut,
                       u.nom, u.prenom
                FROM Abonnement a
                JOIN Utilisateur u ON a.utilisateur_id = u.id
                ORDER BY a.date_debut DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les abonnements d’un utilisateur
    public function getByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM Abonnement 
                                    WHERE utilisateur_id = :userId
                                    ORDER BY date_debut DESC");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer l'abonnement actif d’un utilisateur
    public function getActiveByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM Abonnement 
                                    WHERE utilisateur_id = :userId AND statut='actif'
                                    ORDER BY date_debut DESC LIMIT 1");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un abonnement
    public function create($utilisateur_id, $formule, $prix, $date_debut, $date_fin) {
        $stmt = $this->db->prepare("INSERT INTO Abonnement (utilisateur_id, formule, prix, date_debut, date_fin, statut)
                                    VALUES (:utilisateur_id, :formule, :prix, :debut, :fin, 'actif')");
        return $stmt->execute([
    ':utilisateur_id' => $utilisateur_id,
    ':formule' => $formule,
    ':prix' => $prix,
    ':debut' => $date_debut,
    ':fin' => $date_fin
]);

    }

    // Renouveler un abonnement
    public function renew($id, $nouvelle_date_fin) {
        $stmt = $this->db->prepare("UPDATE Abonnement SET date_fin = :dateFin, statut='actif' WHERE id = :id");
        return $stmt->execute([
            'dateFin' => $nouvelle_date_fin,
            'id' => $id
        ]);
    }

    // Suspendre un abonnement
    public function suspend($id) {
        $stmt = $this->db->prepare("UPDATE Abonnement SET statut='suspendu' WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Supprimer un abonnement
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Abonnement WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
