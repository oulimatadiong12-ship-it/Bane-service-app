<?php
// includes/auth.php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return (isLoggedIn() && $_SESSION['user']['role'] === 'admin');
}

function isTechnicien() {
    return (isLoggedIn() && $_SESSION['user']['role'] === 'technicien');
}

function isClient() {
    return (isLoggedIn() && $_SESSION['user']['role'] === 'client');
}

// Si on veut protéger une page :
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: /login.php");
        exit();
    }
}
?>