DROP TABLE IF EXISTS `ps_smart_blog_imagetype`;
CREATE TABLE `ps_smart_blog_imagetype` (
  `id_smart_blog_imagetype` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(45) DEFAULT NULL,
  `width` varchar(45) DEFAULT NULL,
  `height` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_smart_blog_imagetype`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/* Scheme for table ps_smart_blog_imagetype */
INSERT INTO `ps_smart_blog_imagetype` VALUES
('1','home-default','270','180','post','1'),
('2','home-small','98','65','post','1'),
('3','single-default','870','580','post','1'),
('4','home-small','65','65','Category','1'),
('5','home-default','240','240','Category','1'),
('6','single-default','800','800','Category','1'),
('7','author-default','100','100','Author','1');
