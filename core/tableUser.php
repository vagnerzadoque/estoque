USE `_database-here_` ;

-- -----------------------------------------------------
-- Table `_database-here_`.`_prefix-here_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `_database-here_`.`_prefix-here_users` (
  `id` INT AUTO_INCREMENT,
  `email` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `name` VARCHAR(15) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `familyName` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `password` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `home` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `profile` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `photo` VARCHAR(150) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `sessionID` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `active` INT(1) NOT NULL,
  `changePassword` INT(1) NOT NULL,
  `creationDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `loginDate` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `sessionID_UNIQUE` (`sessionID` ASC))
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8;