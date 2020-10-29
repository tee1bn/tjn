

ALTER TABLE `sales` ADD `priced_amount` DECIMAL(20,2) NULL AFTER `currency`, ADD `priced_currency` VARCHAR(5) NULL AFTER `priced_amount`;
