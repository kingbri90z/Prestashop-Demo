DROP TABLE IF EXISTS `ps_smart_blog_media`;
CREATE TABLE `ps_smart_blog_media` (
  `id_media` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `media_path` varchar(45) DEFAULT NULL,
  `media_name` varchar(45) DEFAULT NULL,
  `media_description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_media`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

