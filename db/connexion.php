<?php
// db/connexion.php

$host = "localhost";      // serveur (WAMP = localhost)
$dbname = "baneservice";  // nom de ta base MySQL (celle que tu as créée dans phpMyAdmin)
$username = "root";       // par défaut sur WAMP, l’utilisateur est root
$password = "";           // par défaut sur WAMP, le mot de passe est vide

try {
    // Connexion PDO à MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Options pour sécuriser et gérer les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // En cas d’erreur, afficher le message
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
