ALTER TABLE `admin_comments` CHANGE `model` `model` ENUM('deposit','withdrawal','user_document','bank','product') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;



ALTER TABLE `products` ADD `status` INT NOT NULL DEFAULT '1' AFTER `cover`;
