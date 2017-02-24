CREATE TABLE `user_loginlog` (
  `id` bigint(64) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `username` varchar(100) COLLATE utf8_esperanto_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8_esperanto_ci DEFAULT NULL,
  `time` datetime NOT NULL,
  `ip` char(16) COLLATE utf8_esperanto_ci NOT NULL,
  `agent` varchar(100) COLLATE utf8_esperanto_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agent` (`agent`),
  KEY `time` (`time`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1923 DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;
insert  into `user_auth`(`first_auth`,`user_id`,`second_auth`) values ('人员管理',1,'登陆日志');