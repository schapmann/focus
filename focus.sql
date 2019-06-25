-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 25 juin 2019 à 18:06
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `focus`
--

-- --------------------------------------------------------

--
-- Structure de la table `amis`
--

DROP TABLE IF EXISTS `amis`;
CREATE TABLE IF NOT EXISTS `amis` (
  `pseudo1` varchar(255) NOT NULL,
  `pseudo2` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `amis`
--

INSERT INTO `amis` (`pseudo1`, `pseudo2`) VALUES
('Martine', 'Dylan'),
('Dylan', 'Martine'),
('Martine', 'Valentin'),
('Valentin', 'Martine');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `idN` int(11) NOT NULL,
  `pseudo1` varchar(255) NOT NULL,
  `pseudo2` varchar(255) NOT NULL,
  `idPhoto` int(11) NOT NULL,
  PRIMARY KEY (`idN`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`idN`, `pseudo1`, `pseudo2`, `idPhoto`) VALUES
(40, 'Martine', 'Dylan', 30),
(41, 'Martine', 'Dylan', 29),
(42, 'Martine', 'Dylan', 34);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `idN` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `destinataire` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  PRIMARY KEY (`idN`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`idN`, `pseudo`, `destinataire`, `action`) VALUES
(42, 'Martine', 'Dylan', 'likes'),
(39, 'Valentin', 'Jean-françois', 'amis'),
(38, 'Valentin', 'Dylan', 'amis');

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `idP` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `visible` int(11) NOT NULL,
  PRIMARY KEY (`idP`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`idP`, `pseudo`, `extension`, `visible`) VALUES
(31, 'Dylan', 'jpg', 2),
(29, 'Dylan', 'jpg', 1),
(30, 'Dylan', 'jpg', 1),
(32, 'Dylan', 'jpg', 1),
(33, 'Dylan', 'jpg', 1),
(34, 'Dylan', 'jpg', 1),
(35, 'Dylan', 'jpg', 1),
(36, 'Martine', 'jpg', 2),
(37, 'Martine', 'jpg', 1),
(38, 'Martine', 'jpg', 0),
(39, 'Martine', 'jpg', 1),
(40, 'Martine', 'jpg', 1),
(41, 'Martine', 'jpg', 1),
(42, 'Martine', 'jpg', 1),
(48, 'Jean-françois', 'jpg', 1),
(45, 'Martine', 'jpg', 1),
(46, 'Martine', 'jpg', 1),
(47, 'Martine', 'jpg', 1),
(49, 'Jean-françois', 'jpg', 1),
(50, 'Jean-françois', 'jpg', 1),
(51, 'Jean-françois', 'jpg', 1),
(52, 'Jean-françois', 'jpg', 1),
(53, 'Jean-françois', 'jpg', 1),
(54, 'Jean-françois', 'jpg', 1),
(55, 'Jean-françois', 'jpg', 2),
(56, 'Valentin', 'jpg', 1),
(57, 'Valentin', 'jpg', 1),
(58, 'Valentin', 'jpg', 1),
(59, 'Valentin', 'jpg', 1),
(60, 'Valentin', 'jpg', 1),
(61, 'Valentin', 'jpg', 1),
(62, 'Valentin', 'jpg', 1),
(63, 'Valentin', 'jpg', 2),
(64, 'Valentin', 'jpg', 1),
(65, 'Rachel', 'jpg', 1),
(66, 'Rachel', 'jpg', 1),
(67, 'Rachel', 'jpg', 1),
(68, 'Rachel', 'jpg', 1),
(69, 'Rachel', 'jpg', 1),
(70, 'Rachel', 'jpg', 1),
(71, 'Rachel', 'jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `passe`) VALUES
(6, 'Dylan', 'mdp'),
(9, 'Martine', 'mdp'),
(10, 'Jean-françois', 'mdp'),
(11, 'Valentin', 'mdp'),
(12, 'Rachel', 'mdp');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
