-- ==============================
-- Création de la base de données
-- ==============================
CREATE DATABASE IF NOT EXISTS bane_service
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

-- Utiliser la base
USE bane_service;

-- ==============================
-- TABLE UTILISATEUR
-- ==============================
CREATE TABLE IF NOT EXISTS Utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('admin', 'agent', 'user') DEFAULT 'user',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO Utilisateur (nom, email, mot_de_passe, role)
VALUES ('Super Admin', 'admin@bane-service.com', 'motdepasse_hashé', 'admin');

-- ==============================
-- TABLE PRODUITS
-- ==============================
CREATE TABLE IF NOT EXISTS produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
