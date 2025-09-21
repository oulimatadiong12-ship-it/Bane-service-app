<?php
session_start();
require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/Service.php';

// Vérifier que seul un admin peut gérer les services
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../views/login.php");
    exit;
}

$serviceModel = new Service($pdo);

// -------------------------
// Actions POST
// -------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'ajouter':
            $type = $_POST['type'] ?? '';
            $prix = $_POST['prix'] ?? 0;
            $duree = $_POST['duree_moyenne'] ?? '';
            $desc = $_POST['description'] ?? '';
            $comp = $_POST['competences_requises'] ?? '';

            if (!empty($type) && !empty($prix)) {
                $serviceModel->create($type, $prix, $duree, $desc, $comp);
            }
            header("Location: ../views/admin/services.php");
            exit;

        case 'modifier':
            $id = $_POST['id'] ?? null;
            $type = $_POST['type'] ?? '';
            $prix = $_POST['prix'] ?? 0;
            $duree = $_POST['duree_moyenne'] ?? '';
            $desc = $_POST['description'] ?? '';
            $comp = $_POST['competences_requises'] ?? '';

            if ($id) {
                $serviceModel->update($id, $type, $prix, $duree, $desc, $comp);
            }
            header("Location: ../views/admin/services.php");
            exit;

        case 'supprimer':
            $id = $_POST['id'] ?? null;
            if ($id) {
                $serviceModel->delete($id);
            }
            header("Location: ../views/admin/services.php");
            exit;
    }
}

// -------------------------
// Préparer les données pour la vue
// -------------------------
$services = $serviceModel->getAll();

// Inclure la vue
require_once __DIR__ . '/../views/admin/services.php';
