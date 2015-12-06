-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.25 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4157
-- Date/time:                    2013-03-12 23:33:51
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table stand4you.addr_region
DROP TABLE IF EXISTS `addr_region`;
CREATE TABLE IF NOT EXISTS `addr_region` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `code` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.addr_region: ~83 rows (approximately)
DELETE FROM `addr_region`;
/*!40000 ALTER TABLE `addr_region` DISABLE KEYS */;
INSERT INTO `addr_region` (`id`, `name`, `code`) VALUES
	(2, 'Приморский край', 25),
	(3, 'Владимирская область', 33),
	(4, 'Республика Адыгея (Адыгея)', 1),
	(5, 'Архангельская область', 29),
	(6, 'Астраханская область', 30),
	(7, 'Республика Башкортостан', 2),
	(8, 'Белгородская область', 31),
	(9, 'Брянская область', 32),
	(10, 'Чеченская Республика', 20),
	(11, 'Чувашская Республика — Чувашия', 21),
	(12, 'Республика Дагестан', 5),
	(13, 'Нижегородская область', 52),
	(14, 'Республика Ингушетия', 6),
	(15, 'Ивановская область', 37),
	(16, 'Кабардино-Балкарская Республика', 7),
	(17, 'Калининградская область', 39),
	(18, 'Республика Калмыкия', 8),
	(19, 'Калужская область', 40),
	(20, 'Карачаево-Черкесская Республика', 9),
	(21, 'Республика Карелия', 10),
	(22, 'Кировская область', 43),
	(23, 'Республика Коми', 11),
	(24, 'Костромская область', 44),
	(25, 'Краснодарский край', 23),
	(26, 'Курская область', 46),
	(27, 'Санкт-Петербург', 78),
	(28, 'Ленинградская область', 47),
	(29, 'Липецкая область', 48),
	(30, 'Республика Марий Эл', 12),
	(31, 'Республика Мордовия', 13),
	(32, 'Московская область', 50),
	(33, 'Москва', 77),
	(34, 'Мурманская область', 51),
	(35, 'Ненецкий автономный округ', 83),
	(36, 'Республика Северная Осетия — Алания', 15),
	(37, 'Новгородская область', 53),
	(38, 'Оренбургская область', 56),
	(39, 'Орловская область', 57),
	(40, 'Пензенская область', 58),
	(41, 'Пермский край', 59),
	(42, 'Псковская область', 60),
	(43, 'Ростовская область', 61),
	(44, 'Рязанская область', 62),
	(45, 'Самарская область', 63),
	(46, 'Саратовская область', 64),
	(47, 'Смоленская область', 67),
	(48, 'Ставропольский край', 26),
	(49, 'Тамбовская область', 68),
	(50, 'Республика Татарстан (Татарстан)', 16),
	(51, 'Тульская область', 71),
	(52, 'Тверская область', 69),
	(53, 'Удмуртская Республика', 18),
	(54, 'Ульяновская область', 73),
	(55, 'Волгоградская область', 34),
	(56, 'Вологодская область', 35),
	(57, 'Воронежская область', 36),
	(58, 'Ярославская область', 76),
	(59, 'Чукотский автономный округ', 87),
	(60, 'Камчатский край', 41),
	(61, 'Магаданская область', 49),
	(62, 'Сахалинская область', 65),
	(63, 'Республика Бурятия', 3),
	(64, 'Амурская область', 28),
	(65, 'Еврейская автономная область', 79),
	(66, 'Забайкальский край', 75),
	(67, 'Иркутская область', 38),
	(68, 'Хабаровский край', 27),
	(69, 'Республика Саха (Якутия)', 14),
	(71, 'Республика Алтай', 4),
	(72, 'Алтайский край', 22),
	(73, 'Челябинская область', 74),
	(74, 'Кемеровская область', 42),
	(75, 'Республика Хакасия', 19),
	(76, 'Ханты-Мансийский автономный округ — Югра', 86),
	(77, 'Красноярский край', 24),
	(78, 'Курганская область', 45),
	(79, 'Новосибирская область', 54),
	(80, 'Омская область', 55),
	(81, 'Свердловская область', 66),
	(82, 'Томская область', 70),
	(83, 'Республика Тыва', 17),
	(84, 'Тюменская область', 72),
	(85, 'Ямало-Ненецкий автономный округ', 89);
/*!40000 ALTER TABLE `addr_region` ENABLE KEYS */;


-- Dumping structure for table stand4you.art_block_type
DROP TABLE IF EXISTS `art_block_type`;
CREATE TABLE IF NOT EXISTS `art_block_type` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `text` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.art_block_type: ~3 rows (approximately)
DELETE FROM `art_block_type`;
/*!40000 ALTER TABLE `art_block_type` DISABLE KEYS */;
INSERT INTO `art_block_type` (`id`, `name`, `text`) VALUES
	(0, 'image', 'Изображение'),
	(1, 'text', 'Текст'),
	(2, 'html', 'HTML - код');
/*!40000 ALTER TABLE `art_block_type` ENABLE KEYS */;


-- Dumping structure for table stand4you.img_account
DROP TABLE IF EXISTS `img_account`;
CREATE TABLE IF NOT EXISTS `img_account` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(512) NOT NULL,
  `hashpass` varchar(256) NOT NULL,
  `show_email` tinyint(4) DEFAULT '0',
  `check_code` varchar(64) NOT NULL,
  `active` tinyint(4) DEFAULT '0',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cookie_code` varchar(64) DEFAULT NULL,
  `img_name` varchar(512) NOT NULL,
  `img_slog` varchar(2048) DEFAULT NULL,
  `img_phone` varchar(128) DEFAULT NULL,
  `show_phone` tinyint(4) DEFAULT '0',
  `img_skype` varchar(512) DEFAULT NULL,
  `show_skype` tinyint(4) DEFAULT '0',
  `img_icq` varchar(512) DEFAULT NULL,
  `show_icq` tinyint(4) DEFAULT '0',
  `img_address_id` int(10) DEFAULT NULL,
  `show_address` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.img_account: ~0 rows (approximately)
DELETE FROM `img_account`;
/*!40000 ALTER TABLE `img_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `img_account` ENABLE KEYS */;


-- Dumping structure for table stand4you.img_address
DROP TABLE IF EXISTS `img_address`;
CREATE TABLE IF NOT EXISTS `img_address` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `region_id` int(10) DEFAULT NULL,
  `sity` varchar(128) DEFAULT NULL,
  `street` varchar(1024) DEFAULT NULL,
  `house` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.img_address: ~0 rows (approximately)
DELETE FROM `img_address`;
/*!40000 ALTER TABLE `img_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `img_address` ENABLE KEYS */;


-- Dumping structure for table stand4you.img_album
DROP TABLE IF EXISTS `img_album`;
CREATE TABLE IF NOT EXISTS `img_album` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `name` varchar(512) NOT NULL,
  `description` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.img_album: ~2 rows (approximately)
DELETE FROM `img_album`;
/*!40000 ALTER TABLE `img_album` DISABLE KEYS */;
INSERT INTO `img_album` (`id`, `account_id`, `name`, `description`) VALUES
	(15, 0, 'Для статей', ''),
	(16, 0, 'Для статических страниц', '');
/*!40000 ALTER TABLE `img_album` ENABLE KEYS */;


-- Dumping structure for table stand4you.img_blog_art
DROP TABLE IF EXISTS `img_blog_art`;
CREATE TABLE IF NOT EXISTS `img_blog_art` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `img_account_id` int(10) NOT NULL,
  `img_blog_cat_id` int(10) NOT NULL,
  `name` varchar(512) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `main_pict_id` int(10) DEFAULT NULL,
  `preview` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.img_blog_art: ~0 rows (approximately)
DELETE FROM `img_blog_art`;
/*!40000 ALTER TABLE `img_blog_art` DISABLE KEYS */;
/*!40000 ALTER TABLE `img_blog_art` ENABLE KEYS */;


-- Dumping structure for table stand4you.img_blog_art_block
DROP TABLE IF EXISTS `img_blog_art_block`;
CREATE TABLE IF NOT EXISTS `img_blog_art_block` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `img_blog_art_id` int(10) NOT NULL,
  `block_type` tinyint(4) NOT NULL DEFAULT '0',
  `text_content` text,
  `img_picture_id` int(10) DEFAULT NULL,
  `pict_desc` text,
  `order_in_art` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.img_blog_art_block: ~0 rows (approximately)
DELETE FROM `img_blog_art_block`;
/*!40000 ALTER TABLE `img_blog_art_block` DISABLE KEYS */;
/*!40000 ALTER TABLE `img_blog_art_block` ENABLE KEYS */;


-- Dumping structure for table stand4you.img_blog_cat
DROP TABLE IF EXISTS `img_blog_cat`;
CREATE TABLE IF NOT EXISTS `img_blog_cat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `name` varchar(64) NOT NULL,
  `pid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.img_blog_cat: ~0 rows (approximately)
DELETE FROM `img_blog_cat`;
/*!40000 ALTER TABLE `img_blog_cat` DISABLE KEYS */;
/*!40000 ALTER TABLE `img_blog_cat` ENABLE KEYS */;


-- Dumping structure for table stand4you.img_currency
DROP TABLE IF EXISTS `img_currency`;
CREATE TABLE IF NOT EXISTS `img_currency` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `weight` int(10) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.img_currency: ~6 rows (approximately)
DELETE FROM `img_currency`;
/*!40000 ALTER TABLE `img_currency` DISABLE KEYS */;
INSERT INTO `img_currency` (`id`, `name`, `weight`) VALUES
	(1, 'руб.', 1),
	(2, 'EUR', 40),
	(3, 'USD', 30),
	(4, 'руб/час', 1),
	(5, 'EUR/час', 40),
	(6, 'USD/час', 30);
/*!40000 ALTER TABLE `img_currency` ENABLE KEYS */;


-- Dumping structure for table stand4you.img_gds
DROP TABLE IF EXISTS `img_gds`;
CREATE TABLE IF NOT EXISTS `img_gds` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `UUID` varchar(64) NOT NULL,
  `name` varchar(512) NOT NULL,
  `price` int(10) NOT NULL,
  `currency_id` int(10) NOT NULL,
  `main_pict_id` int(10) DEFAULT NULL,
  `first_pict_id` int(10) DEFAULT NULL,
  `second_pict_id` int(10) DEFAULT NULL,
  `third_pict_id` int(10) DEFAULT NULL,
  `img_account_id` int(10) NOT NULL,
  `img_gds_cat_id` int(10) DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `in_stock` tinyint(4) NOT NULL DEFAULT '1',
  `is_new` tinyint(4) NOT NULL DEFAULT '0',
  `is_recommended` tinyint(4) NOT NULL DEFAULT '0',
  `descr` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.img_gds: ~0 rows (approximately)
DELETE FROM `img_gds`;
/*!40000 ALTER TABLE `img_gds` DISABLE KEYS */;
/*!40000 ALTER TABLE `img_gds` ENABLE KEYS */;


-- Dumping structure for table stand4you.img_gds_cat
DROP TABLE IF EXISTS `img_gds_cat`;
CREATE TABLE IF NOT EXISTS `img_gds_cat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `name` varchar(64) NOT NULL,
  `pid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.img_gds_cat: ~0 rows (approximately)
DELETE FROM `img_gds_cat`;
/*!40000 ALTER TABLE `img_gds_cat` DISABLE KEYS */;
/*!40000 ALTER TABLE `img_gds_cat` ENABLE KEYS */;


-- Dumping structure for table stand4you.img_gds_prop
DROP TABLE IF EXISTS `img_gds_prop`;
CREATE TABLE IF NOT EXISTS `img_gds_prop` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `img_gds_id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `value` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.img_gds_prop: ~0 rows (approximately)
DELETE FROM `img_gds_prop`;
/*!40000 ALTER TABLE `img_gds_prop` DISABLE KEYS */;
/*!40000 ALTER TABLE `img_gds_prop` ENABLE KEYS */;


-- Dumping structure for table stand4you.img_picture
DROP TABLE IF EXISTS `img_picture`;
CREATE TABLE IF NOT EXISTS `img_picture` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) DEFAULT NULL,
  `album_id` int(10) DEFAULT NULL,
  `name` varchar(512) NOT NULL,
  `path` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.img_picture: ~23 rows (approximately)
DELETE FROM `img_picture`;
/*!40000 ALTER TABLE `img_picture` DISABLE KEYS */;
INSERT INTO `img_picture` (`id`, `account_id`, `album_id`, `name`, `path`) VALUES
	(53, 0, 0, 'MAC-wallpaper4.jpg', '/images/acc0/1d6b2c88-1157-457e-a030-c080276e6824'),
	(54, 0, 0, 'MAC-wallpaper27.jpg', '/images/acc0/a6d65fbf-f09d-4388-a1f8-d4d13dcf6f45'),
	(55, 0, 0, 'mix wall (87).jpg', '/images/acc0/75a42334-3907-4711-bc74-f4afc11a7b0a'),
	(56, 0, 0, 'MAC-wallpaper4.jpg', '/images/acc0/fcf56137-5026-4e81-a4e5-0584681d2a46'),
	(57, 0, 0, 'MAC-wallpaper27.jpg', '/images/acc0/17e500d9-4a3c-4521-8b41-055724b28fa9'),
	(58, 0, 0, 'mix wall (87).jpg', '/images/acc0/0d240643-bd41-48aa-b98f-6446517b3111'),
	(65, 0, 16, '00001.jpg', '/images/acc0/58aa55bc-32d2-4641-8dbb-9f748a5381ee'),
	(66, 0, 16, '00002.jpg', '/images/acc0/65098585-ab1a-4eab-97d1-2b8c2229816c'),
	(67, 0, 16, '00003.jpg', '/images/acc0/da878ed9-9a01-48d0-a456-c2812d1a3cb3'),
	(68, 0, 16, '00004.jpg', '/images/acc0/8133a230-553b-4084-ac20-966e6a094d2f'),
	(69, 0, 16, '00007.jpg', '/images/acc0/e6846c08-3228-4451-94f3-7beed203aaef'),
	(70, 0, 16, '00008.jpg', '/images/acc0/02231671-42fd-4147-bbcd-eb4d6e90d9b0'),
	(71, 0, 16, '00009.jpg', '/images/acc0/98b9ee3d-d91b-445d-823d-d09c548711f3'),
	(72, 0, 15, '00291.jpg', '/images/acc0/5fff7fc0-3889-4847-beb6-062aeed5d25b'),
	(73, 0, 15, '00292.jpg', '/images/acc0/889e501a-5db7-4b2d-817b-450a0dd9843e'),
	(74, 0, 15, '00293.jpg', '/images/acc0/604805f2-3957-4b1e-a5bf-9315eaaced6a'),
	(75, 0, 15, '00294.jpg', '/images/acc0/b6bddef3-5d62-46a8-914c-96aebc6c7668'),
	(76, 0, 15, '00295.jpg', '/images/acc0/7753d8c9-3e58-4ef8-8165-3df20f6eeac4'),
	(77, 0, 15, '00296.jpg', '/images/acc0/2836b32e-3980-47c9-82a4-15ec6bf17623'),
	(78, 0, 15, '00297.jpg', '/images/acc0/7f0ae40b-81f1-4e00-b02e-241795c316e3'),
	(79, 0, 15, '00298.jpg', '/images/acc0/3219e0e3-7968-46d5-9754-0b9c57c2efe9'),
	(80, 0, 15, '00299.jpg', '/images/acc0/274438e7-85a4-4493-8a97-cd4368a2dd72'),
	(81, 0, 15, '00300.jpg', '/images/acc0/0eb76152-f5a8-4ccd-8d28-14ee99dfbc93');
/*!40000 ALTER TABLE `img_picture` ENABLE KEYS */;


-- Dumping structure for table stand4you.order
DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `u_email` varchar(512) NOT NULL,
  `u_name` varchar(512) DEFAULT NULL,
  `u_phone` varchar(512) DEFAULT NULL,
  `u_comment` text,
  `c_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.order: ~0 rows (approximately)
DELETE FROM `order`;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;


-- Dumping structure for table stand4you.order_account_sended
DROP TABLE IF EXISTS `order_account_sended`;
CREATE TABLE IF NOT EXISTS `order_account_sended` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL,
  `img_account_id` int(10) NOT NULL,
  `sended` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.order_account_sended: ~0 rows (approximately)
DELETE FROM `order_account_sended`;
/*!40000 ALTER TABLE `order_account_sended` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_account_sended` ENABLE KEYS */;


-- Dumping structure for table stand4you.order_gds
DROP TABLE IF EXISTS `order_gds`;
CREATE TABLE IF NOT EXISTS `order_gds` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL,
  `img_gds_id` int(10) NOT NULL,
  `count_gds` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.order_gds: ~0 rows (approximately)
DELETE FROM `order_gds`;
/*!40000 ALTER TABLE `order_gds` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_gds` ENABLE KEYS */;


-- Dumping structure for table stand4you.sys_admins
DROP TABLE IF EXISTS `sys_admins`;
CREATE TABLE IF NOT EXISTS `sys_admins` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `lastuuid` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.sys_admins: ~1 rows (approximately)
DELETE FROM `sys_admins`;
/*!40000 ALTER TABLE `sys_admins` DISABLE KEYS */;
INSERT INTO `sys_admins` (`id`, `login`, `password`, `lastuuid`) VALUES
	(1, 'admin', 'password', 'dbeb318b-7c90-46ba-bfb6-3af110d16af9');
/*!40000 ALTER TABLE `sys_admins` ENABLE KEYS */;


-- Dumping structure for table stand4you.sys_news_art
DROP TABLE IF EXISTS `sys_news_art`;
CREATE TABLE IF NOT EXISTS `sys_news_art` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sys_news_cat_id` int(10) DEFAULT NULL,
  `title` varchar(256) NOT NULL,
  `preview` text NOT NULL,
  `c_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `main_pict_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.sys_news_art: ~1 rows (approximately)
DELETE FROM `sys_news_art`;
/*!40000 ALTER TABLE `sys_news_art` DISABLE KEYS */;
INSERT INTO `sys_news_art` (`id`, `sys_news_cat_id`, `title`, `preview`, `c_date`, `main_pict_id`) VALUES
	(16, 6, 'Мы открылись', 'Теперь каждый может создать мини интернет магазинчик под названием Торговый стенд', '2013-03-04 20:10:29', 76);
/*!40000 ALTER TABLE `sys_news_art` ENABLE KEYS */;


-- Dumping structure for table stand4you.sys_news_art_block
DROP TABLE IF EXISTS `sys_news_art_block`;
CREATE TABLE IF NOT EXISTS `sys_news_art_block` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sys_news_art_id` int(10) NOT NULL,
  `image_id` int(10) DEFAULT NULL,
  `image_title` tinytext,
  `text_content` text,
  `block_type` tinyint(4) NOT NULL DEFAULT '0',
  `order_in_art` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.sys_news_art_block: ~0 rows (approximately)
DELETE FROM `sys_news_art_block`;
/*!40000 ALTER TABLE `sys_news_art_block` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_news_art_block` ENABLE KEYS */;


-- Dumping structure for table stand4you.sys_news_cat
DROP TABLE IF EXISTS `sys_news_cat`;
CREATE TABLE IF NOT EXISTS `sys_news_cat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `pid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.sys_news_cat: ~2 rows (approximately)
DELETE FROM `sys_news_cat`;
/*!40000 ALTER TABLE `sys_news_cat` DISABLE KEYS */;
INSERT INTO `sys_news_cat` (`id`, `name`, `pid`) VALUES
	(6, 'События', NULL),
	(7, 'Описания', NULL);
/*!40000 ALTER TABLE `sys_news_cat` ENABLE KEYS */;


-- Dumping structure for table stand4you.sys_properties
DROP TABLE IF EXISTS `sys_properties`;
CREATE TABLE IF NOT EXISTS `sys_properties` (
  `name` varchar(128) NOT NULL,
  `value` varchar(1024) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.sys_properties: ~2 rows (approximately)
DELETE FROM `sys_properties`;
/*!40000 ALTER TABLE `sys_properties` DISABLE KEYS */;
INSERT INTO `sys_properties` (`name`, `value`) VALUES
	('sys_name', 'STAND4YOU.RU'),
	('sys_slog', 'целый мир торговых стендов');
/*!40000 ALTER TABLE `sys_properties` ENABLE KEYS */;


-- Dumping structure for table stand4you.sys_static_pages
DROP TABLE IF EXISTS `sys_static_pages`;
CREATE TABLE IF NOT EXISTS `sys_static_pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `title` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.sys_static_pages: ~2 rows (approximately)
DELETE FROM `sys_static_pages`;
/*!40000 ALTER TABLE `sys_static_pages` DISABLE KEYS */;
INSERT INTO `sys_static_pages` (`id`, `name`, `title`) VALUES
	(1, 'presentation', 'Презентация проекта STAND4YOU.RU'),
	(2, 'faq', 'Часто задаваемые вопросы');
/*!40000 ALTER TABLE `sys_static_pages` ENABLE KEYS */;


-- Dumping structure for table stand4you.sys_static_page_blocks
DROP TABLE IF EXISTS `sys_static_page_blocks`;
CREATE TABLE IF NOT EXISTS `sys_static_page_blocks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sys_static_page_id` int(10) NOT NULL,
  `block_type_id` int(10) NOT NULL,
  `image_id` int(10) DEFAULT NULL,
  `image_title` tinytext,
  `text_content` text,
  `order_in_page` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Dumping data for table stand4you.sys_static_page_blocks: ~4 rows (approximately)
DELETE FROM `sys_static_page_blocks`;
/*!40000 ALTER TABLE `sys_static_page_blocks` DISABLE KEYS */;
INSERT INTO `sys_static_page_blocks` (`id`, `sys_static_page_id`, `block_type_id`, `image_id`, `image_title`, `text_content`, `order_in_page`) VALUES
	(17, 1, 0, 73, 'Отличные обои для смартфонов и коммуникаторов', '', 1),
	(18, 1, 1, 0, '', 'В настоящее время все большую популярность приобретают WYSIWYG редакторы. Популярны они в силу своей простоты использования для обычных пользователей. Но по большей части, большинство этих редакторов волне хорошо справляется с созданием HTML содержимого и лишь малая часть из них умеет создавать содержимое c BBcode разметкой. А если и умеют, то настроить эти редакторы под свои нужды задача весьма и весьма тяжелая.', 0),
	(19, 1, 1, 0, '', 'В настоящее время есть огромное количество форумов и сайтов, которые активно используют BBcode разметку, но не имеют удобного для пользователей WYSIWYG редактора. Именно для этих ресурсов и создан WysiBB.\r\n\r\n Я активно занимаюсь разработкой этого проекта и он уже успешно работает, так сказать проходит тестирование, на сайте Uagadget. Так же работу редактора можно посмотреть в разделе «Демо» на оф. сайте.\r\n\r\n Со своей стороны я надеюсь на объективную критику и идеи в развитии проекта от всех небезразличных людей, так как по моему мнению, WysiBB может быть полезен большому количеству пользователей и сайтов использующих BBcode. В моих планах не останавливаться на том что есть, а развивать WysiBB и сделать его простым и удобным.', 2),
	(20, 2, 2, 0, '', 'Было вечером дело, было нечего делать. <br/>\r\nИ чтобы развеять некую скуку, навалившуюся сегодня на меня, решил запилить парочку веселых картинок. Всем позитиву.', 0);
/*!40000 ALTER TABLE `sys_static_page_blocks` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
