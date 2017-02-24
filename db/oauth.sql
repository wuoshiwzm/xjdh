-- phpMyAdmin SQL Dump
-- version 4.2.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 05, 2015 at 03:29 AM
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
-- Table structure for table `oauth_clients`
--

CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` char(40) NOT NULL,
  `secret` char(40) NOT NULL,
  `name` varchar(255) NOT NULL,
  `auto_approve` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `secret`, `name`, `auto_approve`) VALUES
('xjtele', 'xjtele', 'xjtele', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_client_endpoints`
--

CREATE TABLE IF NOT EXISTS `oauth_client_endpoints` (
`id` int(10) unsigned NOT NULL,
  `client_id` char(40) NOT NULL,
  `redirect_uri` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_client_endpoints`
--

INSERT INTO `oauth_client_endpoints` (`id`, `client_id`, `redirect_uri`) VALUES
(1, 'xjtele', 'www.xjdh.com');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_scopes` (
`id` smallint(5) unsigned NOT NULL,
  `scope` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_sessions`
--

CREATE TABLE IF NOT EXISTS `oauth_sessions` (
`id` int(10) unsigned NOT NULL,
  `client_id` char(40) NOT NULL,
  `owner_type` enum('user','client') NOT NULL DEFAULT 'user',
  `owner_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_session_access_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_session_access_tokens` (
`id` int(10) unsigned NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `access_token` char(40) NOT NULL,
  `access_token_expires` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_session_authcodes`
--

CREATE TABLE IF NOT EXISTS `oauth_session_authcodes` (
`id` int(10) unsigned NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `auth_code` char(40) NOT NULL,
  `auth_code_expires` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_session_authcode_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_session_authcode_scopes` (
  `oauth_session_authcode_id` int(10) unsigned NOT NULL,
  `scope_id` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_session_redirects`
--

CREATE TABLE IF NOT EXISTS `oauth_session_redirects` (
  `session_id` int(10) unsigned NOT NULL,
  `redirect_uri` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_session_refresh_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_session_refresh_tokens` (
  `session_access_token_id` int(10) unsigned NOT NULL,
  `refresh_token` char(40) NOT NULL,
  `refresh_token_expires` int(10) unsigned NOT NULL,
  `client_id` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_session_token_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_session_token_scopes` (
`id` bigint(20) unsigned NOT NULL,
  `session_access_token_id` int(10) unsigned DEFAULT NULL,
  `scope_id` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `u_oacl_clse_clid` (`secret`,`id`);

--
-- Indexes for table `oauth_client_endpoints`
--
ALTER TABLE `oauth_client_endpoints`
 ADD PRIMARY KEY (`id`), ADD KEY `i_oaclen_clid` (`client_id`);

--
-- Indexes for table `oauth_scopes`
--
ALTER TABLE `oauth_scopes`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `u_oasc_sc` (`scope`);

--
-- Indexes for table `oauth_sessions`
--
ALTER TABLE `oauth_sessions`
 ADD PRIMARY KEY (`id`), ADD KEY `i_uase_clid_owty_owid` (`client_id`,`owner_type`,`owner_id`);

--
-- Indexes for table `oauth_session_access_tokens`
--
ALTER TABLE `oauth_session_access_tokens`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `u_oaseacto_acto_seid` (`access_token`,`session_id`), ADD KEY `f_oaseto_seid` (`session_id`);

--
-- Indexes for table `oauth_session_authcodes`
--
ALTER TABLE `oauth_session_authcodes`
 ADD PRIMARY KEY (`id`), ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `oauth_session_authcode_scopes`
--
ALTER TABLE `oauth_session_authcode_scopes`
 ADD KEY `oauth_session_authcode_id` (`oauth_session_authcode_id`), ADD KEY `scope_id` (`scope_id`);

--
-- Indexes for table `oauth_session_redirects`
--
ALTER TABLE `oauth_session_redirects`
 ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `oauth_session_refresh_tokens`
--
ALTER TABLE `oauth_session_refresh_tokens`
 ADD PRIMARY KEY (`session_access_token_id`), ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `oauth_session_token_scopes`
--
ALTER TABLE `oauth_session_token_scopes`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `u_setosc_setoid_scid` (`session_access_token_id`,`scope_id`), ADD KEY `f_oasetosc_scid` (`scope_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oauth_client_endpoints`
--
ALTER TABLE `oauth_client_endpoints`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `oauth_scopes`
--
ALTER TABLE `oauth_scopes`
MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_sessions`
--
ALTER TABLE `oauth_sessions`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_session_access_tokens`
--
ALTER TABLE `oauth_session_access_tokens`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_session_authcodes`
--
ALTER TABLE `oauth_session_authcodes`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_session_token_scopes`
--
ALTER TABLE `oauth_session_token_scopes`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `oauth_client_endpoints`
--
ALTER TABLE `oauth_client_endpoints`
ADD CONSTRAINT `f_oaclen_clid` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth_sessions`
--
ALTER TABLE `oauth_sessions`
ADD CONSTRAINT `f_oase_clid` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth_session_access_tokens`
--
ALTER TABLE `oauth_session_access_tokens`
ADD CONSTRAINT `f_oaseto_seid` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `oauth_session_authcodes`
--
ALTER TABLE `oauth_session_authcodes`
ADD CONSTRAINT `oauth_session_authcodes_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_session_authcode_scopes`
--
ALTER TABLE `oauth_session_authcode_scopes`
ADD CONSTRAINT `oauth_session_authcode_scopes_ibfk_2` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `oauth_session_authcode_scopes_ibfk_1` FOREIGN KEY (`oauth_session_authcode_id`) REFERENCES `oauth_session_authcodes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oauth_session_redirects`
--
ALTER TABLE `oauth_session_redirects`
ADD CONSTRAINT `f_oasere_seid` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `oauth_session_refresh_tokens`
--
ALTER TABLE `oauth_session_refresh_tokens`
ADD CONSTRAINT `oauth_session_refresh_tokens_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `f_oasetore_setoid` FOREIGN KEY (`session_access_token_id`) REFERENCES `oauth_session_access_tokens` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `oauth_session_token_scopes`
--
ALTER TABLE `oauth_session_token_scopes`
ADD CONSTRAINT `f_oasetosc_scid` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `f_oasetosc_setoid` FOREIGN KEY (`session_access_token_id`) REFERENCES `oauth_session_access_tokens` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
