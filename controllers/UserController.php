<?php
// controllers/UserController.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../db/connexion.php";

$utilisateurModel = new Utilisateur($pdo);

$action = $_GET['action'] ?? null;

if ($action === "login" && $_SERVER['REQUEST_METHOD'] === "POST") {
    $email = filter_var(trim($_POST['email'] ?? ""), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password'] ?? "");

    if (!$email || empty($password)) {
        $_SESSION['error'] = "Email ou mot de passe invalide.";
        header("Location: /views/public/login.php");
        exit;
    }

    $user = $utilisateurModel->getByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            "id" => $user['id'],
            "nom" => $user['nom'],
            "prenom" => $user['prenom'],
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

if ($action === "logout") {
    session_unset();
    session_destroy();
    header("Location: /index.php");
    exit;
}

if ($action === "add" && $_SERVER['REQUEST_METHOD'] === "POST") {
    $nom = trim($_POST['nom'] ?? "");
    $prenom = trim($_POST['prenom'] ?? "");
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";
    $role = $_POST['role'] ?? "agent";

    if ($utilisateurModel->add($nom, $prenom, $email, $password, $role)) {
        $_SESSION['success'] = "Utilisateur ajouté avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de l'ajout. Vérifiez les données.";
    }
    header("Location: /views/admin/utilisateurs.php");
    exit;
}
