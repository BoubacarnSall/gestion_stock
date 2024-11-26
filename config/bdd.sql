CREATE DATABASE gestion_stocks;

USE gestion_stocks;

CREATE TABLE administrateur( 
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(45) NOT NULL UNIQUE,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR (45) NOT NULL UNIQUE,
    mot_de_passe (45),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTEMP
);

INSERT INTO administrateur (nom, prenom, email, mot_de_passe) VALUES  ('Sall', 'Alpha boubacar', 'alphaboubacarsall5@gmail.com','Alph@dio');

CREATE TABLE materiels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(45),
    descriptions TEXT (70),
    quntite INT NOT NULL,
    date_arrive TIMESTAMP DEFAULT CURRENT_TIMESTEMP
)

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR (45),
    prenom VARCHAR(50),
    email VARCHAR (50),
    mot_de_passe VARCHAR (50),
    date_arrive TIMESTAMP DEFAULT CURRENT_TIMESTEMP
);          

CREATE TABLE rh (
    id INT AUTO_INCREMENT PRIMARY KEY
    nom VARCHAR(45),
    prenom VARCHAR(50),
    email VARCHAR (50),
    mot_de_passe VARCHAR (50) 
);
 
CREATE TABLE assistants (
    id INT AUTO_INCREMENT PRIMARY KEY
    nom VARCHAR(45),
    prenom VARCHAR(50),
    email VARCHAR (50),
    mot_de_passe VARCHAR (50) 
);

