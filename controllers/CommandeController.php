<?php
// controllers/CommandeController.php

require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/Commande.php';
require_once __DIR__ . '/../models/LigneCommande.php';
require_once __DIR__ . '/../../includes/navbar.php';

session_start();

// Initialisation des modèles
$commandeModel = new Commande($pdo);
$ligneCommandeModel = new LigneCommande($pdo);

// ------------------------
// Supprimer une commande (Admin)
// ------------------------
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $commande_id = $_GET['id'];

    // Supprimer d'abord les lignes de commande liées
    $ligneCommandeModel->deleteByCommande($commande_id);

    // Ensuite supprimer la commande
    $commandeModel->delete($commande_id);

    header("Location: " . BASE_URL . "views/admin/commandes.php");
    exit;
}

// ------------------------
// Changer le statut d'une commande (Admin)
// ------------------------
if (isset($_GET['action']) && $_GET['action'] === 'changer_statut' && isset($_GET['id'], $_GET['statut'])) {
    $commandeModel->updateStatut($_GET['id'], $_GET['statut']);
    header("Location: " . BASE_URL . "views/admin/commandes.php");
    exit;
}

// ------------------------
// Détails d'une commande (Admin)
// ------------------------
if (isset($_GET['action']) && $_GET['action'] === 'details' && isset($_GET['id'])) {
    $commande = $commandeModel->getById($_GET['id']);
    $lignes   = $ligneCommandeModel->getByCommande($_GET['id']);

    include __DIR__ . '/../views/admin/details_commande.php';
    exit;
}

// ------------------------
// Afficher toutes les commandes (Admin)
// ------------------------
$commandes = $commandeModel->getAll();
include __DIR__ . '/../views/admin/commandes.php';
