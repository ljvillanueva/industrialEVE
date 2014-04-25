-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2014 at 12:38 PM
-- Server version: 5.5.37-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eve`
--

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE IF NOT EXISTS `components` (
  `itemID` int(11) NOT NULL,
  `itemName` varchar(150) NOT NULL,
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`itemID`, `itemName`) VALUES
(34, 'Tritanium'),
(35, 'Pyerite'),
(36, 'Mexallon'),
(37, 'Isogen'),
(38, 'Nocxium'),
(39, 'Zydrine'),
(40, 'Megacyte'),
(44, 'Enriched Uranium'),
(3683, 'Oxygen'),
(3689, 'Mechanical Parts'),
(9832, 'Coolant'),
(9848, 'Robotics'),
(16272, 'Heavy Water'),
(16273, 'Liquid Ozone'),
(17887, 'Oxygen Isotopes'),
(17888, 'Nitrogen Isotopes'),
(30370, 'Fullerite-C50'),
(30371, 'Fullerite-C60'),
(30372, 'Fullerite-C70'),
(30373, 'Fullerite-C72');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `itemID` int(11) NOT NULL,
  `itemName` varchar(150) NOT NULL,
  `myQuant` int(11) NOT NULL,
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `itemName`, `myQuant`) VALUES
(224, 'Tungsten Charge M', 100),
(483, 'Miner I', 1),
(1317, 'Expanded Cargohold I', 1),
(4051, 'Caldari Fuel Block', 40),
(4312, 'Gallente fuel block', 40),
(11285, 'Cap Booster 200', 10),
(16240, 'Catalyst', 1),
(17938, 'Core Probe Launcher I', 1),
(30303, 'Fulleroferrocene', 1000),
(30306, 'Methanofullerene', 80);

-- --------------------------------------------------------

--
-- Table structure for table `mycomp`
--

CREATE TABLE IF NOT EXISTS `mycomp` (
  `ItemID` int(11) NOT NULL,
  `ForItem` int(11) NOT NULL,
  `myQuant` int(11) NOT NULL,
  UNIQUE KEY `ForItem` (`ForItem`,`ItemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Ammount needed, according to char training';

--
-- Dumping data for table `mycomp`
--

INSERT INTO `mycomp` (`ItemID`, `ForItem`, `myQuant`) VALUES
(34, 224, 242),
(35, 224, 4),
(36, 224, 25),
(34, 483, 1430),
(35, 483, 520),
(36, 483, 128),
(37, 1317, 11),
(38, 1317, 1),
(44, 4051, 5),
(3683, 4051, 0),
(3689, 4051, 0),
(9832, 4051, 0),
(9848, 4051, 1),
(16272, 4051, 0),
(16273, 4051, 0),
(17888, 4051, 460),
(34, 11285, 1943),
(35, 11285, 396),
(36, 11285, 166),
(37, 11285, 13),
(39, 11285, 2),
(40, 11285, 1),
(34, 16240, 52267),
(35, 16240, 14740),
(36, 16240, 6459),
(38, 16240, 270),
(39, 16240, 46),
(40, 16240, 27),
(34, 17938, 0),
(35, 17938, 0),
(34, 30303, 1000),
(30370, 30303, 200),
(30371, 30303, 100),
(37, 30306, 300),
(30372, 30306, 100),
(30373, 30306, 100);

-- --------------------------------------------------------

--
-- Table structure for table `trade`
--

CREATE TABLE IF NOT EXISTS `trade` (
  `itemID` int(11) NOT NULL,
  `itemName` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `itemsize` float NOT NULL,
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trade`
--

INSERT INTO `trade` (`itemID`, `itemName`, `itemsize`) VALUES
(34, 'Tritanium', 0.01),
(35, 'Pyerite', 0.01),
(36, 'Mexallon', 0.01),
(37, 'Isogen', 0.01),
(38, 'Nocxium', 0.01),
(39, 'Zydrine', 0.01),
(40, 'Megacyte', 0.01),
(12056, '10MN Afterburner I', 25),
(16240, 'Catalyst', 5000),
(16274, 'Helium Isotopes', 0.15),
(16649, 'Technetium', 0.08),
(17887, 'Oxygen Isotopes', 0.15),
(17888, 'Nitrogen Isotopes', 0.15),
(17889, 'Hydrogen Isotopes', 0.15),
(29668, 'PLEX', 10000),
(30259, 'Melted Nanoribbons', 0.01),
(30303, 'Fulleroferrocene', 0.1),
(30370, 'Fullerite-C50', 1),
(30373, 'Fullerite-C72', 4),
(30375, 'Fullerite-C28', 0.4),
(30376, 'Fullerite-C32', 0.4),
(30377, 'Fullerite-C320', 10),
(30378, 'Fullerite-C540', 10);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
