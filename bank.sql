-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 23 mars 2024 à 16:09
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bank`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `matricule` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`nom`, `prenom`, `matricule`) VALUES
('zied', 'baccouch', 1145),
('karima', 'moulelhi', 1234),
('khouloud', 'yaakoubi', 5800);

-- --------------------------------------------------------

--
-- Structure de la table `ajout`
--

CREATE TABLE `ajout` (
  `num_cin` int(8) NOT NULL,
  `montant` int(30) NOT NULL,
  `date` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `ajout`
--

INSERT INTO `ajout` (`num_cin`, `montant`, `date`) VALUES
(12345678, 440, '2024-01-16'),
(12345678, 440, '2024-01-16'),
(12345678, 440, '2024-01-16'),
(12345678, 1, '2024-01-16'),
(125445, 440, '2024-01-16'),
(12345678, 1000, '2024-01-17'),
(12345678, 950, '2024-01-17'),
(12345678, 500, '2024-01-18'),
(12345678, 1, '2024-01-21'),
(12345678, 250, '2024-02-01'),
(12345678, 640, '2024-02-08'),
(12345678, 250, '2024-02-09'),
(12345678, 500, '2024-02-09'),
(12345678, 150, '2024-02-21');

-- --------------------------------------------------------

--
-- Structure de la table `chef`
--

CREATE TABLE `chef` (
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `matricule` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `chef`
--

INSERT INTO `chef` (`nom`, `prenom`, `matricule`) VALUES
('walid', 'lahzemi', 5250);

-- --------------------------------------------------------

--
-- Structure de la table `retirer`
--

CREATE TABLE `retirer` (
  `num_cin` int(8) NOT NULL,
  `montant` int(30) NOT NULL,
  `date` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `retirer`
--

INSERT INTO `retirer` (`num_cin`, `montant`, `date`) VALUES
(12345678, 441, '2024-01-16'),
(12345678, 1000, '2024-01-17'),
(12345678, 666, '2024-01-17'),
(12345678, 350, '2024-01-18'),
(12345678, 435, '2024-01-21'),
(66665555, 2500, '2024-01-29'),
(12345678, 500, '2024-01-31'),
(12345678, 750, '2024-02-01'),
(14559966, 2000, '2024-02-06'),
(14526688, 400, '2024-02-08'),
(12345678, 140, '2024-02-08'),
(12345678, 750, '2024-02-09'),
(12345678, 250, '2024-02-10'),
(12345678, 300, '2024-02-21');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `num_cin` int(8) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `sexe` varchar(30) NOT NULL,
  `date_nais` varchar(30) NOT NULL,
  `numero_tel` int(8) NOT NULL,
  `adresse` varchar(30) NOT NULL,
  `profession` varchar(30) NOT NULL,
  `solde` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`num_cin`, `nom`, `prenom`, `sexe`, `date_nais`, `numero_tel`, `adresse`, `profession`, `solde`) VALUES
(12345678, 'zied', 'baccouch', 'masculin', '2003-10-14', 53063160, 'menzah', 'developpeur', 2100),
(14521452, 'haythem', 'jouini', 'Masculin', '1980-02-14', 23232323, 'marsa', 'joueur', 1540),
(14526688, 'laith', 'bouguerra', 'Masculin', '2003-09-16', 50085176, 'mhamdia', 'etudiant ', 600),
(14559966, 'koussay', 'nfissi', 'Masculin', '2003-06-20', 22048072, 'mhamdia', 'mafia', 5620),
(66665555, 'medamine', 'jery', 'Masculin', '2003-05-14', 25321963, 'cite zouhour', 'ing', 12000),
(88882222, 'saifeddine', 'yaakoubi', 'Masculin', '2003-06-12', 93561234, 'mourouj', 'cycliste', 8233);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chef`
--
ALTER TABLE `chef`
  ADD PRIMARY KEY (`matricule`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`num_cin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
