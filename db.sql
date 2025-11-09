-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 10 nov. 2025 à 00:21
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
-- Base de données : `tutoplus`
--

-- --------------------------------------------------------

--
-- Structure de la table `disponibilites`
--

CREATE TABLE `disponibilites` (
  `id` int(11) NOT NULL,
  `tuteur_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `date_creneau` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `duree_minutes` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `statut` enum('disponible','reserve') DEFAULT 'disponible',
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `disponibilites`
--

INSERT INTO `disponibilites` (`id`, `tuteur_id`, `service_id`, `date_creneau`, `heure_debut`, `heure_fin`, `duree_minutes`, `notes`, `statut`, `date_creation`) VALUES
(1, 1, 1, '2025-11-15', '10:30:00', '12:00:00', 90, 'Programmation orientée objet 2', 'disponible', '2025-11-09 00:49:36'),
(2, 1, 2, '2025-11-12', '14:00:00', '15:00:00', 60, 'Programmation IOS', 'reserve', '2025-11-09 00:49:36'),
(3, 1, 3, '2025-11-10', '09:00:00', '09:30:00', 30, 'Programmation Web1', 'disponible', '2025-11-09 00:49:36'),
(4, 2, 1, '2025-11-16', '14:00:00', '15:30:00', 90, 'Programmation Web2', 'disponible', '2025-11-09 00:49:36'),
(5, 2, 3, '2025-11-13', '10:00:00', '11:00:00', 60, 'Programmation Android', 'disponible', '2025-11-09 00:49:36');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `etudiant_id` int(11) NOT NULL,
  `disponibilite_id` int(11) NOT NULL,
  `date_reservation` timestamp NOT NULL DEFAULT current_timestamp(),
  `statut` enum('confirmee','annulee','completee') DEFAULT 'confirmee',
  `notes_etudiant` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `nom_service` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `actif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `nom_service`, `description`, `actif`) VALUES
(1, 'Programmation orientée objet', 'Aide en POO', 1),
(2, 'Programmation IOS', 'Aide en programmation iOS', 1),
(3, 'Programmation Web1', 'Aide en développement web', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `type_utilisateur` enum('etudiant','tuteur') NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `type_utilisateur`, `date_creation`) VALUES
(1, 'Azouani', 'Zine-Eddine', '202277686@collegeahuntsic.qc.ca', '123456', 'tuteur', '2025-11-09 00:49:36'),
(2, 'Uludag', 'Ismail', '2023620562@collegeahuntsic.qc.ca', '123456', 'tuteur', '2025-11-09 00:49:36'),
(3, 'Maher', 'Jeremy-Jay', 'Jeremy-Jay@collegeahuntsic.qc.ca', '123456', 'etudiant', '2025-11-09 00:49:36'),
(4, 'Boujendar', 'Adam', 'AdamFlawless@collegeahuntsic.qc.ca', '123456', 'etudiant', '2025-11-09 00:49:36');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `disponibilites`
--
ALTER TABLE `disponibilites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tuteur_id` (`tuteur_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reservation` (`etudiant_id`,`disponibilite_id`),
  ADD KEY `disponibilite_id` (`disponibilite_id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `disponibilites`
--
ALTER TABLE `disponibilites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `disponibilites`
--
ALTER TABLE `disponibilites`
  ADD CONSTRAINT `disponibilites_ibfk_1` FOREIGN KEY (`tuteur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disponibilites_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`etudiant_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`disponibilite_id`) REFERENCES `disponibilites` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
