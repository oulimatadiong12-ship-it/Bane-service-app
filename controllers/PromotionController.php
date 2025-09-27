<?php
// controllers/PromotionController.php

require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/Promotion.php';
require_once __DIR__ . '/../../includes/navbar.php';

session_start();

$promotionModel = new Promotion($pdo);

// Ajouter une promotion
if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $dateDebut = $_POST['date_debut'];
    $dateFin = $_POST['date_fin'];
    $statut = $_POST['statut'] ?? 'active';

    // Gérer l'image (si fournie)
    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $fileName = uniqid() . '_' . $_FILES['image']['name'];
        $uploadDir = __DIR__ . '/../uploads/promotions/';
        $uploadPath = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $imagePath = $fileName;
        }
    }

    $promotionModel->create($titre, $description, $imagePath, $type, $dateDebut, $dateFin, $statut);
    header("Location: " . BASE_URL . "views/admin/promotions.php");
    exit;
}

// Modifier une promotion
if (isset($_POST['action']) && $_POST['action'] === 'modifier' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $dateDebut = $_POST['date_debut'];
    $dateFin = $_POST['date_fin'];
    $statut = $_POST['statut'] ?? 'active';

    // Récupérer l'ancienne image
    $oldPromotion = $promotionModel->getById($id);
    $imagePath = $oldPromotion['image_path'];

    // Si une nouvelle image est uploadée
    if (!empty($_FILES['image']['name'])) {
        $fileName = uniqid() . '_' . $_FILES['image']['name'];
        $uploadDir = __DIR__ . '/../uploads/promotions/';
        $uploadPath = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $imagePath = $fileName;
        }
    }

    $promotionModel->update($id, $titre, $description, $imagePath, $type, $dateDebut, $dateFin, $statut);
    header("Location: " . BASE_URL . "views/admin/promotions.php");
    exit;
}

//  Supprimer une promotion
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $promotionModel->delete($_GET['id']);
    header("Location: " . BASE_URL . "views/admin/promotions.php");
    exit;
}
