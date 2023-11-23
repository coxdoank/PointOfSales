-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.1.72-community - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


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

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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
) ENGINE=MyISAM AUTO_INCREMENT=166 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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

-- Data exporting was unselected.

-- Dumping structure for table db_pos.user_menu
DROP TABLE IF EXISTS `user_menu`;
CREATE TABLE IF NOT EXISTS `user_menu` (
  `NAME` varchar(100) NOT NULL,
  PRIMARY KEY (`NAME`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table db_pos.user_permission
DROP TABLE IF EXISTS `user_permission`;
CREATE TABLE IF NOT EXISTS `user_permission` (
  `USER_TYPE_ID` int(5) NOT NULL,
  `USER_MENU_NAME` varchar(100) NOT NULL,
  PRIMARY KEY (`USER_TYPE_ID`,`USER_MENU_NAME`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table db_pos.user_type
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE IF NOT EXISTS `user_type` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `USER_TYPE` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
