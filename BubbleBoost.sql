-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  mer. 15 jan. 2020 à 00:51
-- Version du serveur :  5.7.28-0ubuntu0.18.04.4
-- Version de PHP :  7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `BubbleBoost`
--
DROP DATABASE IF EXISTS `BubbleBoost`;
CREATE DATABASE IF NOT EXISTS `BubbleBoost` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `BubbleBoost`;

-- --------------------------------------------------------

--
-- Structure de la table `bulles_suivies`
--

CREATE TABLE `bulles_suivies` (
  `id_user` int(11) NOT NULL,
  `id_story` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `chapter`
--

CREATE TABLE `chapter` (
  `id` int(11) NOT NULL,
  `id_story` int(11) NOT NULL,
  `chapitre` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `cover` varchar(255) NOT NULL,
  `publication_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `global_views` int(11) NOT NULL DEFAULT '0',
  `period_views` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chapter`
--

INSERT INTO `chapter` (`id`, `id_story`, `chapitre`, `title`, `cover`, `publication_date`, `global_views`, `period_views`) VALUES
(1, 1, 1, NULL, 'cover.jpg', '2020-01-10 14:46:43', 0, 0),
(2, 1, 2, NULL, 'cover.jpg', '2020-01-14 17:08:01', 0, 0),
(3, 1, 3, NULL, 'cover.jpg', '2020-01-14 17:08:01', 0, 0),
(4, 1, 4, NULL, 'cover.jpg', '2020-01-14 17:08:01', 0, 0),
(5, 1, 5, NULL, 'cover.jpg', '2020-01-14 17:08:01', 0, 0),
(6, 2, 1, 'Death&Strawberry', 'cover.jpg', '2020-01-15 00:12:59', 0, 0),
(7, 2, 2, 'Starter', 'cover.jpg', '2020-01-15 00:13:00', 0, 0),
(8, 2, 3, 'Headhittin\'', 'cover.png', '2020-01-15 00:14:00', 0, 0),
(9, 2, 4, 'WHY DO YOU EAT IT ?', 'cover.png', '2020-01-15 00:40:15', 0, 0),
(10, 2, 5, 'Binda • blinda', 'cover.png', '2020-01-15 00:40:15', 0, 0),
(11, 2, 6, 'microcrack.', 'cover.png', '2020-01-15 00:40:15', 0, 0),
(12, 2, 7, 'The Pink Cheeked Parakeet', 'cover.png', '2020-01-15 00:40:15', 0, 0),
(13, 2, 8, 'Chase Chad Around', 'cover.png', '2020-01-15 00:40:15', 0, 0),
(14, 2, 9, 'Monster and a Transfer [Struck Down]', 'cover.png', '2020-01-15 00:40:15', 0, 0),
(15, 2, 10, 'Monster and a Transfer pt.2 [The Deathberry]', 'cover.png', '2020-01-15 00:40:15', 0, 0),
(16, 2, 11, 'Back. [Leachbomb or Mom]', 'cover.png', '2020-01-15 00:40:15', 0, 0),
(17, 2, 12, 'The Gate of The End', 'cover.png', '2020-01-15 00:40:15', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_chapter` int(11) NOT NULL,
  `comment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `id_user`, `id_chapter`, `comment_date`, `comment`) VALUES
(1, 1, 1, '2020-01-14 18:57:52', 'Chapitre palpitant, hâte de voir la suite !'),
(2, 1, 2, '2020-01-14 21:11:18', 'Classe ce chapitre 2 !');

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `genre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `genre`) VALUES
(1, 'Action'),
(2, 'Aventure'),
(3, 'Biographique'),
(4, 'Comédie'),
(5, 'Crossover'),
(6, 'Drame'),
(7, 'Ecchi'),
(8, 'Erotique'),
(9, 'Fantastique'),
(10, 'Fantasy'),
(11, 'Histoires courtes'),
(12, 'Historique'),
(13, 'Horreur'),
(14, 'Mature'),
(15, 'Mystère'),
(16, 'Psychologique'),
(17, 'Romance'),
(18, 'School Life'),
(19, 'Science-fiction'),
(20, 'Shôjo-aï'),
(21, 'Shônen-aï'),
(22, 'Slice of Life'),
(23, 'Surnaturel'),
(24, 'Thriller'),
(25, 'Tournois'),
(26, 'Tragique'),
(27, 'Yonkoma');

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `id_user_exp` int(11) NOT NULL,
  `id_user_dest` int(11) NOT NULL,
  `notification_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` int(11) NOT NULL,
  `open` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `story`
--

CREATE TABLE `story` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `synopsis` text,
  `cover` varchar(255) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `publication_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `global_views` int(11) NOT NULL DEFAULT '0',
  `period_views` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `story`
--

INSERT INTO `story` (`id`, `title`, `synopsis`, `cover`, `id_user`, `publication_date`, `global_views`, `period_views`) VALUES
(1, 'Gamaran', 'À l’ère Edo, le fief Unabara rassemble les maîtres d’arts martiaux ne vivant que pour le combat. On surnomme cette terre le « l’antre des démons ». Gama a seulement 14 ans mais il décide de représenter l’école Ôgame lors du grand Tournoi d’Unabara. Arrivera-t-il à prouver sa valeur dans cette impitoyable compétition ? Que le combat commence !!!', 'cover.jpg', 1, '2020-01-10 14:33:49', 0, 0),
(2, 'Bleach', 'Le récit commence en 2001 au Japon dans la ville fictive de Karakura. Ichigo Kurosaki, lycéen de 15 ans, arrive à voir, entendre et toucher les âmes des morts depuis qu\'il est tout petit. Un soir, sa routine quotidienne vient à être bouleversée à la suite de sa rencontre avec une shinigami (死神?, littéralement « dieu de la mort »), Rukia Kuchiki, et la venue d\'un monstre appelé hollow. Ce dernier étant venu dévorer les âmes de sa famille et la shinigami venue le protéger ayant été blessée par sa faute, Ichigo accepte de devenir lui-même un shinigami afin de les sauver.\r\n\r\nCependant, le transfert de pouvoir, censé être temporaire et partiel, est complet et ne s\'achève pas. Ichigo est forcé de prendre la responsabilité de la tâche incombant à Rukia Kuchiki. Il commence donc la chasse aux hollows tout en protégeant les âmes humaines.\r\n\r\nLe début est centré sur une chasse aux mauvais esprits relativement peu puissants, avec un simple sabre. L\'histoire va peu à peu se diriger vers un vaste complot mystico-politique après l\'apparition des premiers autres shinigami. Les batailles au sabre du commencement vont alors se métamorphoser en combats dantesques avec des armes aux pouvoirs surprenants et variés, et parfois aux proportions gigantesques. ', 'cover.jpg', 1, '2020-01-15 00:12:49', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `story_genre`
--

CREATE TABLE `story_genre` (
  `id_story` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `story_genre`
--

INSERT INTO `story_genre` (`id_story`, `id_genre`) VALUES
(2, 1),
(2, 2),
(2, 4),
(1, 6),
(1, 13),
(2, 21),
(2, 23);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'member',
  `country` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `birthday_date` date DEFAULT NULL,
  `tipeee` varchar(255) DEFAULT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `registration_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `role`, `country`, `phone`, `birthday_date`, `tipeee`, `mail`, `password`, `avatar`, `registration_date`, `token`) VALUES
(1, 'Lorris', 'Volff', 'EternalStay', 'member', 'FRANCE', '0637604429', '1998-01-10', NULL, 'volff.lorris@gmail.com', '$2y$10$HREvGYb73Q86hPXMOUxMwOJCZpWPXzeZE4GUO/OdYrVfFqrxAXZbe', 'default.jpg', '2020-01-10 14:19:39', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bulles_suivies`
--
ALTER TABLE `bulles_suivies`
  ADD PRIMARY KEY (`id_user`,`id_story`),
  ADD KEY `id_story` (`id_story`);

--
-- Index pour la table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_ibfk_1` (`id_story`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chapter` (`id_chapter`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_dest` (`id_user_dest`),
  ADD KEY `id_user_exp` (`id_user_exp`);

--
-- Index pour la table `story`
--
ALTER TABLE `story`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `story_genre`
--
ALTER TABLE `story_genre`
  ADD PRIMARY KEY (`id_story`,`id_genre`),
  ADD KEY `id_genre` (`id_genre`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `story`
--
ALTER TABLE `story`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bulles_suivies`
--
ALTER TABLE `bulles_suivies`
  ADD CONSTRAINT `bulles_suivies_ibfk_1` FOREIGN KEY (`id_story`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bulles_suivies_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `chapter`
--
ALTER TABLE `chapter`
  ADD CONSTRAINT `chapter_ibfk_1` FOREIGN KEY (`id_story`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_chapter`) REFERENCES `chapter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`id_user_dest`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`id_user_exp`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `story`
--
ALTER TABLE `story`
  ADD CONSTRAINT `story_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `story_genre`
--
ALTER TABLE `story_genre`
  ADD CONSTRAINT `story_genre_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `story_genre_ibfk_2` FOREIGN KEY (`id_story`) REFERENCES `story` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
