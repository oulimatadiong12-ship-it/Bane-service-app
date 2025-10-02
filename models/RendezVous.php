<?php
class RendezVous {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Récupérer tous les rendez-vous
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM RendezVous ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un rendez-vous par ID
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM RendezVous WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    // Récupérer tous les rendez-vous pour un technicien
    public function getByTechnicien(int $technicienId): array {
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

    // Créer un nouveau rendez-vous
    public function create(array $data): int|false {
        $sql = "INSERT INTO RendezVous (client_id, service_id, technicien_id, date, heure, statut, notes)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            $data['client_id'],
            $data['service_id'],
            $data['technicien_id'],
            $data['date'],
            $data['heure'],
            $data['statut'] ?? 'planifié',
            $data['notes'] ?? null
        ]);
        return $success ? (int)$this->db->lastInsertId() : false;
    }

    // Mettre à jour un rendez-vous
    public function update(int $id, array $data): bool {
        $sql = "UPDATE RendezVous SET client_id=?, service_id=?, technicien_id=?, date=?, heure=?, statut=?, notes=?
                WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['client_id'],
            $data['service_id'],
            $data['technicien_id'],
            $data['date'],
            $data['heure'],
            $data['statut'],
            $data['notes'],
            $id
        ]);
    }

    // Mettre à jour uniquement le statut
    public function updateStatut(int $id, string $statut): bool {
        $stmt = $this->db->prepare("UPDATE RendezVous SET statut=? WHERE id=?");
        return $stmt->execute([$statut, $id]);
    }

    // Supprimer un rendez-vous
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM RendezVous WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
