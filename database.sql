SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `phone_02` varchar(15),
  `email` varchar(255) NOT NULL DEFAULT '',
  `created` date NOT NULL,
  `ip` varchar(100) NOT NULL DEFAULT '0',
  `group` int NOT NULL DEFAULT '0',
  `emailActive` tinyint,
  `emailCode` varchar(255) NOT NULL DEFAULT 0,
  `emailCodeDate` datetime,
  `phoneActive` tinyint,
  `phoneCode` varchar(255) NOT NULL DEFAULT 0,
  `phoneCodeDate` datetime,
  `status` tinyint NOT NULL DEFAULT '1',
  `inviteCode` varchar(255),
  UNIQUE KEY `username` (`username`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `accounts` (`id`, `username`, `password`, `phone`, `phone_02`, `email`, `created`, `ip`, `group`, `status`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '11994489463', '', 'admin@gmail.com', '2000-01-01', '0', 5, 1);


CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `cpf` varchar(255) NOT NULL,
  `rg` varchar(255),
  `gender` varchar(1),
  `street` varchar(100),
  `district` varchar(100),
  `number` smallint,
  `complement` varchar(50),
  `cep` varchar(15),
  `city` varchar(100),
  `uf` varchar(5),
  `nacionality` varchar(100),
  UNIQUE KEY `documents` (`cpf`, `rg`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `account_id`, `first_name`, `last_name`, `birth_date`, `cpf`, `rg`, `gender`, `street`, `district`, `number`, `complement`, `cep`, `city`, `uf`, `nacionality`) VALUES (1, 1, 'Administrator', 'of System', '1999-03-31', '00000000000', '000000000', 'M', 'Rua', 'Bairro', 0, 'Casa', '00000000', 'Cidade', 'UF', 'BRASILEIRO');

CREATE TABLE `queries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` tinyint NOT NULL,
  `value01` varchar(255) NOT NULL,
  `value02` varchar(255) NOT NULL,
  `pay_type` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `ip` varchar(100) NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '2',
  `assigned` int,
  `assigned_date` date,
  `assigned_time` time,
  `answered_date` date,
  `answered_time` time,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `queries_logs` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` tinyint NOT NULL,
  `value01` varchar(255) NOT NULL,
  `value02` varchar(255) NOT NULL,
  `pay_type` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `ip` varchar(100) NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL,
  `assigned` int NOT NULL,
  `assigned_date` date NOT NULL,
  `assigned_time` time NOT NULL,
  `queryEnd_date` date NOT NULL,
  `queryEnd_time` time NOT NULL,
  `queryEnd_user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `queries_edit_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `querie_id` int NOT NULL,
  `status_old` tinyint NOT NULL,
  `status_new` tinyint NOT NULL,
  `responsible_id` int NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `ip` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `packages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `description` varchar(255),
  `reward_value` int NOT NULL,
  `cost` float(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `packages` (`name`, `description`, `reward_value`, `cost`) VALUES ('Pacote Bronze', '', 5, 50.00);
INSERT INTO `packages` (`name`, `description`, `reward_value`, `cost`) VALUES ('Pacote Silver', '', 15, 100.00);
INSERT INTO `packages` (`name`, `description`, `reward_value`, `cost`) VALUES ('Pacote Gold', '', 30, 150.00);

CREATE TABLE `contracted_pack` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pack_id` int NOT NULL,
  `value` int NOT NULL,
  `cost` float(5,2) NOT NULL,
  `cost_real` float(5,2) NOT NULL,
  `discount_applied` float(5,2) NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `ip` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `contracted_pack_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pack_id` int NOT NULL,
  `value` int NOT NULL,
  `cost` float(5,2) NOT NULL,
  `cost_real` float(5,2) NOT NULL,
  `discount_applied` float(5,2) NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `ip` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `devolution_pack` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `responsible_id` int NOT NULL,
  `pack_id` int NOT NULL,
  `cost` float NOT NULL,
  `cost_real` float NOT NULL,
  `discount_applied` int NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `ip` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `credits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255),
  `quantity` int NOT NULL,
  `cost` float(5,2) NOT NULL,
  `discount` int,
  `discount_dateStart` date,
  `discount_timeStart` time,
  `discount_dateEnd` date,
  `discount_timeEnd` time,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `credits` (`name`, `description`, `quantity`, `cost`) VALUES 
('QDCoins 10', 'Comprando esse pacote, você recebera 10 QDCoins', 10, 1.00),
('QDCoins 50', 'Comprando esse pacote, você recebera 50 QDCoins', 50, 1.00),
('QDCoins 100', 'Comprando esse pacote, você recebera 100 QDCoins', 100, 1.00),
('QDCoins 150', 'Comprando esse pacote, você recebera 150 QDCoins', 150, 1.00),
('QDCoins 250', 'Comprando esse pacote, você recebera 250 QDCoins', 250, 1.00);


CREATE TABLE `credits_sold` (
  `id` int NOT NULL AUTO_INCREMENT,
  `credit_id` int NOT NULL,
  `user_id` int NOT NULL,
  `purchase_uid` int NOT NULL,
  `method_payment` VARCHAR(255) NOT NULL,
  `created_dateTime` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `status_dateTime` datetime,
  `status_dateTimeExpiration` datetime,
  `ip_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` tinyint NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `value` int NOT NULL,
  `status` int NOT NULL default 2,
  `ip` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `users_credit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `value` float(5,2) NOT NULL,
  `status` int NOT NULL default 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users_credit_historic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `users_credit_id` int NOT NULL,
  `value_old` float(5,2) NOT NULL,
  `value_new` float(5,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` int NOT NULL default 2,
  `responsible_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `siteVisits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL,
  `time` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `usersCode` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Índices
--

  
ALTER TABLE `credits_sold` 
  ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  ADD FOREIGN KEY (`credit_id`) REFERENCES `credits`(`id`);


--
-- FOREIGN KEY
--
ALTER TABLE `users` 
  ADD FOREIGN KEY (`account_id`) REFERENCES `accounts`(`id`);

ALTER TABLE `usersCode` 
  ADD FOREIGN KEY (`account_id`) REFERENCES `accounts`(`id`);

ALTER TABLE `queries` 
  ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  ADD FOREIGN KEY (`assigned`) REFERENCES `users`(`id`);

ALTER TABLE `queries_logs` 
  ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  ADD FOREIGN KEY (`queryEnd_user_id`) REFERENCES `users`(`id`),
  ADD FOREIGN KEY (`assigned`) REFERENCES `users`(`id`);

ALTER TABLE `queries_edit_logs` 
  ADD FOREIGN KEY (`querie_id`) REFERENCES `queries`(`id`),
  ADD FOREIGN KEY (`responsible_id`) REFERENCES `users`(`id`);

ALTER TABLE `contracted_pack` 
  ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  ADD FOREIGN KEY (`pack_id`) REFERENCES `packages`(`id`);


ALTER TABLE `devolution_pack` 
  ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  ADD FOREIGN KEY (`responsible_id`) REFERENCES `users`(`id`),
  ADD FOREIGN KEY (`pack_id`) REFERENCES `packages`(`id`);

ALTER TABLE `payments` 
  ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `users_credit` 
  ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `users_credit_historic` 
  ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  ADD FOREIGN KEY (`users_credit_id`) REFERENCES `users_credit`(`id`);



