-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 02 juin 2024 à 17:31
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

--
-- Déchargement des données de la table `creneau`
--

INSERT INTO `creneau` (`id`, `coach_id`, `jour`, `heure_debut`, `statut_creneau`) VALUES
(1, 3, 'lundi', '09:00:00', 0),
(2, 3, 'lundi', '14:00:00', 0),
(3, 3, 'mercredi', '09:00:00', 0),
(4, 3, 'mercredi', '14:00:00', 0),
(5, 3, 'mercredi', '14:00:00', 0),
(6, 3, 'vendredi', '09:00:00', 0),
(7, 3, 'vendredi', '14:00:00', 0),
(8, 5, 'lundi', '11:00:00', 0),
(9, 5, 'lundi', '17:00:00', 0),
(10, 5, 'mercredi', '11:00:00', 0),
(11, 5, 'mercredi', '17:00:00', 0),
(12, 5, 'vendredi', '11:00:00', 0),
(13, 5, 'vendredi', '17:00:00', 0),
(20, 4, 'lundi', '10:00:00', 0),
(21, 4, 'lundi', '16:00:00', 0),
(22, 4, 'mercredi', '10:00:00', 0),
(23, 4, 'mercredi', '16:00:00', 0),
(24, 4, 'vendredi', '10:00:00', 0),
(25, 4, 'vendredi', '16:00:00', 0),
(26, 1, 'mardi', '09:00:00', 1),
(27, 1, 'mardi', '14:00:00', 0),
(28, 1, 'jeudi', '09:00:00', 0),
(29, 1, 'jeudi', '14:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `timestamp`) VALUES
(1, 1, 6, 'coucou', '2024-06-02 14:59:26'),
(2, 1, 6, 'ca va ?', '2024-06-02 15:00:13'),
(3, 6, 1, 'oui et toi', '2024-06-02 15:01:20');

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
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
