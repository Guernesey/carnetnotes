-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 15 Septembre 2016 à 10:36
-- Version du serveur :  5.5.50-0+deb8u1
-- Version de PHP :  5.6.24-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `saintjeaneudes`
--

-- --------------------------------------------------------

--
-- Structure de la table `Classes`
--

CREATE TABLE IF NOT EXISTS `Classes` (
  `Indexs` int(10) NOT NULL,
  `Classe` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Prenom` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Nom` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NomComplet` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Naissance` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Matieres`
--

CREATE TABLE IF NOT EXISTS `Matieres` (
`Cle` int(11) NOT NULL,
  `IndMat` text COLLATE utf8_unicode_ci NOT NULL,
  `Matiere1` text COLLATE utf8_unicode_ci NOT NULL,
  `MatiereAff` text COLLATE utf8_unicode_ci NOT NULL,
  `Classe` text COLLATE utf8_unicode_ci NOT NULL,
  `Tri` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Notes`
--

CREATE TABLE IF NOT EXISTS `Notes` (
`indexn` int(11) NOT NULL,
  `IndEleve` int(11) NOT NULL,
  `Classe` text COLLATE utf8_unicode_ci NOT NULL,
  `Matiere` text COLLATE utf8_unicode_ci NOT NULL,
  `IndMat2` int(11) NOT NULL,
  `Type` text COLLATE utf8_unicode_ci NOT NULL,
  `IndType` int(11) NOT NULL,
  `Date1` date NOT NULL,
  `Periode` text COLLATE utf8_unicode_ci NOT NULL,
  `somme` decimal(11,2) NOT NULL,
  `nombre` int(11) NOT NULL,
  `Note` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Periodes`
--

CREATE TABLE IF NOT EXISTS `Periodes` (
`Indexper` int(11) NOT NULL,
  `Nomperiode` text COLLATE utf8_unicode_ci NOT NULL,
  `Debutperiode` date NOT NULL,
  `Finperiode` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Types`
--

CREATE TABLE IF NOT EXISTS `Types` (
`indext` int(11) NOT NULL,
  `Type` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Classes`
--
ALTER TABLE `Classes`
 ADD PRIMARY KEY (`Naissance`), ADD UNIQUE KEY `Naissance` (`Naissance`), ADD KEY `Indexs` (`Indexs`), ADD KEY `Naissance_2` (`Naissance`);

--
-- Index pour la table `Matieres`
--
ALTER TABLE `Matieres`
 ADD PRIMARY KEY (`Cle`);

--
-- Index pour la table `Notes`
--
ALTER TABLE `Notes`
 ADD PRIMARY KEY (`indexn`);

--
-- Index pour la table `Periodes`
--
ALTER TABLE `Periodes`
 ADD PRIMARY KEY (`Indexper`);

--
-- Index pour la table `Types`
--
ALTER TABLE `Types`
 ADD PRIMARY KEY (`indext`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Matieres`
--
ALTER TABLE `Matieres`
MODIFY `Cle` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT pour la table `Notes`
--
ALTER TABLE `Notes`
MODIFY `indexn` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT pour la table `Periodes`
--
ALTER TABLE `Periodes`
MODIFY `Indexper` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `Types`
--
ALTER TABLE `Types`
MODIFY `indext` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
