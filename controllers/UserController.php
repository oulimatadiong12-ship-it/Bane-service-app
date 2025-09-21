<?php
// controllers/UserController.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../db/connexion.php";

$utilisateurModel = new Utilisateur($pdo);

// Action choisie
$action = $_GET['action'] ?? null;

// Connexion
if ($action === "login" && $_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";

    $user = $utilisateurModel->getByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            "id" => $user['id'],
            "nom" => $user['nom'],
            "email" => $user['email'],
            "role" => $user['role']
        ];
        header("Location: /index.php");
        exit;
    } else {
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        header("Location: /views/public/login.php");
        exit;
    }
}

// Déconnexion
if ($action === "logout") {
    session_destroy();
    header("Location: /index.php");
    exit;
}

// Ajout admin/agent
if ($action === "add" && $_SERVER['REQUEST_METHOD'] === "POST") {
    $nom = $_POST['nom'] ?? "";
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";
    $role = $_POST['role'] ?? "agent";

    if ($utilisateurModel->add($nom, $email, $password, $role)) {
        $_SESSION['success'] = "Utilisateur ajouté avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de l'ajout.";
    }
    header("Location: /views/admin/utilisateurs.php");
    exit;
}