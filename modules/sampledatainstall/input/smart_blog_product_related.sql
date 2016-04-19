DROP TABLE IF EXISTS `ps_smart_blog_product_related`;
CREATE TABLE `ps_smart_blog_product_related` (
  `id_post` int(11) NOT NULL,
  `id_product` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

