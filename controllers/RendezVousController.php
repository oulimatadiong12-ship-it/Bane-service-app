<?php
session_start();
require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/RendezVous.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../../includes/navbar.php';
// Vérification rôle technicien
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'technicien') {
    header("Location: " . BASE_URL . "views/public/login.php");
    exit;
}

$technicienId = $_SESSION['user']['id'];
$rvModel = new RendezVous($pdo);

// Actions POST pour changer le statut
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $rvId = $_POST['rv_id'] ?? null;

    if ($rvId) {
        switch ($action) {
            case 'terminer':
                $rvModel->updateStatut($rvId, 'terminé');
                break;
            case 'annuler':
                $rvModel->updateStatut($rvId, 'annulé');
                break;
        }
    }
    header("Location: " . BASE_URL . "views/technicien/rendezvous.php");
    exit;
}

// Récupérer tous les rendez-vous pour le technicien
$rendezvous = $rvModel->getByTechnicien($technicienId);

// Charger la vue
require_once __DIR__ . '/../views/technicien/rendezvous.php';
