-- ==============================
-- TABLE UTILISATEURS
-- ==============================
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('admin','agent','client','abonne','technicien') DEFAULT 'client',
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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

-- ==============================
-- TABLE PROMOTIONS
-- ==============================
CREATE TABLE IF NOT EXISTS promotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    pourcentage INT NOT NULL CHECK (pourcentage BETWEEN 0 AND 100),
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==============================
-- TABLE COMMANDES
-- ==============================
CREATE TABLE IF NOT EXISTS commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    statut ENUM('en_attente','validee','livree','annulee') DEFAULT 'en_attente',
    total DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);

-- ==============================
-- TABLE LIGNE DE COMMANDE
-- ==============================
CREATE TABLE IF NOT EXISTS ligne_commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id)
);

-- ==============================
-- TABLE ABONNEMENTS CANAL+
-- ==============================
CREATE TABLE IF NOT EXISTS abonnements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    formule VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    statut ENUM('actif','suspendu','expire') DEFAULT 'actif',
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);

-- ==============================
-- TABLE PAIEMENTS ABONNEMENTS
-- ==============================
CREATE TABLE IF NOT EXISTS paiement_abonnements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    abonnement_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    mode_paiement ENUM('OM','Wave','Caisse') NOT NULL,
    date_paiement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (abonnement_id) REFERENCES abonnements(id)
);

-- ==============================
-- TABLE SERVICES TECHNIQUES
-- ==============================
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL
);

-- ==============================
-- TABLE RENDEZ-VOUS TECHNICIENS
-- ==============================
CREATE TABLE IF NOT EXISTS rendezvous (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL, -- client
    technicien_id INT NOT NULL,
    service_id INT NOT NULL,
    date_rdv DATETIME NOT NULL,
    statut ENUM('planifie','termine','annule') DEFAULT 'planifie',
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (technicien_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

-- ==============================
-- TABLE TRANSACTIONS (OM / WAVE / CAISSE)
-- ==============================
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    type_operation ENUM('depot','retrait','credit') NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    mode_paiement ENUM('OM','Wave','Caisse') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);
