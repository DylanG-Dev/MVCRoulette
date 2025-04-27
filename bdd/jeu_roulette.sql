CREATE DATABASE IF NOT EXISTS jeu_roulette CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE jeu_roulette;

CREATE TABLE IF NOT EXISTS `roulette_joueur` (
  `identifiant` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  `motdepasse` VARCHAR(255) NOT NULL,
  `argent` INT(11) NOT NULL
);

CREATE TABLE IF NOT EXISTS `roulette_partie` (
  `identifiant` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `joueur` INT(11) NOT NULL,
  `date` DATETIME NOT NULL,
  `mise` INT(11) NOT NULL,
  `gain` INT(11) NOT NULL,
  FOREIGN KEY (joueur) REFERENCES roulette_joueur(identifiant)
);

INSERT INTO roulette_joueur (nom, motdepasse, argent) VALUES ('login', 'password', 500);
