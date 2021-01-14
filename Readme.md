##Create TABLE SQL
CREATE TABLE `gpbl`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `phone` VARCHAR(45) NULL,
  `date` DATETIME NULL,
  `ip` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));