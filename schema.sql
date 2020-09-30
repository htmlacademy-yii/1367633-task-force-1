--
-- База данных: `TaskForce`
--
CREATE DATABASE IF NOT EXISTS `TaskForce` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `TaskForce`;

CREATE TABLE IF NOT EXISTS `category` ( 
  `id` int(11) unsigned not null auto_increment,
  `name` varchar(255) not null,
  PRIMARY KEY (`id`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`id`) REFERENCES `task` (`category_id`)
);

CREATE TABLE IF NOT EXISTS `chat` ( 
  `id` int(11) not null auto_increment,
  `customer_id` int(11) unsigned not null,
  `implementer_id` int(11) unsigned not null,
  `task_id` int(11) unsigned not null,
  `message` text not null,
  `date_created` timestamp not null default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
);

CREATE TABLE IF NOT EXISTS `city` ( 
  `id` int(11) unsigned not null auto_increment,
  `city` varchar(255) not null,
  `longitude` decimal(10,7) not null,
  `latitude` decimal(10,7) not null,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `favorite` ( 
  `id` int(11) not null auto_increment,
  `user_id` int(11) unsigned not null,
  `favorite_id` int(11) unsigned not null,
  PRIMARY KEY (`id`),
  CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE IF NOT EXISTS `file` ( 
  `id` int(11) not null auto_increment,
  `task_id` int(11) unsigned not null,
  `file` text not null,
  PRIMARY KEY (`id`),
  CONSTRAINT `file_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
);

CREATE TABLE IF NOT EXISTS `notification` ( 
  `id` int(11) not null auto_increment,
  `user_id` int(11) unsigned not null,
  `new_message` tinyint(1) unsigned not null,
  `actions_task` tinyint(1) unsigned not null,
  `new_review` tinyint(1) unsigned not null,
  `show_contacts` tinyint(1) unsigned not null,
  `now_show_profile` tinyint(1) unsigned not null,
  PRIMARY KEY (`id`),
  CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE IF NOT EXISTS `response` ( 
  `id` int(11) not null auto_increment,
  `task_id` int(11) unsigned not null,
  `implementer_id` int(11) unsigned not null,
  `description` text not null,
  `price` int(11) unsigned null,
  `date_created` timestamp not null default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `response_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
);

CREATE TABLE IF NOT EXISTS `reviews` ( 
  `id` int(11) not null auto_increment,
  `customer_id` int(11) unsigned not null,
  `implementer_id` int(11) unsigned not null,
  `task_id` int(11) unsigned not null,
  `message` text not null,
  `rate` tinyint(3) not null,
  `date_created` timestamp not null default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
);

CREATE TABLE IF NOT EXISTS `specialisation` ( 
  `id` int(11) not null auto_increment,
  `user_id` int(11) unsigned not null,
  `category_id` int(11) unsigned not null,
  PRIMARY KEY (`id`),
  CONSTRAINT `specialisation_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
CONSTRAINT `specialisation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE IF NOT EXISTS `task` ( 
  `id` int(11) unsigned not null auto_increment,
  `customer_id` int(11) unsigned not null,
  `implementer_id` int(11) unsigned not null,
  `category_id` int(11) unsigned not null,
  `city_id` int(11) unsigned not null,
  `address` varchar(255) not null,
  `status` enum('new','processing','performed','failed','canceled') not null default new,
  `title` varchar(255) not null,
  `description` text not null,
  `budget` int(11) not null,
  `longitude` decimal(10,7) not null,
  `latitude` decimal(10,7) not null,
  `end_date` timestamp not null default CURRENT_TIMESTAMP,
  `date_created` timestamp not null default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `task_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`)
CONSTRAINT `task_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
);

CREATE TABLE IF NOT EXISTS `user` ( 
  `id` int(11) unsigned not null auto_increment,
  `name` varchar(255) not null,
  `email` varchar(255) not null,
  `password` varchar(255) not null,
  `city_id` int(11) unsigned not null,
  `longitude` decimal(10,7) not null,
  `latitude` decimal(10,7) not null,
  `role` enum('customer','implementer') not null default customer,
  `birthday` date not null,
  `about` text not null,
  `phone` varchar(255) not null,
  `skype` varchar(255) not null,
  `telegram` varchar(255) not null,
  `photo` varchar(255) not null,
  `rate` tinyint(3) unsigned not null,
  `views` int(11) not null,
  `last_active` timestamp not null default CURRENT_TIMESTAMP,
  `date_created` timestamp not null default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`)
);