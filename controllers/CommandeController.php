<?php
// controllers/CommandeController.php


require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/Commande.php';
require_once __DIR__ . '/../models/LigneCommande.php';
require_once __DIR__ . '/../includes/navbar.php';

$commandeModel = new Commande($pdo);
$ligneCommandeModel = new LigneCommande($pdo);

$action = $_GET['action'] ?? 'liste';

switch ($action) {
    case 'liste':
        // Récupère toutes les commandes avec les infos utilisateurs
        $commandes = $commandeModel->getAll();
        include __DIR__ . '/../views/admin/commandes.php';
        break;

    case 'details':
        // Affiche les détails d'une commande donnée
        if (isset($_GET['id'])) {
            $commande = $commandeModel->getById($_GET['id']);
            if (!$commande) {
                echo "Commande introuvable.";
                exit;
            }
            $lignes = $ligneCommandeModel->getByCommande($_GET['id']);
            include __DIR__ . '/../views/admin/details_commande.php';
        } else {
            echo "ID de commande manquant.";
        }
        break;

    case 'changer_statut':
        if (isset($_GET['id'], $_GET['statut'])) {
            $commandeModel->updateStatut($_GET['id'], $_GET['statut']);
        }
        header("Location: " . BASE_URL . "/controllers/CommandeController.php?action=liste");
        exit;

    case 'supprimer':
        if (isset($_GET['id'])) {
            $ligneCommandeModel->deleteByCommande($_GET['id']);
            $commandeModel->delete($_GET['id']);
        }
        header("Location: " . BASE_URL . "/controllers/CommandeController.php?action=liste");
        exit;

    default:
        echo "Action inconnue.";
}
