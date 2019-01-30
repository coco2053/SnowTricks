-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 30 jan. 2019 à 19:09
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `snow-tricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `avatar_image`
--

DROP TABLE IF EXISTS `avatar_image`;
CREATE TABLE IF NOT EXISTS `avatar_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `avatar_image`
--

INSERT INTO `avatar_image` (`id`, `url`, `alt`) VALUES
(1, '3011022e51c55c00c114988324bfe2ebmoi.jpg', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  KEY `IDX_9474526CB281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `trick_id`, `content`, `created_at`) VALUES
(1, 1, 1, 'Finger in the nose !', '2019-01-22 15:45:30'),
(2, 1, 1, 'On peut le faire en ski celui là ?', '2019-01-22 15:45:42'),
(3, 1, 1, 'On m\'a demandé d\'écrire un long commentaire sur ce trick mais le problème c\'est que je n\'ai rien d’intéressant à dire...', '2019-01-22 15:45:49'),
(4, 2, 1, 'Bonjour, je suis l’internaute mystère !', '2019-01-23 23:17:38'),
(5, 2, 1, 'Ma mission', '2019-01-27 12:42:04'),
(6, 2, 1, 'est de laisser', '2019-01-27 12:42:16'),
(7, 2, 1, 'un maximum', '2019-01-27 12:42:29'),
(8, 2, 1, 'de commentaires', '2019-01-27 12:42:41'),
(9, 2, 1, 'dans le but', '2019-01-27 12:42:51'),
(10, 2, 1, 'de paginer!', '2019-01-27 12:43:03'),
(11, 2, 1, 'Je crois', '2019-01-27 12:43:21'),
(12, 2, 1, 'qu\'il en faut', '2019-01-27 12:43:32'),
(13, 2, 1, 'encore quelques uns !', '2019-01-27 12:43:46'),
(16, 3, 7, 'Un petit commentaire.', '2019-01-30 10:22:54');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20190117162612'),
('20190123105027'),
('20190123105307');

-- --------------------------------------------------------

--
-- Structure de la table `trick`
--

DROP TABLE IF EXISTS `trick`;
CREATE TABLE IF NOT EXISTS `trick` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_group_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D8F0A91E9B875DF8` (`trick_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `trick_group_id`, `name`, `content`, `created_at`, `updated_at`) VALUES
(1, 2, 'Front 180', '<p>Pour les néophytes, le backside 180 ou 180 back est un saut avec un demi tour qui s\'effectue côté pointes de pieds en envoyant les épaules dos à la pente lors de la rotation, ce qui fait qu\'à l’atterrissage on se retrouve en marche arrière. Comme dans toute rotation l’important est la synchronisation entre l’impulsion et la rotation des épaules.</p>\r\n<p>1 - La phase d’approche consiste à avoir sa planche la plus à plat possible ou légèrement sur la carre frontside ; le regard est pointé vers le spot (l’endroit où on veut décoller). Les jambes sont fléchies, prêtes à donner une impulsion.</p>\r\n<p>2 - L’impulsion : on a le choix entre un ollie façon skate (comme on peut le voir dans notre tuto sur le Ollie) et une impulsion franche à deux pieds. L’impulsion à deux pieds conviendra mieux sur un kicker de park alors qu’un ollie plus skate et un peu sur la carre est plus évident en bord de piste. Donc on envoie une impulsion  en enclenchant très doucement les épaules de 30°.</p>\r\n<p>3 - Engager la rotation à l’aveugle, de dos… pas de panique, l’astuce est de regarder votre pied arrière pour voir défiler le sol en dessous et permettre au corps de faire un 180° progressif. Attendez de voir la réception pour ajuster la board  tout en gardant les épaules dans l’axe de la planche ou légèrement en retard pour bien arrêter la rotation.</p>\r\n<p>4 - En réception : bien amortir sur les jambes, continuer de regarder entre les pieds pour garder l’équilibre. Ce n’est qu’une fois que l\'on a bien amorti qu\'on pourra relever la tête et regarder ou l\'on va…\r\nAvant d’essayer un 180 back, le mieux est d\'essayer de bien rider en switch pour que ce ne soit pas trop la panique à l’atterrissage et de bien repérer le terrain et les autres rideurs pour ne pas provoquer de collisions. \r\nÀ vous de jouer ! Comme d’habitude, allez y progressivement, amusez vous  et prenez beaucoup de plaisir pour faire des backside 180, qui est à notre avis un de plus beaux tricks du snowboard…</p>', '2019-01-18 10:05:55', '2019-01-29 23:17:33'),
(2, 1, 'Indy', '<p>La main arrière vient graber la carre frontside entre les pieds. Sur un saut droit c’est un Indy Grab, sur un hip ou un quarter en front c’est un frontside indy ou frontside grab.</p>', '2019-01-18 10:08:53', '2019-01-29 23:17:03'),
(3, 1, 'Backflip', '<p>1- Le mieux c’est de s’entrainer à le faire sur un trampoline car le mouvement est le même.</p>\r\n\r\n<p>2- Choisissez un kicker de bord de piste, qui kicke un peu de préférence, pour vous aider à envoyer facilement.</p>\r\n\r\n<p>3- Arrivez bien fléchi en appui sur les 2 jambes et fixez le bout du kicker. L’impulsion se fait à 2 pieds au bout du kicker et pas avant : si on envoie trop tôt on risque de taper la tête dans le kicker ou de trop tourner, de faire un tour et demi et de tomber sur la tête. Deux situations à éviter...</p>\r\n\r\n<p>4- Donc impulsion à deux pieds, et on envoie la tête en arrière pour chercher le mouvement. Dès que l’on a décollé il faut remonter les genoux pour enrouler le mouvement. Les profs de gym ont tendance à dire que l’on envoie le mouvement avec le bassin, ce qui n’est pas faux mais c’est surtout quand on a compris le mouvement et que l’on est à l’aise avec.</p>\r\n\r\n\r\n\r\n<p>5- Donc regrouper les jambes en les montant. A ce moment on peut aussi penser à grabber mais ce n’est pas obligé pour commencer... On continue d’emmener la rotation avec la tête en arrière.</p>\r\n\r\n<p>6- Très vite on peut voir la réception et on va pouvoir gérer la fin de al rotation soit en se tendant un peu pour la ralentir, soit en se regroupant encore davantage pour tourner plus vite.</p>\r\n\r\n<p>7- Replacez bien la board sous votre corps avant d’atterrir, et amortir en pliant les jambes.</p>', '2019-01-18 10:10:44', '2019-01-29 23:16:39'),
(4, 2, 'Frontside 720', '<p>1 - La phase d’approche consiste à arriver bien fléchi sur le kicker, la planche bien à plat, les épaules dans l’axe de la board, le regard fixé sur le bout du kicker.</p>\r\n\r\n<p>2 - L\'impulsion se fait à 2 pieds au bout du kicker. Ne pas pousser trop fort aux premiers essais au risque d’être déséquilibré. Donc impulsion à 2 pieds, en lançant la rotation avec les épaules comme un 5.4 front (voir le tuto) mais il faut les lancer plus vite et donc plus fort, à affiner selon la taille du saut. Pour un Frontside 720, on peut avoir une impulsion bien à plat,  en appui léger sur les talons ou encore en appuie pointe de pieds, suivant le style qu\'on veut donner à son tricks et surtout suivant comme on se sent le plus à l’aise de faire. Mais surtout il ne faut déraper le moins possible sur le kicker pour ne pas perdre d’élan, en particulier sur une table de park.</p>\r\n\r\n<p>3 - Pour que la rotation se fasse bien à plat il faut lancer le mouvement avec  les épaules à l’horizontale et la tête qui va vers l’épaule avant. Pour désaxer, c’est la tête qui va chercher à twister le mouvement et les épaules ne seront plus à l’horizontale.</p>\r\n\r\n<p>4 - Dès que l’on est en l’air il faut se regrouper et grabber. Pour commencer je conseille le Melon (voir tuto sur les grabs). Une fois que l’on maitrise bien le mouvement on peut changer de grab. Dans tous les cas, la main de libre va chercher à emmener la rotation et aider à contrôler la vitesse à laquelle on tourne.</p>\r\n\r\n<p>5 - Il faut aller chercher la réception du regard par dessus l’épaule avant : on l’aperçoit après 3/4 de tour puis très bien après le premier 360. À ce moment là, ne pas la fixer et continuer de regarder vers l\'épaule pour continuer à emmener la rotation. Enrouler bien le mouvement pour continuer à tourner toujours en allant chercher du regard et en s’aidant de la main qui ne grave  pas. À partir de maintenant tout va ce passer comme pour la fin d’un 3.6 front.</p>\r\n\r\n<p>6 - Quand on voit la réception arriver entre les pieds, il faut amener la board dans l’axe de la réception et détendre les jambes pour chercher à atterrir la planche la plus à plat possible.</p>\r\n\r\n<p>7 - On amortit bien en regardant ses pieds pour être sûr que la rotation s’arrête. Le défaut le plus commun est de regarder devant au moment ou on atterrit. Du coup, sans en avoir conscience, les  épaules ont fait quelques degrés de plus car elles continuent à tourner emportées par le mouvement, ce qui déséquilibre la réception, et souvent on tombe sur le cul. Donc réception en appuie sur les deux pieds, en regardant ses pieds, on ne relève la tête qu’une fois que l’on a bien amorti.</p>', '2019-01-18 10:13:01', '2019-01-29 23:16:14'),
(5, 1, 'Mute', '<p>La main avant grabbe la carre frontside entre les pieds.</p>', '2019-01-18 10:15:29', '2019-01-29 23:16:28'),
(7, 2, 'Backside 540', '<p>1 - Avant tout, il faut bien maitriser le fait de rider en switch avec aisance ainsi que le switch 180 back pour l’arrivé sur le kick et les 360 front pour la fin de la rotation et le replaquage.</p>\r\n\r\n<p>2 - La phase d’approche consiste à arriver bien fléchi sur le kicker, la planche bien à plat, les épaules dans l’axe de la board, le regard fixé sur le bout du kicker.</p>\r\n\r\n<p>3 - L’impulsion se fait à 2 pieds au bout du kicker, en lançant la rotation avec les épaules. Ne pas pousser trop fort aux premiers essais au risque d’être déséquilibré. La vitesse à laquelle il faut lancer les épaules pour lancer la rotation dépend de la taille du saut évidement… Le mieux est de commencer par un saut d’environ 5m, sa suffit pour tourner ce tricks.</p>\r\n\r\n<p>4 - Pour que la rotation se fasse à plat, il faut lancer le mouvement avec  les épaules à l’horizontale. Le regard se porte par dessus l’épaule, le menton au niveau de l’épaule. Pour désaxer, c’est la tête qui va chercher à twister le mouvement, et les épaules ne seront plus à l’horizontale.</p>\r\n\r\n<p>5 - Dès que l’on est en l’air, se regrouper et grabber. On vous conseille le Melon Grab pour commencer, c’est le plus simple avec cette rotation.</p>\r\n\r\n<p>6 - Il faut aller chercher la rotation du regard par dessus l’épaule avant. On aperçoit la reception après 270° et a partir de ce moment là c’est tout comme la fin d\'un bon vieux 360 front. Il faut donc fixer des yeux la réception et ne pas la lâcher. Le mouvement est fini avec la tête tandis qu’il continue avec les épaules et le bas du corps restés en retard pour aller s’aligner vers la réception.</p>\r\n\r\n<p>7 - Pour atterrir, il faut ramener le bas du corps dans l’axe de la réception en se regroupant si on a besoin d’accélérer le mouvement. On détend ses jambes pour aller chercher la réception puis amortir sur les deux jambes au contact du sol. Les épaules doivent être dans l’axe de la board ou légèrement en retard pour arrêter la rotation, surtout si on sent que l’on tournait trop vite, ça évite la sur-rotation. Regardez devant vous une fois que vous avez fini d’amortir.</p>', '2019-01-18 15:49:59', '2019-01-29 23:17:19'),
(9, 1, 'Seat Belt', 'Saisie du carre frontside à l\'arrière avec la main avant.', '2019-01-18 15:53:37', '2019-01-29 23:14:51'),
(10, 1, 'Truck Driver', 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture).', '2019-01-18 15:53:46', '2019-01-29 23:13:03'),
(11, 1, 'Tail grab', 'Saisie de la partie arrière de la planche, avec la main arrière.', '2019-01-18 15:53:56', '2019-01-29 23:12:07'),
(12, 1, 'Japan', 'Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.', '2019-01-18 15:54:05', '2019-01-29 23:11:05'),
(15, 2, 'Ollie', '<p>1. La phase d’approche consiste à avoir sa planche la plus à plat possible ou légèrement sur la carre; le regard pointé vers le spot (l’endroit où on veut décoller). Les jambes sont fléchies, prêtes à donner une impulsion.</p>\r\n\r\n<p>2. Pour déclencher le Ollie, il faut tirer sur la jambe avant tout en appuyant sur la jambe arrière pour déformer la planche et aller chercher le pop de son snowboard (le «rebond» de la planche). On peut s\'aider des bras en les dépliants comme un oiseau qui cherche à s\'envoler ;)</p>\r\n\r\n<p>3. Dés que l’on sent qu’on décolle, il faut regrouper les jambes et les bras pour gagner en stabilité, le regard cherche déjà l’endroit où on va aller atterrir tout en essayant de profiter du moment présent…</p>\r\n\r\n<p>4.  Pour atterrir, il faut légèrement détendre les jambes pour aller chercher le sol tout en préparant l’amorti, c’est à dire forcer sur les jambes qui servent d’amortisseur. Bien plier les genoux sans se laisser assoir par la force de gravité.</p>\r\n\r\n<p>Le mieux c’est de commencer à s’entrainer à faire des ollies à plat sur la piste, puis en profitant des petits reliefs de bord de piste. Quand on se sent vraiment  à l’aise, on peut commencer à essayer sur de plus gros sauts (kickers de snowpark par exemple). Ne pas hésiter à être créatif, repérer toute variation de terrain qui peut être un bon spot pour envoyer un ollie, et transformer la montagne en terrain de jeu…</p>', '2019-01-29 22:31:21', '2019-01-29 23:16:00'),
(16, 1, 'Sad', '<p>Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.</p>', '2019-01-29 22:37:37', '2019-01-29 23:15:48'),
(17, 1, 'Stalefish', '<p>Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.</p>', '2019-01-29 22:40:15', '2019-01-29 23:15:40'),
(18, 1, 'Nose grab', '<p>Saisie de la partie avant de la planche, avec la main avant.</p>', '2019-01-29 22:42:35', '2019-01-29 23:15:29');

-- --------------------------------------------------------

--
-- Structure de la table `trick_group`
--

DROP TABLE IF EXISTS `trick_group`;
CREATE TABLE IF NOT EXISTS `trick_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick_group`
--

INSERT INTO `trick_group` (`id`, `title`) VALUES
(1, 'Grab'),
(2, 'Rotation'),
(3, 'Flip');

-- --------------------------------------------------------

--
-- Structure de la table `trick_image`
--

DROP TABLE IF EXISTS `trick_image`;
CREATE TABLE IF NOT EXISTS `trick_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E1204E0B281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick_image`
--

INSERT INTO `trick_image` (`id`, `trick_id`, `url`, `alt`) VALUES
(1, 1, '037093068693d0d6708b7683e221eb9afront_180_1.jpg', NULL),
(2, 1, 'c135860eaf655fc2f2d4d4ace160ef01front_180_2.jpg', NULL),
(3, 1, '6d22fa3a9d7b2c6e5d908de0508f9871front_180_3.jpg', NULL),
(4, 1, '4c54aae6f01d047cb40bf7feb6551821front_180_4.jpg', NULL),
(5, 2, '01fb9219b1ecf091d49d7da5b1d643eeindy_grab2.jpg', NULL),
(6, 2, '1c0acce92b191acac1e1e572ab5409a7indy_grab1.jpg', NULL),
(7, 2, 'e6217c0072a5afe34a24e224d9fbe429indy_grab3.jpg', NULL),
(8, 2, '08e6c8dfe196c622d53580a098c52243indy_grab4.jpg', NULL),
(9, 3, '67302766f6c406ed73fc28777c0b275fbackflip3.jpg', NULL),
(10, 3, 'abefbad8b7fbddf04a148dd09a7e3a5dbackflip2.jpg', NULL),
(11, 3, 'fb97049988e84b8f4b01d05216f4bb3fbackflip1.jpg', NULL),
(12, 3, '0551569450af78dc3b6c8979f4af04e4backflip4.jpg', NULL),
(13, 4, '5af919504d732cca5ec85dec40157250fontside_720_4.jpg', NULL),
(14, 4, '84b3bbbb92bffe60b9b56bec42060c1dfontside_720_3.jpg', NULL),
(15, 4, 'a43496279c06d93abb336223d88541a4fontside_720_2.jpg', NULL),
(16, 4, '8c3a3c2bf909b9a2d74df1af75f460fefontside_720_1.png', NULL),
(17, 5, '31725652cbd4c34b4772d7391b4a6814Mute1.jpg', NULL),
(18, 5, '494c946e3c0ae0d5d0f8508134482b14Mute2.jpg', NULL),
(19, 5, 'a7a7e4d99425ccc5993afbe63b9113a2Mute3.jpg', NULL),
(20, 5, 'd5b543c8c67023780c6c008cb72b56ccMute4.jpg', NULL),
(25, 7, '5ccee9addfe15e04d4ef23cc9e406b77switch_backside_540_4.jpg', NULL),
(26, 7, '1d4e6d2626fe8915702693bcdfcb0388switch_backside_540_1.jpg', NULL),
(27, 7, '66fa97b33377836d914c096db5991d41switch_backside_540_3.jpg', NULL),
(28, 7, 'a210c6fe8dcb82d3a76b54ccfb3878b9switch_backside_540_2.jpg', NULL),
(29, NULL, 'bb2e5b3f628571a08b01ce79a261a93casphalt.jpg', NULL),
(30, NULL, '754a353d70fd91ea135a398ed01c4358beton.jpg', NULL),
(31, NULL, '41622f4264286701f981083f5c8aee5dbeton_clair.jpg', NULL),
(32, NULL, 'a32f6735764523960801c1ed444cf70dbois2.jpg', NULL),
(33, NULL, '87160a392d640d73596969a656dca384tuiles2.jpg', NULL),
(34, NULL, 'a2cad183053d15f33687e3ffd6868e0ftuiles.jpg', NULL),
(35, NULL, 'bf0852ac86bb148c86b817271439c0e2toiture_verte.jpg', NULL),
(36, NULL, '61c687955f7220c151b6d9c8dd126f38pierre_ocre.jpg', NULL),
(41, 15, '6a07832f0aafe848801d584e4d088330ollie1.jpg', NULL),
(42, 15, '6bf3bbdbc48ac61f8d32fca486148afeollie2.jpg', NULL),
(43, 16, '1eb56562576b13ec4ee1a97267ba2856sad1.jpg', NULL),
(44, 17, '80adc072c39996089138374364194b08stalefish1.jpg', NULL),
(45, 17, '8531e9ecfc953252ca28dcdfde6b9e85stalefish2.jpg', NULL),
(46, 18, '80430a802dadce10d158fb70e0823395nosegrab1.jpg', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avatar_image_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `registered_at` datetime NOT NULL,
  `confirmation_token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D6495C18B4B1` (`avatar_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `avatar_image_id`, `email`, `password`, `username`, `is_active`, `registered_at`, `confirmation_token`, `password_token`, `roles`) VALUES
(1, 1, 'coco2053@hotmail.com', '$2y$13$cPJZJ57syyASzZVfgGp88uXi2u88ojaUGGYF6kVHqKd.q3ZRdGmSK', 'Bastien', 1, '2019-01-18 09:57:04', NULL, 'a688554925c51b697ebe20cc6174b2c73bc25dd97ccbfa1d3d529ced036ef5bb', '[\"ROLE_USER\"]'),
(2, NULL, 'bastienvacherand@gmail.com', '$2y$13$vXsNnhQp3zZCYMjS763ACeOJGUwmq/24GZ3cb2pCbocXgYuMVY7Nq', 'Fantôme', 1, '2019-01-23 23:15:29', NULL, NULL, '[\"ROLE_USER\"]'),
(3, NULL, 'coco2053@gmail.com', '$2y$13$LyNuBdUyAkuaWBHqjyzpDO5vV8h1AxNGrrG4nLvK4akVf3EcyEFsW', 'Max', 1, '2019-01-30 10:20:51', NULL, NULL, '[\"ROLE_USER\"]');

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CC7DA2CB281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `trick_id`, `url`) VALUES
(1, 1, '<iframe width=\"800\" height=\"450\" src=\"https://www.youtube.com/embed/JMS2PGAFMcE\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(2, 2, '<iframe width=\"800\" height=\"450\" src=\"https://www.youtube.com/embed/iKkhKekZNQ8\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(3, 3, '<iframe width=\"800\" height=\"450\" src=\"https://www.youtube.com/embed/SlhGVnFPTDE\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(4, 4, '<iframe width=\"800\" height=\"450\" src=\"https://www.youtube.com/embed/1vtZXU15e38\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(5, 5, '<iframe width=\"800\" height=\"450\" src=\"https://www.youtube.com/embed/JGaZ_qctLvA\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(7, 7, '<iframe width=\"800\" height=\"450\" src=\"https://www.youtube.com/embed/wDoHk1Y6c-w\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(11, 15, '<iframe width=\"800\" height=\"450\" src=\"https://www.youtube.com/embed/kOyCsY4rBH0\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9474526CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91E9B875DF8` FOREIGN KEY (`trick_group_id`) REFERENCES `trick_group` (`id`);

--
-- Contraintes pour la table `trick_image`
--
ALTER TABLE `trick_image`
  ADD CONSTRAINT `FK_E1204E0B281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6495C18B4B1` FOREIGN KEY (`avatar_image_id`) REFERENCES `avatar_image` (`id`);

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
