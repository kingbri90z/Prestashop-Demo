DROP TABLE IF EXISTS `ps_mailalert_customer_oos`;
CREATE TABLE `ps_mailalert_customer_oos` (
  `id_customer` int(10) unsigned NOT NULL,
  `customer_email` varchar(128) NOT NULL,
  `id_product` int(10) unsigned NOT NULL,
  `id_product_attribute` int(10) unsigned NOT NULL,
  `id_shop` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_customer`,`customer_email`,`id_product`,`id_product_attribute`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Scheme for table ps_mailalert_customer_oos */
INSERT INTO `ps_mailalert_customer_oos` VALUES
('2','admin@admin.com','9','52','1','1');
