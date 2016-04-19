DROP TABLE IF EXISTS `ps_smart_blog_comment`;
CREATE TABLE `ps_smart_blog_comment` (
  `id_smart_blog_comment` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) DEFAULT NULL,
  `id_customer` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `website` varchar(128) DEFAULT NULL,
  `content` text,
  `active` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id_smart_blog_comment`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/* Scheme for table ps_smart_blog_comment */
INSERT INTO `ps_smart_blog_comment` VALUES
('2','0','0','4','John Doe','admin@admin.com','#','Fusce id felis tempor, mollis ligula ac, iaculis massa. Aliquam nec mollis neque, eget laoreet nibh. Vivamus dictum tempor enim, a porttitor dui lacinia vitae.','1','2014-10-15 10:24:25'),
('3','2','0','4','Anna Lee','admin@admin.com','#','Cras in sem in arcu ultrices egestas sit amet nec metus.','1','2014-10-15 10:25:56'),
('4','2','0','4','Fred Crue','admin@admin.com','#','Suspendisse magna nisi, cursus ut condimentum eu, dapibus at dolor. Sed venenatis sapien quis urna consequat, quis tempor neque porttitor.','1','2014-10-15 10:26:57'),
('5','0','0','4','Anny Dawson','admin@admin.com','#','Vivamus iaculis eleifend varius. Vestibulum quis justo massa. Mauris et eros mollis, placerat mauris nec, mattis purus. Aliquam elementum lorem ac efficitur tristique. Duis vehicula non sapien eget rhoncus. Nulla et congue nunc, id eleifend neque.','1','2014-10-15 10:28:33'),
('6','4','0','4','Nick Nickelson','admin@admin.com','#','In hac habitasse platea dictumst. Nunc lacinia fringilla mi. Praesent quam nunc, pretium et aliquam ut, sollicitudin vel augue.','1','2014-10-15 10:29:22');
