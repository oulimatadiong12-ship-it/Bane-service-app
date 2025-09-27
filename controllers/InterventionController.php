<?php

require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/Intervention.php';
require_once __DIR__ . '/../models/RendezVous.php';
require_once __DIR__ . '/../Includes/navbar.php';


$technicienId = $_SESSION['user']['id'];
$interventionModel = new Intervention($pdo);
$rvModel = new RendezVous($pdo);

// Actions POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? null;

    switch ($action) {
        case 'ajouter':
            $interventionModel->create(
                $_POST['rendezvous_id'],
                $_POST['date_debut'],
                $_POST['date_fin'],
                $_POST['observations'],
                $_POST['statut']
            );
            break;

        case 'modifier':
            if ($id) {
                $interventionModel->update(
                    $id,
                    $_POST['date_debut'],
                    $_POST['date_fin'],
                    $_POST['observations'],
                    $_POST['statut']
                );
            }
            break;
    }
    header("Location: " . BASE_URL . "views/technicien/intervention.php");
    exit;
}

// Récupérer toutes les interventions du technicien
$interventions = $interventionModel->getByTechnicien($technicienId);

// Récupérer les rendez-vous planifiés pour ce technicien
$rendezvous = $rvModel->getByTechnicien($technicienId);

?>
