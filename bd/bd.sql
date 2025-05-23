CREATE DATABASE IF NOT EXISTS gestion_produit;
USE gestion_produit;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    roole ENUM('admin', 'etudiant') DEFAULT 'etudiant'
);

CREATE TABLE IF NOT EXISTS produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    categorie VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    prix_ancien DECIMAL(10,2),
    quantite INT NOT NULL,
    description TEXT,
    image VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    produit_id INT NOT NULL,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produit_id) REFERENCES produit(id) ON DELETE CASCADE
);
