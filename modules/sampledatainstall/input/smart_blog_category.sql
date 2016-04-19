DROP TABLE IF EXISTS `ps_smart_blog_category`;
CREATE TABLE `ps_smart_blog_category` (
  `id_smart_blog_category` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` varchar(45) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `desc_limit` varchar(45) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id_smart_blog_category`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/* Scheme for table ps_smart_blog_category */
INSERT INTO `ps_smart_blog_category` VALUES
('1','0','0','0','1','0000-00-00 00:00:00','2014-10-15 10:22:21');
