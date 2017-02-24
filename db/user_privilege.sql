-- phpMyAdmin SQL Dump
-- version 4.2.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2015 at 04:12 AM
-- Server version: 5.6.17
-- PHP Version: 5.6.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jim_monitor2`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_privilege`
--

CREATE TABLE IF NOT EXISTS `user_privilege` (
  `user_id` int(11) NOT NULL,
  `area_privilege` text NOT NULL,
  `dev_privilege` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_privilege`
--

INSERT INTO `user_privilege` (`user_id`, `area_privilege`, `dev_privilege`) VALUES
(1, '[1,2,3,4,5,6,7,8,9]', '["water","smoke"] '),
(2, '["903"]', '["water","temperature","humid","smoke"]'),
(4, '["5","6","7","8","9","3"]', '["water","temperature","humid","smoke","imem_12","battery_24","battery_32","fresh_air","psma-ac","psma-rc","psma-dc","Netsure801CA7","libert-ups","libert-ac","motivator"]'),
(5, '["1"]', '["temperature","humid","smoke","imem_12","battery_24","battery_32","fresh_air","psma-ac","psma-rc","psma-dc","Netsure801CA7","libert-ac"]'),
(6, '["2","4","8","9","3"]', '["water","temperature","humid","smoke","imem_12","battery_24","battery_32","fresh_air","psma-ac","psma-rc","psma-dc","Netsure801CA7","libert-ups","libert-ac","motivator"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_privilege`
--
ALTER TABLE `user_privilege`
 ADD UNIQUE KEY `user_id` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
