DROP TABLE IF EXISTS `ps_smart_blog_post_related`;
CREATE TABLE `ps_smart_blog_post_related` (
  `id_post` int(11) NOT NULL,
  `related_post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

