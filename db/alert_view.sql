-- phpMyAdmin SQL Dump
-- version 4.2.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 14, 2015 at 05:51 PM
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
-- Structure for view `alert_view`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `alert_view` AS (select `alert`.`data_id` AS `data_id`,`device`.`name` AS `dev_name`,`device`.`model` AS `dev_model`,`device`.`room_id` AS `room_id` from (`alert` join `device` on((`alert`.`data_id` = `device`.`data_id`))) where (`alert`.`data_id` > 10000)) union (select `alert`.`data_id` AS `data_id`,`smd_device`.`name` AS `dev_name`,'smd_device' AS `dev_model`,`smd_device`.`room_id` AS `room_id` from (`alert` join `smd_device` on((`alert`.`data_id` = `smd_device`.`device_no`))) where (`alert`.`data_id` < 10000));

--
-- VIEW  `alert_view`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
