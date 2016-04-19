DROP TABLE IF EXISTS `ps_smart_blog_post_category`;
CREATE TABLE `ps_smart_blog_post_category` (
  `id_smart_blog_post_category` int(11) NOT NULL,
  `id_smart_blog_category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

