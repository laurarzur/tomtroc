-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 08, 2026 at 07:35 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tomtroc`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `available` tinyint NOT NULL DEFAULT '1',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'default-book.jpg',
  `owner_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `author`, `review`, `available`, `img`, `owner_id`) VALUES
(1, 'Le Seigneur des Anneaux : Les Deux Tours', 'J.R.R. Tolkien', 'Le deuxième volet de J.R.R. trilogie. \"Le Seigneur des Anneaux : Les Deux Tours\" de Tolkien continue le voyage de Frodon et de ses compagnons dans leur lutte contre le mal qui menace la Terre du Milieu. Publié en 1954, ce chef-d\'œuvre de la fantasy épique compte 559 pages, plongeant les lecteurs dans un monde plein de dangers, d\'aventures et de personnages inoubliables.', 1, 'book_690477f5056ad2.56147719.jpg', 1),
(2, 'Wabi Sabi', 'Beth Kempton', 'Très intéressant ! Amoureux de la culture japonaise, ce livre m\'a fait découvrir le wabisabi... et la beauté de l\'imperfection...', 1, 'book_68ffabd03ff378.50115298.jpg', 2),
(3, 'Lait et Miel', 'Rupi Kaur', 'Baudelaire doit se retourner dans sa tombe. Je cherche encore la poésie. Si vous la voyez, faite moi signe. C’est un recueil de citation instagramable, juste fait pour être Instagramé. Aucune majuscule, la ponctuation est vraiment… bref c’est nul, je l’ai lu en moins d’une heure, et j’ai juste perdu 10€ et du temps.', 1, 'book_68ffac6bea1821.06334004.jpg', 3),
(4, '101 Essais qui vont Changer votre façon de Penser', 'Brianna Wiest', 'J\'ai lu ce livre et j\'ai été immédiatement époustouflé par la profondeur, l\'éclaircissement, l\'enchantement, la confrontation et le réconfort de ce livre - le tout en un ! Je suis amoureux. \r\nPour moi, c\'était comme Eat, Pray, Love (Elizabeth Gilbert) combiné à Atlas of the Heart (Brené Brown). Je me sens très reconnaissant d’être tombé sur ce joyau !', 1, 'book_68ffabdcbf44e7.69800629.jpg', 2),
(5, 'Beautiful Resistance', 'Jon Tyson', 'Vous éprouvez un sentiment de malaise ou de découragement à l&#039;égard du monde et en particulier de l&#039;Église ? Ce livre allumera une allumette dans la fournaise de votre âme. J&#039;ai adoré.\r\n', 1, 'book_68ffa8491f5376.24599833.jpg', 1),
(7, 'Les fables de La Fontaine', 'Jean de La Fontaine', 'J&#039;AIME BIEN LES FABLES DE JEAN DE LA FONTAINE\r\n', 1, 'book_6a26ed3a8ff495.32912128.jpg', 4),
(8, 'On ne meurt pas d\'amour', 'Géraldine Dalban-Moreynas', 'Les mots me manquent. Je me suis laissé convaincre par les avis et la distinction reçue pour ce roman. Au delà même du cliché, inintéressant, long, plat, ennuyeux, aucun style, la plume n’est même pas appliquée. Aucune véritable histoire, répétition insupportable des mêmes faits, decrits avec les mêmes mots. Tout a fait décevant. Mes lectures d’ado Gossip Girl étaient, de loin, bien meilleures. Ne vous laissez pas avoir...', 1, 'book_68ffae80c80078.60522615.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `conversation`
--

CREATE TABLE `conversation` (
  `id` int NOT NULL,
  `first_interlocutor_id` int NOT NULL,
  `second_interlocutor_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversation`
--

INSERT INTO `conversation` (`id`, `first_interlocutor_id`, `second_interlocutor_id`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 4, 1),
(4, 4, 2),
(5, 4, 3),
(6, 5, 2),
(8, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `seen` tinyint NOT NULL DEFAULT '0',
  `sender_id` int NOT NULL,
  `recipient_id` int NOT NULL,
  `conversation_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `content`, `created_at`, `seen`, `sender_id`, `recipient_id`, `conversation_id`) VALUES
(1, 'Bonjour, je souhaite échanger un livre.', '2025-06-06 08:55:08', 1, 2, 1, 1),
(2, 'Salut, je suis intéressé par Le Seigneur des Anneaux!', '2025-06-06 08:55:08', 1, 3, 1, 2),
(3, 'Lequel ?', '2025-06-06 09:10:04', 1, 1, 2, 1),
(4, 'Allô ? Je suis intéressé par Le Seigneur des Anneaux!', '2025-06-06 09:35:34', 1, 3, 1, 2),
(5, 'Salut j\'ai les fables de La Fontaine si ça t\'intéresse !!', '2025-10-31 19:00:48', 1, 4, 1, 3),
(6, 'Salut j\'ai les fables de La Fontaine si ça t\'intéresse !!', '2025-10-31 19:01:08', 1, 4, 2, 4),
(7, 'Salut j\'ai les fables de La Fontaine si ça t\'intéresse !!', '2025-10-31 19:01:20', 0, 4, 3, 5),
(8, 'Super bouquin !', '2025-10-31 19:01:31', 1, 4, 1, 3),
(9, 'Dis-moi si ça t\'intéresse !', '2025-10-31 19:01:59', 1, 4, 1, 3),
(10, 'Bonjour, c\'est gentil mais je ne suis pas intéressé', '2025-11-06 11:29:35', 1, 1, 4, 3),
(11, 'Pardon, je n\'avais pas vu vos messages... Vous êtes toujours intéressé ?', '2025-11-06 11:53:11', 0, 1, 3, 2),
(12, 'Salut, ce serait possible que tu me prête les 101 essais stp ? ☺️', '2025-11-06 15:28:56', 1, 5, 2, 6),
(13, 'Bonjour. Oui, aucun souci. Tu n\'as pas de livres à échanger ?', '2025-11-06 15:31:27', 1, 2, 5, 6),
(14, 'Bonjour, non merci. Je l\'ai déjà lu.', '2025-11-06 15:31:59', 1, 2, 4, 4),
(15, 'Peu importe, je n\'ai pas lu ceux que tu proposes.', '2025-11-06 15:32:30', 1, 2, 1, 1),
(17, 'Dommage', '2026-06-08 18:21:36', 1, 4, 2, 4),
(18, 'Bonjour, il est bien le livre ?', '2026-06-08 18:24:31', 1, 6, 3, 8),
(19, 'Lequel ??', '2026-06-08 18:25:13', 0, 3, 6, 8),
(20, 'Non désolé !', '2026-06-08 18:27:22', 0, 5, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'default-avatar.jpg',
  `public` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `pwd`, `created_at`, `avatar`, `public`) VALUES
(1, 'rkive', 'namjoon@gmail.com', '$2a$10$3egD6uL7Ut2A5vu7jLwaxOiUfDBtgHRaDhOPnul8.KkLO58kZsvea', '2025-05-02 11:52:16', 'avatar_690487220048d1.96682118.jpg', 1),
(2, 'agustd', 'yoongi@gmail.com', '$2a$10$8co3nKIfLXObvT3FeJPUFeaIUyeFAr6rOGvggbdmH6bT8GW87IgHe', '2025-05-02 11:52:16', 'avatar_68fe72ac4a6ce9.58360567.jpg', 1),
(3, 'uarmyhope', 'hobi@gmail.com', '$2a$10$3hiAxpw/SMIvIDw4WFK6MOwYf9qinrYOl1y2CfSGGrT2boqcDK5EO', '2025-05-02 11:52:16', 'avatar_68fe72c0e2f1c4.43154014.jpg', 1),
(4, 'jin', 'jin@gmail.com', '$2y$10$HujavnYxD0g.QK0ptSiXsOP6hO/QBOnYyaU0xwWBJq9ujqmJcGBAK', '2025-10-17 10:40:06', 'avatar_6a26ed1ee61d39.52533732.jpg', 0),
(5, 'jimin', 'jimin@gmail.com', '$2y$10$fIWYMdFaHaZHjTXVay919.i9tdaNE872Y/uHFfhl1y1yXwjJ1gUoS', '2025-10-17 10:57:10', 'avatar_68fe73af84be99.30787822.jpg', 1),
(6, 'thv', 'tae@gmail.com', '$2y$10$w35Ymqzz5Ukzx9zkyiKGBe5g3R6p/JV0hQpO6g5sv9VTVWKZwiH.m', '2025-11-12 17:58:43', 'default-avatar.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_owner` (`title`,`owner_id`),
  ADD KEY `fk_book_user` (`owner_id`);

--
-- Indexes for table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_conversation` (`first_interlocutor_id`,`second_interlocutor_id`),
  ADD KEY `fk_conversation_user_2` (`second_interlocutor_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_message_sender` (`sender_id`),
  ADD KEY `fk_message_recipient` (`recipient_id`),
  ADD KEY `fk_message_conversation` (`conversation_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `fk_book_user` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `conversation`
--
ALTER TABLE `conversation`
  ADD CONSTRAINT `fk_conversation_user_1` FOREIGN KEY (`first_interlocutor_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_conversation_user_2` FOREIGN KEY (`second_interlocutor_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_conversation` FOREIGN KEY (`conversation_id`) REFERENCES `conversation` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_message_recipient` FOREIGN KEY (`recipient_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_message_sender` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
