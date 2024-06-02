-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : sam. 01 juin 2024 à 09:55
-- Version du serveur : 5.7.39
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sportify`
--

-- --------------------------------------------------------

--
-- Structure de la table `Coachs`
--

CREATE TABLE `Coachs` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `specialite` varchar(255) DEFAULT NULL,
  `salle` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Coachs`
--

INSERT INTO `Coachs` (`id`, `utilisateur_id`, `nom`, `prenom`, `specialite`, `salle`, `email`, `telephone`, `cv`, `photo`) VALUES
(1, NULL, 'caquarette', 'juliette', 'fitness', 'Em226', 'juliette.caquarette@sportify.com', '0772879621', 'cv_66586381b80ee.xml', 'image coachs/JulietteCaquarette.png'),
(3, NULL, 'Baskier', 'Fabien', 'Basketball', 'Em320', 'fabien.baskier@sportify.com', '0785490314', 'cv_665a41115395c.xml', 'image coachs/FabienBaskier.png'),
(4, NULL, 'Garin', 'Christophe ', 'Football', 'Sc210', 'christphe.garin@sportify.com', '0654392109', 'cv_665a438eccbfe.xml', 'image coachs/ChristopheGarin.png'),
(5, NULL, 'Trouvé', 'Antoine', 'Plongeon', 'G002', 'antoine.trouve@sportify.com', '0765438291', 'cv_665a4c9ac4a39.xml', 'image coachs/AntoineTrouve.png');

-- --------------------------------------------------------

--
-- Structure de la table `creneau`
--

CREATE TABLE `creneau` (
  `id` int(11) NOT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `jour` enum('lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche') NOT NULL,
  `heure_debut` time NOT NULL,
  `statut_creneau` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Messages`
--

CREATE TABLE `Messages` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `message_content` text NOT NULL,
  `message_type` enum('text','audio') NOT NULL,
  `temps` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Reservation`
--

CREATE TABLE `Reservation` (
  `id` int(11) NOT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `statut` enum('confirmé','annulé') DEFAULT 'confirmé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE `Utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `type` enum('administrateur','coach','client') NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `carte_etudiant` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Utilisateurs`
--

INSERT INTO `Utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `type`, `adresse`, `carte_etudiant`, `telephone`) VALUES
(6, 'simon', 'lucien', 'lulu@gmail.com', '$2y$10$OdDY3HIt6PMX..PWg.vp1.YPbcDAEDDPSTJ4b3nfSFz/MkAlmAx5a', 'client', '5 rue de la webdynamique, paris, 75015, france', '0651511560', '0651511560'),
(8, 'louis', 'arthur', 'arthur@gmail.com', '$2y$10$MUhHoAhm/m/fJGuW1coj0ONt1Lwy8kYZslajFTdfMkShXSGLufb8.', 'client', '7 rue Arthur, paris, 75012, france', '043525352534', '062323232323');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Coachs`
--
ALTER TABLE `Coachs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `creneau`
--
ALTER TABLE `creneau`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coach_id` (`coach_id`);

--
-- Index pour la table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`utilisateur_id`),
  ADD KEY `receiver_id` (`coach_id`);

--
-- Index pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coach_id` (`coach_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `UC_Email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Coachs`
--
ALTER TABLE `Coachs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `creneau`
--
ALTER TABLE `creneau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Messages`
--
ALTER TABLE `Messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Coachs`
--
ALTER TABLE `Coachs`
  ADD CONSTRAINT `coachs_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `Utilisateurs` (`id`);

--
-- Contraintes pour la table `creneau`
--
ALTER TABLE `creneau`
  ADD CONSTRAINT `creneau_ibfk_1` FOREIGN KEY (`coach_id`) REFERENCES `Coachs` (`id`);

--
-- Contraintes pour la table `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `messages_receiver_fk` FOREIGN KEY (`coach_id`) REFERENCES `Utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_fk` FOREIGN KEY (`utilisateur_id`) REFERENCES `Utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`coach_id`) REFERENCES `Coachs` (`id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `Utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
