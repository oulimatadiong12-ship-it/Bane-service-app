-- schema.sql

CREATE DATABASE IF NOT EXISTS bane_service;
USE bane_service;

-- Table Utilisateur
CREATE TABLE IF NOT EXISTS Utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','client','abonne','technicien') DEFAULT 'client',
    telephone VARCHAR(20),
    adresse TEXT,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);