ALTER TABLE `orders` ADD `payment_proof` LONGTEXT NULL AFTER `payment_details`;










ALTER TABLE `wallet_for_commissions` CHANGE `earning_category` `earning_category` ENUM('bonus','package','disagio','gold','silber','license','setup_fee','online_shop') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;


ALTER TABLE `products` ADD `commission_price` DECIMAL(20,2) NULL AFTER `price`;



ALTER TABLE `users_withdrawals` ADD `payment_month` DATETIME NULL AFTER `completed_at`;





ALTER TABLE `users_withdrawals` ADD `identifier` VARCHAR(255) NULL AFTER `method_details`;
