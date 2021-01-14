# LANDING PAGE V2 : 

## Mysql Database : 
You can change the database config in /backend/config.php

You need to create database and table user before start the prg :

CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  `type` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `birth` DATETIME NULL,
  `phone` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  `IP` VARCHAR(45) NULL,
  `creatAt` DATETIME NULL,
  `update` DATETIME NULL,
  `counter` INT NULL,
  PRIMARY KEY (`id`));
