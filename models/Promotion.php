<?php
// models/Promotion.php
class Promotion
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    //  Créer une promotion
    public function create($titre, $description, $imagePath, $type, $dateDebut, $dateFin, $statut = 'active')
    {
        $sql = "INSERT INTO Promotion (titre, description, image_path, type, date_debut, date_fin, statut)
                VALUES (:titre, :description, :image_path, :type, :date_debut, :date_fin, :statut)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':titre' => $titre,
            ':description' => $description,
            ':image_path' => $imagePath,
            ':type' => $type,
            ':date_debut' => $dateDebut,
            ':date_fin' => $dateFin,
            ':statut' => $statut
        ]);
    }

    // Obtenir toutes les promotions
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM Promotion ORDER BY date_debut DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //  Trouver une promotion par ID
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Promotion WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //  Modifier une promotion
    public function update($id, $titre, $description, $imagePath, $type, $dateDebut, $dateFin, $statut)
    {
        $sql = "UPDATE Promotion 
                SET titre = :titre,
                    description = :description,
                    image_path = :image_path,
                    type = :type,
                    date_debut = :date_debut,
                    date_fin = :date_fin,
                    statut = :statut
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':titre' => $titre,
            ':description' => $description,
            ':image_path' => $imagePath,
            ':type' => $type,
            ':date_debut' => $dateDebut,
            ':date_fin' => $dateFin,
            ':statut' => $statut
        ]);
    }

    //  Supprimer une promotion
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM Promotion WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getPromotionsActives($search = '') {
    $sql = "SELECT * FROM promotion WHERE statut = 'active'";

    if (!empty($search)) {
        $sql .= " AND (titre LIKE :search OR description LIKE :search)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':search', "%$search%");
    } else {
        $stmt = $this->pdo->prepare($sql);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    //  Rechercher par titre ou description
    public function search($term)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Promotion WHERE titre LIKE :term OR description LIKE :term");
        $stmt->execute([':term' => '%' . $term . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
