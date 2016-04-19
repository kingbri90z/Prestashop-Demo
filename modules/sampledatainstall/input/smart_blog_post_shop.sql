DROP TABLE IF EXISTS `ps_smart_blog_post_shop`;
CREATE TABLE `ps_smart_blog_post_shop` (
  `id_smart_blog_post_shop` int(11) NOT NULL AUTO_INCREMENT,
  `id_smart_blog_post` int(11) NOT NULL,
  `id_shop` int(11) NOT NULL,
  PRIMARY KEY (`id_smart_blog_post_shop`,`id_smart_blog_post`,`id_shop`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/* Scheme for table ps_smart_blog_post_shop */
INSERT INTO `ps_smart_blog_post_shop` VALUES
('1','1','1'),
('2','2','1'),
('3','3','1'),
('4','4','1');
