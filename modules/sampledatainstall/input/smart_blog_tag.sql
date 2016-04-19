DROP TABLE IF EXISTS `ps_smart_blog_tag`;
CREATE TABLE `ps_smart_blog_tag` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `id_lang` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_tag`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/* Scheme for table ps_smart_blog_tag */
INSERT INTO `ps_smart_blog_tag` VALUES
('1','1','lorem'),
('2','1','ipsum'),
('3','1','dolore'),
('4','2','lorem'),
('5','2','ipsum'),
('6','2','dolore'),
('7','3','lorem'),
('8','3','ipsum'),
('9','3','dolore'),
('10','4','lorem'),
('11','4','ipsum'),
('12','4','dolore'),
('13','5','lorem'),
('14','5','ipsum'),
('15','5','dolore');
