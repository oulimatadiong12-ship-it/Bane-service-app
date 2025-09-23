<?php
class Service {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // CRUD
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Service ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Service WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($type, $prix, $duree, $description, $competences) {
        $stmt = $this->db->prepare("INSERT INTO Service (type, prix, duree_moyenne, description, competences_requises) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$type, $prix, $duree, $description, $competences]);
    }

    public function update($id, $type, $prix, $duree, $description, $competences) {
        $stmt = $this->db->prepare("UPDATE Service SET type=?, prix=?, duree_moyenne=?, description=?, competences_requises=? WHERE id=?");
        return $stmt->execute([$type, $prix, $duree, $description, $competences, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Service WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
