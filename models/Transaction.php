<?php
class Transaction {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Ajouter une transaction
    public function create($type, $operation, $montant, $numero, $statut, $utilisateur_id, $employe_id) {
        $sql = "INSERT INTO Transaction (type, operation, montant, numero, date, statut, utilisateur_id, employe_id)
                VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$type, $operation, $montant, $numero, $statut, $utilisateur_id, $employe_id]);
    }

    // Récupérer toutes les transactions
    public function getAll() {
        $sql = "SELECT t.*, u.nom AS client_nom, u.prenom AS client_nom
                FROM Transaction t
                LEFT JOIN Utilisateur u ON t.utilisateur_id = u.id
                LEFT JOIN Utilisateur e ON t.employe_id = e.id
                ORDER BY t.date DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Transactions par client
    public function getByClient($clientId) {
        $sql = "SELECT * FROM Transaction WHERE utilisateur_id = ? ORDER BY date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$clientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Calculer solde caisse (somme des dépôts - retraits)
    public function getSoldeCaisse() {
        $sql = "SELECT 
                    SUM(CASE WHEN operation='dépôt' THEN montant ELSE 0 END) -
                    SUM(CASE WHEN operation='retrait' THEN montant ELSE 0 END) AS solde
                FROM Transaction";
        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $res['solde'] ?? 0;
    }
}
?>
