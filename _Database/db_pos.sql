-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.31 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.1.0.6205
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_pos
DROP DATABASE IF EXISTS `db_pos`;
CREATE DATABASE IF NOT EXISTS `db_pos` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_pos`;

-- Dumping structure for table db_pos.attendance
DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `ID_ATTN` int(11) NOT NULL,
  `CLOCK_IN_TIME` datetime DEFAULT NULL,
  `CLOCK_OUT_TIME` datetime DEFAULT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `SHIFT_ID` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.attendance: 0 rows
DELETE FROM `attendance`;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;

-- Dumping structure for table db_pos.drawer_balance
DROP TABLE IF EXISTS `drawer_balance`;
CREATE TABLE IF NOT EXISTS `drawer_balance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CREATE_DATE` datetime DEFAULT NULL,
  `ACCOUNT_NAME` varchar(50) DEFAULT NULL,
  `CASH_BALANCE` double DEFAULT NULL,
  `TERMINAL` varchar(25) DEFAULT NULL,
  `ID_TRANSACTION` int(11) DEFAULT NULL,
  `NOTE` varchar(255) DEFAULT NULL,
  `UPDATE_BY` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.drawer_balance: 0 rows
DELETE FROM `drawer_balance`;
/*!40000 ALTER TABLE `drawer_balance` DISABLE KEYS */;
/*!40000 ALTER TABLE `drawer_balance` ENABLE KEYS */;

-- Dumping structure for table db_pos.menu_category
DROP TABLE IF EXISTS `menu_category`;
CREATE TABLE IF NOT EXISTS `menu_category` (
  `ID_CATEGORY` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(120) NOT NULL,
  `TRANSLATED_NAME` varchar(120) DEFAULT NULL,
  `VISIBLE` int(1) DEFAULT NULL,
  `SORT_ORDER` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CATEGORY`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.menu_category: 8 rows
DELETE FROM `menu_category`;
/*!40000 ALTER TABLE `menu_category` DISABLE KEYS */;
INSERT INTO `menu_category` (`ID_CATEGORY`, `CATEGORY_NAME`, `TRANSLATED_NAME`, `VISIBLE`, `SORT_ORDER`) VALUES
	(1, 'Ala Carte', NULL, 1, 9999),
	(2, 'Menu Paket', NULL, 1, 9999),
	(3, 'Catering', NULL, 1, 9999),
	(4, 'Goceng', NULL, 1, 9999),
	(5, 'Add On', NULL, 1, 9999),
	(6, 'Minuman', NULL, 1, 9999),
	(7, 'Snack', NULL, 1, 9999),
	(8, 'Coffe', NULL, 1, 9999);
/*!40000 ALTER TABLE `menu_category` ENABLE KEYS */;

-- Dumping structure for table db_pos.menu_item
DROP TABLE IF EXISTS `menu_item`;
CREATE TABLE IF NOT EXISTS `menu_item` (
  `ID_MENU_ITEM` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_NAME` varchar(120) NOT NULL,
  `TRANSLATED_NAME` varchar(120) DEFAULT NULL,
  `BUY_PRICE` double NOT NULL,
  `PRICE` double NOT NULL,
  `DISCOUNT_RATE` double DEFAULT NULL,
  `VISIBLE` bit(1) DEFAULT NULL,
  `SORT_ORDER` int(11) DEFAULT NULL,
  `IMAGE` text,
  `SHOW_IMAGE_ONLY` int(1) DEFAULT NULL,
  `ID_CATEGORY` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_MENU_ITEM`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.menu_item: 101 rows
DELETE FROM `menu_item`;
/*!40000 ALTER TABLE `menu_item` DISABLE KEYS */;
INSERT INTO `menu_item` (`ID_MENU_ITEM`, `MENU_NAME`, `TRANSLATED_NAME`, `BUY_PRICE`, `PRICE`, `DISCOUNT_RATE`, `VISIBLE`, `SORT_ORDER`, `IMAGE`, `SHOW_IMAGE_ONLY`, `ID_CATEGORY`) VALUES
	(3, 'Super Hot Deal', NULL, 0, 10000, 0, b'1', 9999, NULL, 0, 2),
	(6, 'Odaba Super 9', NULL, 0, 85000, 0, b'1', 9999, NULL, 0, 2),
	(7, 'Super Wings', NULL, 0, 51000, 0, b'1', 9999, NULL, 0, 2),
	(8, 'Super Big Deal', NULL, 0, 14000, 0, b'1', 9999, NULL, 0, 2),
	(9, 'Ayam Dada', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 1),
	(10, 'Ayam Paha Atas', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 1),
	(11, 'Ayam Paha Bawah', NULL, 0, 8000, 0, b'1', 9999, NULL, 0, 1),
	(12, 'Ayam Sayap', NULL, 0, 8000, 0, b'1', 9999, NULL, 0, 1),
	(13, 'Nasi', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 1),
	(14, 'Float', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 4),
	(15, 'Mocca Float', NULL, 0, 8000, 0, b'1', 9999, NULL, 0, 6),
	(16, 'Air Mineral', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 6),
	(17, 'Teh Botol', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 6),
	(18, 'Kentang', NULL, 0, 14000, 0, b'1', 9999, NULL, 0, 7),
	(19, 'Spaghetti', NULL, 0, 10000, 0, b'1', 9999, NULL, 0, 7),
	(21, 'Soup', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 4),
	(23, 'Kopi', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 8),
	(24, 'Teh', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 6),
	(25, 'Soft Drink', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 6),
	(26, 'Ice Cream Cone', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 4),
	(27, 'Ice Cream Cup', NULL, 0, 7000, 0, b'1', 9999, NULL, 0, 1),
	(28, 'Burger', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 1),
	(29, 'Saos Sambal', NULL, 0, 1000, 0, b'1', 9999, NULL, 0, 1),
	(33, 'Ice Djoger', NULL, 0, 7000, 0, b'1', 9999, NULL, 0, 1),
	(34, 'Pudding', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 4),
	(36, 'Super Catering 01', NULL, 0, 15000, 0, b'1', 9999, NULL, 0, 3),
	(37, 'Super Catering 02', NULL, 0, 13000, 0, b'1', 9999, NULL, 0, 3),
	(38, 'Super Double Deal', NULL, 0, 23000, 0, b'1', 9999, NULL, 0, 2),
	(39, 'Odaba Super1', NULL, 0, 19000, 0, b'1', 9999, NULL, 0, 2),
	(40, 'Odaba Super2', NULL, 0, 14000, 0, b'1', 9999, NULL, 0, 2),
	(41, 'Odaba Super3', NULL, 0, 27000, 0, b'1', 9999, NULL, 0, 2),
	(42, 'Combo Burger', NULL, 0, 26000, 0, b'1', 9999, NULL, 0, 2),
	(43, 'Combo Duo', NULL, 0, 47000, 0, b'1', 9999, NULL, 0, 2),
	(44, 'Combo Berlime', NULL, 0, 100000, 0, b'1', 9999, NULL, 0, 2),
	(45, 'Super Trio', NULL, 0, 31000, 0, b'1', 9999, NULL, 0, 2),
	(46, 'Chicken Katsu', NULL, 0, 20000, 0, b'1', 9999, NULL, 0, 7),
	(47, 'Odaba Bento', NULL, 0, 10000, 0, b'1', 9999, NULL, 0, 7),
	(48, 'Chicken Fillet', NULL, 0, 15000, 0, b'1', 9999, NULL, 0, 7),
	(49, 'Spagetti Deluxe', NULL, 0, 13000, 0, b'1', 9999, NULL, 0, 7),
	(50, 'Lemon Tea', NULL, 0, 7000, 0, b'1', 9999, NULL, 0, 6),
	(51, 'Es Djoger', NULL, 0, 7000, 0, b'1', 9999, NULL, 0, 6),
	(52, 'Cup Kids', NULL, 0, 10000, 0, b'1', 9999, NULL, 0, 6),
	(53, 'Sambal Belacan', NULL, 0, 4000, 0, b'1', 9999, NULL, 0, 1),
	(56, 'Chicken Strip', NULL, 0, 10000, 0, b'1', 9999, NULL, 0, 1),
	(57, 'Hash Brown', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 4),
	(60, 'Burger Goceng', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 4),
	(61, 'Chekerzz', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 4),
	(62, 'Sosis', NULL, 0, 10000, 0, b'1', 9999, NULL, 0, 7),
	(63, 'Es Soda Susu', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 6),
	(64, 'Huzzelnut Milk', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 6),
	(66, 'Mint Milk', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 6),
	(67, 'Caramel Milk', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 6),
	(68, 'Puding Odaba', NULL, 0, 8000, 0, b'1', 9999, NULL, 0, 7),
	(69, 'Milkshake', NULL, 0, 15000, 0, b'1', 9999, NULL, 0, 6),
	(70, 'Nasi Cah', NULL, 0, 10000, 0, b'1', 9999, NULL, 0, 7),
	(71, 'Topping Telur', NULL, 0, 3000, 0, b'1', 9999, NULL, 0, 5),
	(72, 'Topping Sambal', NULL, 0, 3000, 0, b'1', 9999, NULL, 0, 5),
	(73, 'Topping Krispi', NULL, 0, 2000, 0, b'1', 9999, NULL, 0, 5),
	(74, 'Indomie Goreng', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 7),
	(75, 'Indomie Rebus', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 7),
	(76, 'Mie Ayam Odaba', NULL, 0, 13000, 0, b'1', 9999, NULL, 0, 1),
	(77, 'Lotek', NULL, 0, 8000, 0, b'1', 9999, NULL, 0, 1),
	(78, 'Saus Pedas', NULL, 0, 4000, 0, b'1', 9999, NULL, 0, 5),
	(79, 'Bento Saus Pedas', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 7),
	(80, 'Es Kosong', NULL, 0, 1000, 0, b'1', 9999, NULL, 0, 6),
	(81, 'Burger crash', NULL, 0, 17000, 0, b'1', 9999, NULL, 0, 1),
	(83, 'Mie goreng jeletot', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 7),
	(84, 'Roti sosis', NULL, 0, 15000, 0, b'1', 9999, NULL, 0, 7),
	(85, 'Steak odaba', NULL, 0, 20000, 0, b'1', 9999, NULL, 0, 7),
	(86, 'Sosis jumbo', NULL, 0, 20000, 0, b'1', 9999, NULL, 0, 7),
	(87, 'Brownies lumer', NULL, 0, 8000, 0, b'1', 9999, NULL, 0, 7),
	(88, 'Brownies Escream', NULL, 0, 10000, 0, b'1', 9999, NULL, 0, 7),
	(89, 'Steak geprek', NULL, 0, 20000, 0, b'1', 9999, NULL, 0, 7),
	(90, 'Chekerzz kece', NULL, 0, 7000, 0, b'1', 9999, NULL, 0, 7),
	(91, 'Fillet kece', NULL, 0, 10000, 0, b'1', 9999, NULL, 0, 7),
	(92, 'Kece hemat', NULL, 0, 11000, 0, b'1', 9999, NULL, 0, 7),
	(93, 'Geprek Odaba1', NULL, 0, 20000, 0, b'1', 9999, NULL, 0, 2),
	(94, 'Geprek Odaba2', NULL, 0, 15000, 0, b'1', 9999, NULL, 0, 2),
	(95, 'Es teh large', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 6),
	(96, 'Milo', NULL, 0, 7000, 0, b'1', 9999, NULL, 0, 6),
	(97, 'Fruite tea', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 6),
	(98, 'ULtra milk 250', NULL, 0, 7000, 0, b'1', 9999, NULL, 0, 6),
	(99, 'Ultra mini', NULL, 0, 5000, 0, b'1', 9999, '', 0, 6),
	(100, 'Teh kotak', NULL, 0, 5000, 0, b'1', 9999, NULL, 0, 6),
	(101, 'Sari asam', NULL, 0, 7000, 0, b'1', 9999, NULL, 0, 6),
	(102, 'Sari kacang', NULL, 0, 6000, 0, b'1', 9999, NULL, 0, 6),
	(103, 'Es cendol', NULL, 0, 10000, 0, b'1', 9999, NULL, 0, 6),
	(104, 'Thai tea cincau', NULL, 0, 12000, 0, b'1', 9999, NULL, 0, 6),
	(105, 'Ichitan', NULL, 0, 9000, 0, b'1', 9999, NULL, 0, 6),
	(106, 'Junior 1', NULL, 0, 16000, 0, b'1', 9999, NULL, 0, 2),
	(107, 'Junior 2', NULL, 0, 18500, 0, b'1', 9999, NULL, 0, 2),
	(108, 'Dada geprek', NULL, 0, 15000, 0, b'1', 9999, NULL, 0, 1),
	(109, 'Sayap/paha geprek', NULL, 0, 11000, 0, b'1', 9999, NULL, 0, 1),
	(110, 'Sambal geprek', NULL, 0, 4000, 0, b'1', 9999, NULL, 0, 1),
	(111, 'Fish Fillet', NULL, 0, 17000, 0, b'1', 9999, NULL, 0, 7),
	(112, 'Steak dori', NULL, 0, 22000, 0, b'1', 9999, NULL, 0, 7),
	(113, 'Chicken pop', NULL, 0, 15000, 0, b'1', 9999, NULL, 0, 7),
	(114, 'Ice crunchy', NULL, 0, 15000, 0, b'1', 9999, NULL, 0, 6),
	(115, 'Cup mineral', NULL, 0, 1000, 0, b'1', 9999, NULL, 0, 6),
	(116, 'Pepper try', NULL, 0, 1000, 0, b'1', 9999, NULL, 0, 5),
	(117, 'Kotak kecil', NULL, 0, 1000, 0, b'1', 9999, NULL, 0, 5);
/*!40000 ALTER TABLE `menu_item` ENABLE KEYS */;

-- Dumping structure for table db_pos.restaurant
DROP TABLE IF EXISTS `restaurant`;
CREATE TABLE IF NOT EXISTS `restaurant` (
  `ID` int(11) NOT NULL,
  `UNIQUE_ID` int(11) DEFAULT NULL,
  `NAME` varchar(120) DEFAULT NULL,
  `ADDRESS_LINE1` varchar(60) DEFAULT NULL,
  `ADDRESS_LINE2` varchar(60) DEFAULT NULL,
  `ADDRESS_LINE3` varchar(60) DEFAULT NULL,
  `ZIP_CODE` varchar(10) DEFAULT NULL,
  `TELEPHONE` varchar(16) DEFAULT NULL,
  `CAPACITY` int(11) DEFAULT NULL,
  `TABLES` int(11) DEFAULT NULL,
  `CNAME` varchar(20) DEFAULT NULL,
  `CSYMBOL` varchar(10) DEFAULT NULL,
  `TICKET_FOOTER` varchar(60) DEFAULT NULL,
  `PRICE_INCLUDES_TAX` bit(1) DEFAULT NULL,
  `OPENING_BALANCE` double DEFAULT NULL,
  `LOGO` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.restaurant: 1 rows
DELETE FROM `restaurant`;
/*!40000 ALTER TABLE `restaurant` DISABLE KEYS */;
INSERT INTO `restaurant` (`ID`, `UNIQUE_ID`, `NAME`, `ADDRESS_LINE1`, `ADDRESS_LINE2`, `ADDRESS_LINE3`, `ZIP_CODE`, `TELEPHONE`, `CAPACITY`, `TABLES`, `CNAME`, `CSYMBOL`, `TICKET_FOOTER`, `PRICE_INCLUDES_TAX`, `OPENING_BALANCE`, `LOGO`) VALUES
	(1, 1, 'ODaBa Ayam Goreng', 'Jl. Adi Sucipto', NULL, NULL, NULL, '081267050100', 0, 0, 'Rupiah', 'Rp', 'Terima Kasih & Selamat Belanja Kembali', b'0', 500000, 'Y');
/*!40000 ALTER TABLE `restaurant` ENABLE KEYS */;

-- Dumping structure for table db_pos.terminal
DROP TABLE IF EXISTS `terminal`;
CREATE TABLE IF NOT EXISTS `terminal` (
  `ID_TERMINAL` int(5) NOT NULL AUTO_INCREMENT,
  `TERMINAL` varchar(25) DEFAULT NULL,
  `URL` varchar(25) DEFAULT NULL,
  `NO_TRANSACTION` int(11) DEFAULT NULL,
  `IP_TERMINAL` varchar(25) DEFAULT NULL,
  `FLAG` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`ID_TERMINAL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.terminal: 0 rows
DELETE FROM `terminal`;
/*!40000 ALTER TABLE `terminal` DISABLE KEYS */;
/*!40000 ALTER TABLE `terminal` ENABLE KEYS */;

-- Dumping structure for table db_pos.th_ticket
DROP TABLE IF EXISTS `th_ticket`;
CREATE TABLE IF NOT EXISTS `th_ticket` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NO_TRANSACTION` int(11) DEFAULT NULL,
  `TERMINAL` varchar(25) DEFAULT NULL,
  `ID_USER` varchar(10) DEFAULT NULL,
  `CREATE_DATE` datetime DEFAULT NULL,
  `CLOSING_DATE` datetime DEFAULT NULL,
  `DELIVERY_DATE` datetime DEFAULT NULL,
  `TICKET_TYPE` varchar(30) DEFAULT NULL,
  `PAYMENT_TYPE` varchar(30) DEFAULT NULL,
  `AMOUNT` double DEFAULT NULL,
  `TENDER_AMOUNT` double DEFAULT NULL,
  `DUE_AMOUNT` double DEFAULT NULL,
  `NOTE` varchar(255) DEFAULT NULL,
  `STATUS` varchar(25) DEFAULT NULL,
  `ID_TRANSACTION` int(11) DEFAULT NULL,
  `SYNC` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.th_ticket: 0 rows
DELETE FROM `th_ticket`;
/*!40000 ALTER TABLE `th_ticket` DISABLE KEYS */;
/*!40000 ALTER TABLE `th_ticket` ENABLE KEYS */;

-- Dumping structure for table db_pos.th_ticket_item
DROP TABLE IF EXISTS `th_ticket_item`;
CREATE TABLE IF NOT EXISTS `th_ticket_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TERMINAL` varchar(25) DEFAULT NULL,
  `ITEM_ID` int(11) DEFAULT NULL,
  `ITEM_COUNT` int(11) DEFAULT NULL,
  `ITEM_NAME` varchar(120) DEFAULT NULL,
  `CATEGORY_NAME` varchar(120) DEFAULT NULL,
  `ITEM_PRICE` double DEFAULT NULL,
  `DISCOUNT_RATE` double DEFAULT NULL,
  `SUB_TOTAL` double DEFAULT NULL,
  `DISCOUNT` double DEFAULT NULL,
  `TAX_AMOUNT` double DEFAULT NULL,
  `TOTAL_PRICE` double DEFAULT NULL,
  `NO_TRANSACTION` int(11) DEFAULT NULL,
  `SYNC` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.th_ticket_item: 0 rows
DELETE FROM `th_ticket_item`;
/*!40000 ALTER TABLE `th_ticket_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `th_ticket_item` ENABLE KEYS */;

-- Dumping structure for table db_pos.ticket
DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NO_TRANSACTION` int(11) DEFAULT NULL,
  `TERMINAL` varchar(25) DEFAULT NULL,
  `ID_USER` varchar(10) DEFAULT NULL,
  `CREATE_DATE` datetime DEFAULT NULL,
  `CLOSING_DATE` datetime DEFAULT NULL,
  `DELIVERY_DATE` datetime DEFAULT NULL,
  `TICKET_TYPE` varchar(30) DEFAULT NULL,
  `PAYMENT_TYPE` varchar(30) DEFAULT NULL,
  `AMOUNT` double DEFAULT NULL,
  `TENDER_AMOUNT` double DEFAULT NULL,
  `DUE_AMOUNT` double DEFAULT NULL,
  `NOTE` varchar(255) DEFAULT NULL,
  `STATUS` varchar(25) DEFAULT NULL,
  `ID_TRANSACTION` int(11) DEFAULT NULL,
  `SYNC` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.ticket: 0 rows
DELETE FROM `ticket`;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;

-- Dumping structure for table db_pos.ticket_item
DROP TABLE IF EXISTS `ticket_item`;
CREATE TABLE IF NOT EXISTS `ticket_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TERMINAL` varchar(25) DEFAULT NULL,
  `ITEM_ID` int(11) DEFAULT NULL,
  `ITEM_COUNT` int(11) DEFAULT NULL,
  `ITEM_NAME` varchar(120) DEFAULT NULL,
  `CATEGORY_NAME` varchar(120) DEFAULT NULL,
  `ITEM_PRICE` double DEFAULT NULL,
  `DISCOUNT_RATE` double DEFAULT NULL,
  `SUB_TOTAL` double DEFAULT NULL,
  `DISCOUNT` double DEFAULT NULL,
  `TAX_AMOUNT` double DEFAULT NULL,
  `TOTAL_PRICE` double DEFAULT NULL,
  `NO_TRANSACTION` int(11) DEFAULT NULL,
  `SYNC` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.ticket_item: 0 rows
DELETE FROM `ticket_item`;
/*!40000 ALTER TABLE `ticket_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_item` ENABLE KEYS */;

-- Dumping structure for table db_pos.transaction
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_TRANSACTION` int(11) DEFAULT NULL,
  `TERMINAL` varchar(25) DEFAULT NULL,
  `TRANS_DATE` date DEFAULT NULL,
  `CREATE_DATE` datetime DEFAULT NULL,
  `CLOSING_DATE` datetime DEFAULT NULL,
  `OPENING_BALANCE` double DEFAULT NULL,
  `ASSIGNED_USER` varchar(10) DEFAULT NULL,
  `FLAG` enum('Y','N') DEFAULT 'N',
  `SYNC` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.transaction: 0 rows
DELETE FROM `transaction`;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;

-- Dumping structure for table db_pos.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `ID_USER` int(5) NOT NULL AUTO_INCREMENT,
  `USER_ID` varchar(8) DEFAULT NULL,
  `USER_PASS` varchar(8) NOT NULL,
  `FIRST_NAME` varchar(30) DEFAULT NULL,
  `LAST_NAME` varchar(30) DEFAULT NULL,
  `PHONE_NO` varchar(20) DEFAULT NULL,
  `IS_DRIVER` int(1) DEFAULT NULL,
  `AVAILABLE_FOR_DELIVERY` bit(1) DEFAULT NULL,
  `ACTIVE` bit(1) DEFAULT NULL,
  `USER_TYPE_ID` int(2) DEFAULT NULL,
  PRIMARY KEY (`ID_USER`),
  UNIQUE KEY `USER_PASS` (`USER_PASS`),
  UNIQUE KEY `USER_ID` (`USER_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.user: 45 rows
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`ID_USER`, `USER_ID`, `USER_PASS`, `FIRST_NAME`, `LAST_NAME`, `PHONE_NO`, `IS_DRIVER`, `AVAILABLE_FOR_DELIVERY`, `ACTIVE`, `USER_TYPE_ID`) VALUES
	(1, '1000', '1000', 'Harry', 'Handoko', NULL, 0, b'0', b'1', 1),
	(2, '1001', '1001', 'Irnaldo', 'Yoga', NULL, 0, b'0', b'1', 2),
	(3, '1002', '21519', 'Dewi', '', NULL, 0, b'0', b'1', 3),
	(4, '1003', '1003', 'Lenong', NULL, NULL, 0, b'0', b'1', 3),
	(5, '2001', '2001', 'Apriani', NULL, NULL, 0, b'0', b'1', 4),
	(6, '2002', '2002', 'Jhonny', NULL, NULL, 0, b'0', b'1', 4),
	(7, '2003', '2003', 'Yuli', NULL, NULL, 0, b'0', b'0', 4),
	(8, '2004', '2004', 'Ayu', NULL, NULL, 0, b'0', b'0', 4),
	(9, '2005', '2005', 'Lusi', NULL, NULL, 0, b'0', b'1', 4),
	(10, '2006', '2006', 'Eni', NULL, NULL, 0, b'0', b'1', 4),
	(11, '2007', '2007', 'Iin', NULL, NULL, 0, b'0', b'1', 4),
	(12, '2008', '2008', 'Kesi', NULL, NULL, 0, b'0', b'0', 4),
	(13, '2009', '2009', 'Siti', NULL, NULL, 0, b'0', b'0', 4),
	(14, '2010', '2010', 'Rita', NULL, NULL, 0, b'0', b'1', 4),
	(15, '2011', '2011', 'Irma', NULL, NULL, 0, b'0', b'1', 4),
	(16, '2012', '2012', 'Nia', NULL, NULL, 0, b'0', b'1', 4),
	(17, '2013', '2013', 'Sopie', '', NULL, 0, b'0', b'1', 4),
	(18, '2014', '2014', 'Lia', NULL, NULL, 0, b'0', b'1', 4),
	(19, '2015', '2015', 'Resti', NULL, NULL, 0, b'0', b'1', 4),
	(20, '2016', '2016', 'Reka', NULL, NULL, 0, b'0', b'1', 4),
	(21, '2017', '2017', 'Maya', NULL, NULL, 0, b'0', b'1', 4),
	(22, '2018', '2018', 'Puja', NULL, NULL, 0, b'0', b'1', 4),
	(23, '2019', '2019', 'Nandes', NULL, NULL, 0, b'0', b'1', 4),
	(24, '2020', '2020', 'Yudhia', NULL, NULL, 0, b'0', b'1', 4),
	(25, '2021', '2021', 'Novi', NULL, NULL, 0, b'0', b'1', 4),
	(26, '2022', '2022', 'Dini', NULL, NULL, 0, b'0', b'1', 4),
	(27, '2023', '2023', 'Tiara', NULL, NULL, 0, b'0', b'1', 4),
	(28, '2024', '2024', 'Dini Junior', NULL, NULL, 0, b'0', b'1', 4),
	(29, '2025', '2025', 'Reka', NULL, NULL, 0, b'0', b'1', 4),
	(30, '2026', '2026', 'Rani', NULL, NULL, 0, b'0', b'1', 4),
	(31, '2027', '2027', 'Susi', NULL, NULL, 0, b'0', b'1', 4),
	(32, '2028', '2028', 'Vera', NULL, NULL, 0, b'0', b'1', 4),
	(33, '2029', '2029', 'Nola', NULL, NULL, 0, b'0', b'1', 4),
	(34, '2030', '2030', 'Yogi', NULL, NULL, 0, b'0', b'1', 4),
	(35, '2031', '2031', 'Yoga', NULL, NULL, 0, b'0', b'1', 4),
	(36, '2032', '2032', 'Fatimah', NULL, NULL, 0, b'0', b'1', 4),
	(37, '2033', '2033', 'Mega', NULL, NULL, 0, b'0', b'1', 4),
	(38, '2034', '2034', 'Zuliana', NULL, NULL, 0, b'0', b'1', 4),
	(39, '2035', '2035', 'Fitri', '', NULL, 0, b'0', b'1', 4),
	(40, '2036', '2036', 'Nani', '', NULL, 0, b'0', b'1', 4),
	(41, '2037', '2037', 'Ina', NULL, NULL, 0, b'0', b'1', 4),
	(42, '2038', '2038', 'Feri', NULL, NULL, 0, b'0', b'1', 4),
	(43, '2039', '2039', 'Putri', NULL, NULL, 0, b'0', b'1', 4),
	(44, '2040', '2040', 'haris', NULL, NULL, 0, b'0', b'1', 4),
	(45, '2041', '2041', 'Ayu andira', NULL, NULL, 0, b'0', b'1', 4);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for table db_pos.user_menu
DROP TABLE IF EXISTS `user_menu`;
CREATE TABLE IF NOT EXISTS `user_menu` (
  `NAME` varchar(100) NOT NULL,
  PRIMARY KEY (`NAME`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.user_menu: 21 rows
DELETE FROM `user_menu`;
/*!40000 ALTER TABLE `user_menu` DISABLE KEYS */;
INSERT INTO `user_menu` (`NAME`) VALUES
	('Add Discount'),
	('Authorize Tickets'),
	('Create New Ticket'),
	('Drawer Assignment'),
	('Drawer Pull'),
	('Edit Ticket'),
	('Manage Table Layout'),
	('Pay Out'),
	('Perform Administrative Task'),
	('Perform Manager Task'),
	('Refund'),
	('Reopen Ticket'),
	('Settle Ticket'),
	('Shut Down'),
	('Split Ticket'),
	('Take Out'),
	('View All Open Ticket'),
	('View Back Office'),
	('View Explorers'),
	('View Reports'),
	('Void Ticket');
/*!40000 ALTER TABLE `user_menu` ENABLE KEYS */;

-- Dumping structure for table db_pos.user_permission
DROP TABLE IF EXISTS `user_permission`;
CREATE TABLE IF NOT EXISTS `user_permission` (
  `USER_TYPE_ID` int(5) NOT NULL,
  `USER_MENU_NAME` varchar(100) NOT NULL,
  PRIMARY KEY (`USER_TYPE_ID`,`USER_MENU_NAME`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.user_permission: 53 rows
DELETE FROM `user_permission`;
/*!40000 ALTER TABLE `user_permission` DISABLE KEYS */;
INSERT INTO `user_permission` (`USER_TYPE_ID`, `USER_MENU_NAME`) VALUES
	(1, 'Add Discount'),
	(1, 'Authorize Tickets'),
	(1, 'Create New Ticket'),
	(1, 'Drawer Assignment'),
	(1, 'Drawer Pull'),
	(1, 'Edit Ticket'),
	(1, 'Manage Table Layout'),
	(1, 'Pay Out'),
	(1, 'Perform Administrative Task'),
	(1, 'Perform Manager Task'),
	(1, 'Refund'),
	(1, 'Reopen Ticket'),
	(1, 'Settle Ticket'),
	(1, 'Shut Down'),
	(1, 'Split Ticket'),
	(1, 'Take Out'),
	(1, 'View All Open Ticket'),
	(1, 'View Back Office'),
	(1, 'View Explorers'),
	(1, 'View Reports'),
	(1, 'Void Ticket'),
	(2, 'Add Discount'),
	(2, 'Authorize Tickets'),
	(2, 'Create New Ticket'),
	(2, 'Drawer Assignment'),
	(2, 'Drawer Pull'),
	(2, 'Edit Ticket'),
	(2, 'Manage Table Layout'),
	(2, 'Pay Out'),
	(2, 'Perform Administrative Task'),
	(2, 'Perform Manager Task'),
	(2, 'Refund'),
	(2, 'Reopen Ticket'),
	(2, 'Settle Ticket'),
	(2, 'Shut Down'),
	(2, 'Split Ticket'),
	(2, 'Take Out'),
	(2, 'View All Open Ticket'),
	(2, 'View Back Office'),
	(2, 'View Explorers'),
	(2, 'View Reports'),
	(2, 'Void Ticket'),
	(3, 'Create New Ticket'),
	(3, 'Edit Ticket'),
	(3, 'Settle Ticket'),
	(3, 'Split Ticket'),
	(3, 'Take Out'),
	(3, 'View All Open Ticket'),
	(4, 'Create New Ticket'),
	(4, 'Edit Ticket'),
	(4, 'Settle Ticket'),
	(4, 'Split Ticket'),
	(4, 'Take Out');
/*!40000 ALTER TABLE `user_permission` ENABLE KEYS */;

-- Dumping structure for table db_pos.user_type
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE IF NOT EXISTS `user_type` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `USER_TYPE` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.user_type: 5 rows
DELETE FROM `user_type`;
/*!40000 ALTER TABLE `user_type` DISABLE KEYS */;
INSERT INTO `user_type` (`ID`, `USER_TYPE`) VALUES
	(1, 'ADMINISTRATOR'),
	(2, 'MANAGER'),
	(3, 'SUPERVISOR'),
	(4, 'CASHIER'),
	(5, 'EMPLOYEE');
/*!40000 ALTER TABLE `user_type` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
