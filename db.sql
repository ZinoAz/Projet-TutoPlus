-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 02:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tuto`
--

-- --------------------------------------------------------

--
-- Table structure for table `disponibilites`
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
  `statut` enum('disponible','reserve','enattente') DEFAULT 'disponible',
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `client_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disponibilites`
--

INSERT INTO `disponibilites` (`id`, `tuteur_id`, `service_id`, `date_creneau`, `heure_debut`, `heure_fin`, `duree_minutes`, `notes`, `statut`, `date_creation`, `client_id`) VALUES
(4, 2, 1, '2025-11-16', '14:00:00', '15:30:00', 90, 'Programmation orientée objet', 'disponible', '2025-11-09 00:49:36', NULL),
(5, 2, 5, '2025-11-13', '10:00:00', '11:00:00', 60, 'Programmation Android', 'disponible', '2025-11-09 00:49:36', NULL),
(9, 1, 1, '2025-11-26', '19:10:00', '00:00:00', 90, 'test', 'reserve', '2025-11-24 21:07:35', 2);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tuteur_id` int(11) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `nom_service` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `actif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `nom_service`, `description`, `actif`) VALUES
(1, 'Programmation orientée objet', 'Aide en POO', 1),
(2, 'Programmation IOS', 'Aide en programmation iOS', 1),
(3, 'Programmation Web', 'Aide en développement web', 1),
(4, 'Réseaux locaux', 'Installation, configuration et maintenance de réseaux locaux', 1),
(5, 'Programmation Android', 'Développement d’applications mobiles Android', 1);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `type_utilisateur` enum('etudiant','tuteur','admin') NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT 1,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `type_utilisateur`, `actif`, `date_creation`) VALUES
(5, 'Uludag', 'Ismail', '202360562@collegeahuntsic.qc.ca', '$2y$10$7OoxZkE3XE9E5zsiTFMZAOp.L69NPUbFsytwrI3U4ZcErJF6UCR.6', 'tuteur', 1, '2025-11-26 22:05:09'),
(6, 'Azouani', 'Zine-Eddine', '202277686@collegeahuntsic.qc.ca', '$2y$10$eJxQyTaTJ.kWxiVg.6yZwuY.y9Bqk/8YYw65YBA5WvVCMo8WwP.bK', 'etudiant', 1, '2025-11-26 22:05:34'),
(7, 'Boujendar', 'Adam', 'test@collegeahuntsic.qc.ca', '$2y$10$7OoxZkE3XE9E5zsiTFMZAOp.L69NPUbFsytwrI3U4ZcErJF6UCR.6', 'tuteur', 1, '2025-11-26 22:05:09'),
(8, 'Bentley Maher', 'Jeremy Jay', 'Jeremy-Bentley@collegeahuntsic.qc.ca', '$2y$10$eJxQyTaTJ.kWxiVg.6yZwuY.y9Bqk/8YYw65YBA5WvVCMo8WwP.bK', 'admin', 1, '2025-11-26 22:05:34'),
(9, 'Admin', '1', 'admin@collegeahuntsic.qc.ca', '$2y$10$MQDqml73kI1H2hxSfjhTP.Cu/QLBW6q1rUPZlfuV7YNUdxjczn.6e', 'admin', 1, '2025-11-26 22:11:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disponibilites`
--
ALTER TABLE `disponibilites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tuteur_id` (`tuteur_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `tuteur_id` (`tuteur_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disponibilites`
--
ALTER TABLE `disponibilites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`tuteur_id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
