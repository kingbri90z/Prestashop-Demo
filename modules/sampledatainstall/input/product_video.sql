DROP TABLE IF EXISTS `ps_product_video`;
CREATE TABLE `ps_product_video` (
  `id_video` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(10) unsigned NOT NULL,
  `id_product` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_video`,`id_shop`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/* Scheme for table ps_product_video */
INSERT INTO `ps_product_video` VALUES
('1','1','3'),
('2','1','2'),
('3','1','3'),
('4','1','6'),
('5','1','5'),
('6','1','1'),
('7','1','11'),
('8','1','7'),
('9','1','20');
