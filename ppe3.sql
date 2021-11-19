-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 18 nov. 2021 à 12:28
-- Version du serveur :  8.0.21
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ppe3`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidat`
--

DROP TABLE IF EXISTS `candidat`;
CREATE TABLE IF NOT EXISTS `candidat` (
  `Candidat_Id` int NOT NULL,
  `Candidat_PieceIdentite` tinyint DEFAULT NULL,
  `Candidat_CPF` tinyint DEFAULT NULL,
  `Candidat_Competence` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Candidat_Situation_Pro` enum('CDI','CDD','Intérimaire','Demandeur emploi','Autre') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Candidat_Diplome` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id` int DEFAULT NULL,
  PRIMARY KEY (`Candidat_Id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `candidat`
--

INSERT INTO `candidat` (`Candidat_Id`, `Candidat_PieceIdentite`, `Candidat_CPF`, `Candidat_Competence`, `Candidat_Situation_Pro`, `Candidat_Diplome`, `id`) VALUES
(1, NULL, 1, '', 'CDD', NULL, NULL),
(4, NULL, 1, '', 'CDD', NULL, NULL),
(7, NULL, NULL, NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `Contact_Id` int NOT NULL AUTO_INCREMENT,
  `Contact_Nom` varchar(60) NOT NULL,
  `Contact_Prenom` varchar(60) NOT NULL,
  `Contact_Tel` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Contact_Email` varchar(60) NOT NULL,
  `Contact_Adresse` varchar(100) DEFAULT NULL,
  `Contact_CodePostal` int(5) UNSIGNED ZEROFILL DEFAULT NULL,
  `Contact_Ville` varchar(60) DEFAULT NULL,
  `Contact_Date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Contact_Id`),
  UNIQUE KEY `Contact_Email` (`Contact_Email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`Contact_Id`, `Contact_Nom`, `Contact_Prenom`, `Contact_Tel`, `Contact_Email`, `Contact_Adresse`, `Contact_CodePostal`, `Contact_Ville`, `Contact_Date`) VALUES
(1, 'Citron', 'Zora', 0126564587, 'cica@gmail.com', 'rue du test 2', 78541, 'Paris', '2021-05-15 18:11:09'),
(2, 'Imma', 'Coralie', 0654879523, 'imma@gmail.com', '93 avenue du Maine', 78600, 'Maisons-Laffitte', '2021-05-15 18:11:09'),
(3, 'Bro', 'Laurie', 0125647895, 'LaurieB@yahoo.fr', '45 rue du tournesol', 95540, 'Cergy', '2021-05-15 18:23:07'),
(4, 'Manu', 'Rachida', 0625478951, 'RachidaM@gmail.com', '2 rue du comte', 78600, 'lorient', '2021-05-15 18:23:07'),
(5, 'Guy', 'Denis', 0256548745, 'guillen@gmail.com', NULL, NULL, NULL, '2021-05-15 18:29:21'),
(6, 'Bertel', 'Simon', 0625487596, 'Bertel@yahoo.fr', '2 chemin des bois', 54866, 'Puy', '2021-05-15 18:29:21'),
(7, 'Blanc', 'Michel', 0622548752, 'bm@gmail.com', NULL, NULL, NULL, '2021-05-15 18:33:36'),
(8, 'Zorg', 'Bill', 0236548759, 'bz@test.com', '5 rue orange', 54236, 'Calais', '2021-05-15 18:33:36'),
(9, 'Marie', 'Claire', 0165487592, 'CM@gmail.com', '3 rue des bleuets', 75012, 'Paris', '2021-05-15 18:35:57'),
(10, 'Chagne', 'Claude', 0215467895, 'cc@gmail.com', NULL, NULL, NULL, '2021-05-15 18:35:57');

-- --------------------------------------------------------

--
-- Structure de la table `dossier`
--

DROP TABLE IF EXISTS `dossier`;
CREATE TABLE IF NOT EXISTS `dossier` (
  `Dossier_Id` int NOT NULL AUTO_INCREMENT,
  `Dossier_MotDePasse` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Mot de passe de connexion pour consultation du dossier par le candidat',
  `Dossier_DateCreation` date NOT NULL,
  `Dossier_DateRetourFinanceur` date DEFAULT NULL,
  `Dossier_Transmission` date DEFAULT NULL,
  `Dossier_Report` date DEFAULT NULL,
  `Dossier_Annulation` date DEFAULT NULL,
  `Dossier_Financeur` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Dossier_Parcours_personnalise` tinyint DEFAULT NULL,
  `Dossier_Bilan_Formation` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Dossier_Session` date DEFAULT NULL,
  `Dossier_Formation` enum('BTS SIO SLAM','BTS SIO SISR','BTS GPME','BTS CG','BTS Assurance','BTS MCO','BTS Banque') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Gestionnaire_Id` int DEFAULT NULL,
  `Candidat_Id` int NOT NULL,
  PRIMARY KEY (`Dossier_Id`),
  KEY `Gestionnaire_Id` (`Gestionnaire_Id`),
  KEY `Candidat_Id` (`Candidat_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `dossier`
--

INSERT INTO `dossier` (`Dossier_Id`, `Dossier_MotDePasse`, `Dossier_DateCreation`, `Dossier_DateRetourFinanceur`, `Dossier_Transmission`, `Dossier_Report`, `Dossier_Annulation`, `Dossier_Financeur`, `Dossier_Parcours_personnalise`, `Dossier_Bilan_Formation`, `Dossier_Session`, `Dossier_Formation`, `Gestionnaire_Id`, `Candidat_Id`) VALUES
(1, 'cc', '2021-05-15', NULL, NULL, NULL, NULL, '', 0, '', NULL, 'BTS SIO SLAM', 3, 1),
(2, 're', '2021-05-30', NULL, NULL, NULL, NULL, '', 0, '', NULL, 'BTS SIO SISR', 4, 4),
(3, '60d2e79447149', '2021-06-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BTS CG', 3, 10),
(4, '60d2e7ae64c3b', '2021-06-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BTS SIO SISR', 3, 7);

-- --------------------------------------------------------

--
-- Structure de la table `gestionnaire`
--

DROP TABLE IF EXISTS `gestionnaire`;
CREATE TABLE IF NOT EXISTS `gestionnaire` (
  `Gestionnaire_Id` int NOT NULL AUTO_INCREMENT,
  `Gestionnaire_Nom` varchar(60) NOT NULL,
  `Gestionnaire_Prenom` varchar(60) NOT NULL,
  `Gestionnaire_Email` varchar(60) NOT NULL,
  `Gestionnaire_MotDePasse` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`Gestionnaire_Id`),
  UNIQUE KEY `Gestionnaire_Email` (`Gestionnaire_Email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `gestionnaire`
--

INSERT INTO `gestionnaire` (`Gestionnaire_Id`, `Gestionnaire_Nom`, `Gestionnaire_Prenom`, `Gestionnaire_Email`, `Gestionnaire_MotDePasse`) VALUES
(3, 'Chollet', 'Christelle', 'Chollet.Christelle@gefor.com', 'chollet'),
(4, 'Malissard', 'Guillaume', 'gmalissard@gefor.com', 'malissard');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `candidat`
--
ALTER TABLE `candidat`
  ADD CONSTRAINT `candidat_ibfk_1` FOREIGN KEY (`Candidat_Id`) REFERENCES `contact` (`Contact_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dossier`
--
ALTER TABLE `dossier`
  ADD CONSTRAINT `dossier_ibfk_1` FOREIGN KEY (`Gestionnaire_Id`) REFERENCES `gestionnaire` (`Gestionnaire_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossier_ibfk_2` FOREIGN KEY (`Candidat_Id`) REFERENCES `candidat` (`Candidat_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
