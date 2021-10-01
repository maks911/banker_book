DROP TABLE IF EXISTS `kitchens`;

CREATE TABLE `kitchens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kitchen_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kitchens` (kitchen_name) VALUES ('Грузинская кухня'),('Индийскя кухня'),('Азиатская кухня');

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                            `value` text NOT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tags` (value) VALUES ('Острая'),('Вкусная'),('Экзотическая');

DROP TABLE IF EXISTS `kitchens_tags`;

CREATE TABLE `kitchens_tags` (
                        `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                        `tag_id` bigint(20) NOT NULL,
                        `kitchen_id` bigint(20) NOT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kitchens_tags` (tag_id, kitchen_id) VALUES (1, 3),(1, 2),(2, 1),(2, 2),(3, 2),(3,3);
