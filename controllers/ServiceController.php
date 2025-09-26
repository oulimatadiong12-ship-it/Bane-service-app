<?php

require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../Includes/navbar.php';
// Vérification rôle admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: " . BASE_URL . "views/public/login.php");
    exit;
}

$serviceModel = new Service($pdo);

// POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    switch ($action) {
        case 'ajouter':
            $serviceModel->create($_POST['type'], $_POST['prix'], $_POST['duree'], $_POST['description'], $_POST['competences']);
            break;
        case 'modifier':
            $serviceModel->update($_POST['id'], $_POST['type'], $_POST['prix'], $_POST['duree'], $_POST['description'], $_POST['competences']);
            break;
        case 'supprimer':
            $serviceModel->delete($_POST['id']);
            break;
    }
    header("Location: " . BASE_URL . "views/admin/services.php");
    exit;
}

// GET data
$services = $serviceModel->getAll();

?>
