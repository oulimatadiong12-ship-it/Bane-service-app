<?php

require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/RendezVous.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../includes/navbar.php';



$technicienId = $_SESSION['user']['id'];
$rvModel = new RendezVous($pdo);
$message = null;

// Traitement des actions POST pour changer le statut
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $rvId = isset($_POST['rv_id']) ? (int)$_POST['rv_id'] : null;

    if ($rvId) {
        if ($action === 'terminer') {
            $rvModel->updateStatut($rvId, 'terminé');
            $message = "Rendez-vous marqué comme terminé.";
        } elseif ($action === 'annuler') {
            $rvModel->updateStatut($rvId, 'annulé');
            $message = "Rendez-vous annulé.";
        }
    }
    // Redirection pour éviter le repost du formulaire
    header("Location: " . BASE_URL . "views/technicien/rendezvous.php?msg=" . urlencode($message));
    exit;
}

// Récupérer tous les rendez-vous pour le technicien
try {
    $rendezvous = $rvModel->getByTechnicien($technicienId);
} catch (Exception $e) {
    $rendezvous = [];
    $message = "Erreur lors de la récupération des rendez-vous.";
}

// Vous pouvez ensuite inclure la vue correspondante, par exemple :
// require_once __DIR__ . '/../views/technicien/rendezvous.php';

?>