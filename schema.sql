--
-- База данных: `TaskForce`
--
CREATE SCHEMA IF NOT EXISTS `TaskForce` DEFAULT CHARACTER SET utf8 ;
USE `TaskForce` ;

CREATE TABLE IF NOT EXISTS `TaskForce`.`city` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`longitude` DECIMAL(10,7) NOT NULL,
	`latitude` DECIMAL(10,7) NOT NULL,
	PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TaskForce`.`favorite` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT UNSIGNED NOT NULL,
	`favorite_id` INT UNSIGNED NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `fk_favorite_user_id`
		FOREIGN KEY (`user_id`)
		REFERENCES `TaskForce`.`user` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT `fk_favorite_favorite_id`
		FOREIGN KEY (`favorite_id`)
		REFERENCES `TaskForce`.`user` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TaskForce`.`user` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`password` VARCHAR(64) NOT NULL,
	`city_id` INT UNSIGNED NOT NULL,
	`longitude` DECIMAL(10,7) NOT NULL,
	`latitude` DECIMAL(10,7) NOT NULL,
	`role` VARCHAR(45) NOT NULL,
	`birthday` DATE NOT NULL,
	`about` TEXT NOT NULL,
	`phone` VARCHAR(45) NOT NULL,
	`skype` VARCHAR(45) NOT NULL,
	`telegram` VARCHAR(45) NOT NULL,
	`new_message` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`actions_task` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`new_review` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`show_contacts` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`now_show_profile` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`rate` TINYINT(3) NOT NULL,
	`views` INT NOT NULL,
	`last_active` TIMESTAMP NOT NULL,
	`date_created` TIMESTAMP NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `fk_user_city_id`
		FOREIGN KEY (`city_id`)
		REFERENCES `TaskForce`.`city` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TaskForce`.`category` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TaskForce`.`task` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`customer_id` INT UNSIGNED NOT NULL,
	`implementer_id` INT UNSIGNED NOT NULL,
	`category_id` INT UNSIGNED NOT NULL,
	`city_id` INT UNSIGNED NOT NULL,
	`address` VARCHAR(255) NOT NULL,
	`status` VARCHAR(45) NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`description` TEXT NOT NULL,
	`budget` INT NOT NULL,
	`longitude` DECIMAL(10,7) NOT NULL,
	`latitude` DECIMAL(10,7) NOT NULL,
	`end_date` TIMESTAMP NOT NULL,
	`date_created` TIMESTAMP NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `fk_task_category_id`
		FOREIGN KEY (`category_id`)
		REFERENCES `TaskForce`.`category` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT `fk_task_city_id`
		FOREIGN KEY (`city_id`)
		REFERENCES `TaskForce`.`city` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT `fk_task_customer_id`
		FOREIGN KEY (`customer_id`)
		REFERENCES `TaskForce`.`user` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TaskForce`.`chat_message` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`customer_id` INT UNSIGNED NULL,
	`implementer_id` INT UNSIGNED NULL,
	`task_id` INT UNSIGNED NULL,
	`message` TEXT NULL,
	`date_created` TIMESTAMP NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `fk_chat_message_task_id`
		FOREIGN KEY (`task_id`)
		REFERENCES `TaskForce`.`task` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TaskForce`.`response` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`task_id` INT UNSIGNED NOT NULL,
	`implementer_id` INT UNSIGNED NOT NULL,
	`description` TEXT NOT NULL,
	`price` INT UNSIGNED NOT NULL,
	`date_created` TIMESTAMP NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `fk_response_task_id`
		FOREIGN KEY (`task_id`)
		REFERENCES `TaskForce`.`task` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT `fk_response_implementer_id`
		FOREIGN KEY (`implementer_id`)
		REFERENCES `TaskForce`.`user` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TaskForce`.`reviews` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`customer_id` INT UNSIGNED NOT NULL,
	`implementer_id` INT UNSIGNED NOT NULL,
	`task_id` INT UNSIGNED NOT NULL,
	`message` TEXT NOT NULL,
	`rate` TINYINT(3) NOT NULL DEFAULT 0,
	`date_created` TIMESTAMP NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `fk_reviews_task_id`
		FOREIGN KEY (`task_id`)
		REFERENCES `TaskForce`.`task` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT `fk_reviews_customer_id`
		FOREIGN KEY (`customer_id`)
		REFERENCES `TaskForce`.`user` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT `fk_reviews_implementer_id`
		FOREIGN KEY (`implementer_id`)
		REFERENCES `TaskForce`.`user` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TaskForce`.`specialization` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT UNSIGNED NOT NULL,
	`category_id` INT UNSIGNED NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `fk_specialization_user_id`
		FOREIGN KEY (`user_id`)
		REFERENCES `TaskForce`.`user` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT `fk_specialization_category_id`
		FOREIGN KEY (`category_id`)
		REFERENCES `TaskForce`.`category` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE)
ENGINE = InnoDB;
