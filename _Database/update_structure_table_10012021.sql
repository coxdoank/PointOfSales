-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table db_pos.terminal: ~1 rows (approximately)
DELETE FROM `terminal`;
/*!40000 ALTER TABLE `terminal` DISABLE KEYS */;
INSERT INTO `terminal` (`ID_TERMINAL`, `TERMINAL`, `URL`, `NO_TRANSACTION`, `IP_TERMINAL`, `FLAG`) VALUES
	(2, 'POS 01', '01', 0, '10.5.50.254', 'Y');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table db_pos.th_ticket: ~0 rows (approximately)
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table db_pos.th_ticket_item: ~0 rows (approximately)
DELETE FROM `th_ticket_item`;
/*!40000 ALTER TABLE `th_ticket_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `th_ticket_item` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
