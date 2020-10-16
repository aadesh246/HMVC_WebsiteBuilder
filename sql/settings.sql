CREATE TABLE `settings` (
  `option_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` mediumtext NOT NULL,
  `auto_load` enum('no','yes') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`,`option_name`),
  KEY `option_name` (`option_name`),
  KEY `auto_load` (`auto_load`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` VALUES(1, 'site_title', 'Your Custom PHP MVC Framework', 'yes');
INSERT INTO `settings` VALUES(2, 'site_description', 'Get started buidling your own awesome website with built-in modules and libraries', 'yes');
INSERT INTO `settings` VALUES(3, 'site_author', 'Aadesh', 'yes');
INSERT INTO `settings` VALUES(4, 'base_controller', 'welcome',  'yes');
INSERT INTO `settings` VALUES(5, 'site_keywords', 'keywords, go, here', 'yes');
INSERT INTO `settings` VALUES(6, 'allow_registration', 'Yes', 'yes');
INSERT INTO `settings` VALUES(7, 'site_email', 'aadeshmishra246@gmail.com', 'yes');
INSERT INTO `settings` VALUES(8, 'email_activation', 'No', 'yes');
INSERT INTO `settings` VALUES(9, 'admin_email', 'admin@admin.com', 'yes');
INSERT INTO `settings` VALUES(10, 'mail_protocol', 'mail', 'yes');

