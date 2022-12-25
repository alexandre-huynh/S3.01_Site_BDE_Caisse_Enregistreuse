-- =====================
-- Suppression des tables (à des fins de test)
-- =====================
-- mettre en commentaire si non utilisé
DROP TABLE IF EXISTS Vente CASCADE;
DROP TABLE IF EXISTS Produit CASCADE;
DROP TABLE IF EXISTS SuperAdmin CASCADE;
DROP TABLE IF EXISTS Admin CASCADE;
DROP TABLE IF EXISTS Client CASCADE;
DROP TABLE IF EXISTS Authentification CASCADE;

-- =====================
-- Création des tables
-- =====================
CREATE TABLE Authentification
(
    num_etudiant INT PRIMARY KEY NOT NULL,
    Password VARCHAR(255) NOT NULL
);

CREATE TABLE Client
(
    id_client INT PRIMARY KEY NOT NULL,
    num_etudiant INT NOT NULL,
    Nom VARCHAR(50) NOT NULL,
    Prenom VARCHAR(50) NOT NULL,
    Tel VARCHAR(15),
    Email VARCHAR(255) NOT NULL, -- car obligatoire à la connexion
    Date_creation DATE,
    Pts_fidelite INT,
    FOREIGN KEY (num_etudiant) REFERENCES Authentification(num_etudiant)
);

CREATE TABLE Admin
(
    id_admin INT PRIMARY KEY NOT NULL,
    num_etudiant INT NOT NULL,
    Nom VARCHAR(50) NOT NULL,
    Prenom VARCHAR(50) NOT NULL,
    Tel VARCHAR(15),
    Email VARCHAR(255) NOT NULL,
    Date_creation DATE,
    Pts_fidelite INT,
    FOREIGN KEY (num_etudiant) REFERENCES Authentification(num_etudiant)
);

CREATE TABLE SuperAdmin
(
    id_superadmin INT PRIMARY KEY NOT NULL,
    id_admin INT NOT NULL,
    FOREIGN KEY (id_admin) REFERENCES Admin(id_admin)
);


CREATE TABLE Produit
(
    id_produit INT PRIMARY KEY NOT NULL,
    Nom VARCHAR(50),
    Categorie VARCHAR(50),
    Prix FLOAT,
    Img_produit VARCHAR(50),
    Date_ajout DATE,
    Stock INT,
    Nb_ventes INT
);


CREATE TABLE Vente
(
    num_vente INT PRIMARY KEY NOT NULL,
    id_client int,
    id_admin int,
    id_produit int,
    Nom_produit VARCHAR(50),
    Date_vente DATE,
    Paiement VARCHAR(50),
    FOREIGN KEY (id_client) REFERENCES Client(id_client),
    FOREIGN KEY (id_admin) REFERENCES Admin(id_admin),
    FOREIGN KEY (id_produit) REFERENCES Produit(id_produit)

);

/*
-- =====================
-- Test affichage
-- =====================
SELECT * FROM Client;
SELECT * FROM Admin;
SELECT * FROM SuperAdmin;
SELECT * FROM Produit;
SELECT * FROM Authentification;
SELECT * FROM Vente;
*/
