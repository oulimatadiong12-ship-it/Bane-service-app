DROP DATABASE IF EXISTS bane_service;
CREATE DATABASE bane_service
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE bane_service;

-- 1. Utilisateur
CREATE TABLE Utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','client','abonne','technicien') NOT NULL DEFAULT 'client',
    telephone VARCHAR(20),
    adresse TEXT,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Abonnement
CREATE TABLE Abonnement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    formule VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    statut ENUM('actif','expiré','suspendu') DEFAULT 'actif',
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. PaiementAbonnement
CREATE TABLE PaiementAbonnement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    abonnement_id INT NOT NULL,
    date_paiement DATE NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    prochain_paiement DATE,
    FOREIGN KEY (abonnement_id) REFERENCES Abonnement(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 4. Produit
CREATE TABLE Produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(150) NOT NULL,
    categorie VARCHAR(100),
    prixAchat DECIMAL(10,2) NOT NULL,
    prixVente DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    seuil_alerte INT DEFAULT 5,
    description TEXT,
    fournisseur VARCHAR(150)
) ENGINE=InnoDB;

-- 5. Commande
CREATE TABLE Commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    montant_total DECIMAL(12,2) NOT NULL,
    statut ENUM('en attente','validée','livrée','annulée') DEFAULT 'en attente',
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. LigneCommande
CREATE TABLE LigneCommande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES Commande(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES Produit(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 7. Service
CREATE TABLE Service (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    duree_moyenne VARCHAR(50),
    description TEXT,
    competences_requises TEXT
) ENGINE=InnoDB;

-- 8. RendezVous
CREATE TABLE RendezVous (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    service_id INT NOT NULL,
    technicien_id INT NOT NULL,
    date DATE NOT NULL,
    heure TIME NOT NULL,
    statut ENUM('planifié','en cours','terminé','annulé') DEFAULT 'planifié',
    notes TEXT,
    FOREIGN KEY (client_id) REFERENCES Utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES Service(id) ON DELETE CASCADE,
    FOREIGN KEY (technicien_id) REFERENCES Utilisateur(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 9. Intervention
CREATE TABLE Intervention (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rendezvous_id INT NOT NULL,
    date_debut DATETIME,
    date_fin DATETIME,
    observations TEXT,
    statut ENUM('en attente','en cours','terminé','annulé') DEFAULT 'en attente',
    FOREIGN KEY (rendezvous_id) REFERENCES RendezVous(id) ON DELETE CASCADE 
) ENGINE=InnoDB;

-- 10. Transaction
CREATE TABLE Transaction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('OM', 'Wave', 'Espèces') NOT NULL,
    operation ENUM('dépôt', 'retrait', 'crédit') NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    numero VARCHAR(50),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('en attente', 'validée', 'échouée') DEFAULT 'en attente',
    utilisateur_id INT NOT NULL,
    employe_id INT NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (employe_id) REFERENCES Utilisateur(id) ON DELETE CASCADE
);

-- 11. Promotion
CREATE TABLE Promotion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    type ENUM('canal', 'produit', 'service') NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    statut ENUM('active', 'inactive') DEFAULT 'active'
);
