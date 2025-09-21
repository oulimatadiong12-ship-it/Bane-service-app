<?php
// controllers/PromotionController.php

require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/Promotion.php';

if (!defined('BASE_URL')) {
    define('BASE_URL', '/baneservice-app');
}

$promotionModel = new Promotion($pdo);
$action = $_GET['action'] ?? '';

// ------------------------
// AJOUTER une promotion
// ------------------------
if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $statut = $_POST['statut'] ?? 'active';

    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_path = time() . '_' . $_FILES['image']['name'];
        $uploadDir = __DIR__ . '/../uploads/promotions/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image_path);
    }

    $promotionModel->create([
        'titre' => $titre,
        'description' => $description,
        'image_path' => $image_path,
        'type' => $type,
        'date_debut' => $date_debut,
        'date_fin' => $date_fin,
        'statut' => $statut
    ]);

    header("Location: " . BASE_URL . "/views/admin/promotions.php");
    exit;
}

// ------------------------
// MODIFIER une promotion
// ------------------------
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $statut = $_POST['statut'];

    $image_path = $_POST['old_image'] ?? null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_path = time() . '_' . $_FILES['image']['name'];
        $uploadDir = __DIR__ . '/../uploads/promotions/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image_path);
    }

    $promotionModel->update($id, [
        'titre' => $titre,
        'description' => $description,
        'image_path' => $image_path,
        'type' => $type,
        'date_debut' => $date_debut,
        'date_fin' => $date_fin,
        'statut' => $statut
    ]);

    header("Location: " . BASE_URL . "/views/admin/promotions.php");
    exit;
}

// ------------------------
// SUPPRIMER une promotion
// ------------------------
if ($action === 'supprimer' && isset($_GET['id'])) {
    $promotionModel->delete($_GET['id']);
    header("Location: " . BASE_URL . "/views/admin/promotions.php");
    exit;
}

// ------------------------
// Affichage ADMIN : Liste des promotions
// ------------------------
if ($action === '' || $action === 'liste') {
    $promotions = $promotionModel->getAll();
    include __DIR__ . '/../views/admin/promotions.php';
    exit;
}

// ------------------------
// Affichage PUBLIC : Promotions actives
// ------------------------
if ($action === 'public') {
    $promotions = $promotionModel->getActive();
    include __DIR__ . '/../views/public/promotions.php';
    exit;
}

// ------------------------
// Formulaire AJOUTER/MODIFIER
// ------------------------
if ($action === 'edit') {
    $promotion = null;
    if (isset($_GET['id'])) {
        $promotion = $promotionModel->getById($_GET['id']);
    }
    include __DIR__ . '/../views/admin/form_promotion.php';
 exit;
} 
