ALTER TABLE `posts` ADD `author_type` ENUM('user','admin') NOT NULL DEFAULT 'user' AFTER `user_id`;






INSERT INTO `site_settings` (`id`, `name`, `criteria`, `settings`, `default_setting`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'General Tax Settings', 'general_tax', '{\r\n\"components\":{\"vat_percent\":\"20\",\"sgst\":\"0\"}\r\n}\r\n', '', NULL, NULL, '2020-05-14 18:05:34')



ALTER TABLE `orders` ADD `offer` LONGTEXT NULL AFTER `paid_at`;


ALTER TABLE `courses` ADD `offers` LONGTEXT NULL AFTER `price`;


--table
	 offers
	 testimonials


