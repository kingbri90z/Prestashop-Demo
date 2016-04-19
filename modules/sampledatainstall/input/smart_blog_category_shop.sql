DROP TABLE IF EXISTS `ps_smart_blog_category_shop`;
CREATE TABLE `ps_smart_blog_category_shop` (
  `id_smart_blog_category_shop` int(11) NOT NULL AUTO_INCREMENT,
  `id_smart_blog_category` int(11) NOT NULL,
  `id_shop` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_smart_blog_category_shop`,`id_smart_blog_category`,`id_shop`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/* Scheme for table ps_smart_blog_category_shop */
INSERT INTO `ps_smart_blog_category_shop` VALUES
('1','1','1');
