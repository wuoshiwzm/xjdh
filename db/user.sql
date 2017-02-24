-- phpMyAdmin SQL Dump
-- version 4.2.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2015 at 04:11 AM
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
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` bigint(20) unsigned NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `user_role` enum('admin','noc','city_admin','member') NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `info` varchar(50) NOT NULL,
  `substation_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `added_datetime` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `gender`, `user_role`, `full_name`, `mobile`, `email`, `info`, `substation_id`, `is_active`, `added_datetime`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'male', 'admin', '管理员', '15109272185', 'admin@admin.com', '', 0, 1, '0000-00-00 00:00:00'),
(2, 'operator', 'e10adc3949ba59abbe56e057f20f883e', 'male', 'city_admin', '操作者', '15109272181', 'admin11@admin.com', '', 2, 1, '2015-06-06 19:19:36'),
(4, 'noc_user', 'e10adc3949ba59abbe56e057f20f883e', 'male', 'noc', 'NOC', '15109272188', '12121@1.com', '', 0, 1, '2015-06-08 11:32:31'),
(5, 'kuitun', 'e10adc3949ba59abbe56e057f20f883e', 'male', 'member', '奎屯监控员', '15109272183', 'user1@admin11.com', '', 1, 1, '2015-06-09 22:19:21'),
(6, 'hetian', 'e10adc3949ba59abbe56e057f20f883e', 'male', 'member', '和田普通用户', '15109272189', '121121@1.com', '', 2, 1, '2015-06-10 11:01:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
