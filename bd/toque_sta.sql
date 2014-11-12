SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `toque_sta` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `toque_sta` ;

-- -----------------------------------------------------
-- Table `toque_sta`.`client`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`client` (
  `id_client` INT NOT NULL AUTO_INCREMENT ,
  `cliName` VARCHAR(250) NOT NULL ,
  `cliAdress` VARCHAR(250) NOT NULL ,
  `cliPostalCode` INT NOT NULL ,
  `cliPostalSuffix` INT NOT NULL ,
  `cliDoorNum` INT NOT NULL ,
  `cliCC` INT NULL ,
  `cliNIF` INT NULL ,
  `cliConFix` INT NOT NULL ,
  `cliConMov1` INT NOT NULL ,
  `cliConMov2` INT NULL ,
  `cliBirthday` DATE NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id_client`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`repair_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`repair_type` (
  `id_type` INT NOT NULL AUTO_INCREMENT ,
  `typeDesc` VARCHAR(250) NOT NULL ,
  `extraData` INT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id_type`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`groups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`groups` (
  `id_group` INT NOT NULL AUTO_INCREMENT ,
  `groupType` TEXT NOT NULL ,
  PRIMARY KEY (`id_group`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`user` (
  `id_users` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `password_hash` VARCHAR(250) NOT NULL ,
  `group_id` INT NOT NULL ,
  `password_reset_token` VARCHAR(250) NULL ,
  `status` INT NULL DEFAULT 1 ,
  `auth_key` VARCHAR(250) NOT NULL ,
  `role` INT NOT NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  INDEX `fk_users_groups1` (`group_id` ASC) ,
  PRIMARY KEY (`id_users`) ,
  CONSTRAINT `fk_users_groups1`
    FOREIGN KEY (`group_id` )
    REFERENCES `toque_sta`.`groups` (`id_group` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`equipaments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`equipaments` (
  `id_equip` INT NOT NULL AUTO_INCREMENT ,
  `equipDesc` TEXT NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id_equip`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`brands`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`brands` (
  `id_brand` INT NOT NULL AUTO_INCREMENT ,
  `brandName` TEXT NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id_brand`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`models`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`models` (
  `id_model` INT NOT NULL AUTO_INCREMENT ,
  `modelName` TEXT NOT NULL ,
  `brand_id` INT NOT NULL ,
  `equip_id` INT NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id_model`) ,
  INDEX `fk_models_brands1` (`brand_id` ASC) ,
  INDEX `fk_models_equipaments1` (`equip_id` ASC) ,
  CONSTRAINT `fk_models_brands1`
    FOREIGN KEY (`brand_id` )
    REFERENCES `toque_sta`.`brands` (`id_brand` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_models_equipaments1`
    FOREIGN KEY (`equip_id` )
    REFERENCES `toque_sta`.`equipaments` (`id_equip` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`inventory`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`inventory` (
  `id_inve` INT NOT NULL AUTO_INCREMENT ,
  `equip_id` INT NOT NULL ,
  `brand_id` INT NOT NULL ,
  `model_id` INT NOT NULL ,
  `inveSN` TEXT NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  INDEX `fk_inventory_equipaments1` (`equip_id` ASC) ,
  INDEX `fk_inventory_brands1` (`brand_id` ASC) ,
  INDEX `fk_inventory_models1` (`model_id` ASC) ,
  PRIMARY KEY (`id_inve`) ,
  CONSTRAINT `fk_inventory_equipaments1`
    FOREIGN KEY (`equip_id` )
    REFERENCES `toque_sta`.`equipaments` (`id_equip` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inventory_brands1`
    FOREIGN KEY (`brand_id` )
    REFERENCES `toque_sta`.`brands` (`id_brand` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inventory_models1`
    FOREIGN KEY (`model_id` )
    REFERENCES `toque_sta`.`models` (`id_model` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`stores`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`stores` (
  `id_store` INT NOT NULL AUTO_INCREMENT ,
  `storeDesc` TEXT NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id_store`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`status`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`status` (
  `id_status` INT NOT NULL AUTO_INCREMENT ,
  `statusDesc` VARCHAR(250) NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id_status`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`repair`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`repair` (
  `id_repair` INT NOT NULL AUTO_INCREMENT ,
  `type_id` INT NOT NULL ,
  `client_id` INT NOT NULL ,
  `inve_id` INT NOT NULL ,
  `status_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `repair_desc` TEXT NOT NULL ,
  `date_entry` DATETIME NOT NULL ,
  `date_close` INT NULL ,
  `store_id` INT NOT NULL ,
  `priority` INT NOT NULL ,
  `budget` DECIMAL NULL ,
  `maxBudget` DECIMAL NULL ,
  `total` DECIMAL NULL ,
  `obs` TEXT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id_repair`) ,
  INDEX `fk_repair_client` (`client_id` ASC) ,
  INDEX `fk_repair_repair_type1` (`type_id` ASC) ,
  INDEX `fk_repair_users1` (`user_id` ASC) ,
  INDEX `fk_repair_inventory1` (`inve_id` ASC) ,
  INDEX `fk_repair_stores1` (`store_id` ASC) ,
  INDEX `fk_repair_status1` (`status_id` ASC) ,
  CONSTRAINT `fk_repair_client`
    FOREIGN KEY (`client_id` )
    REFERENCES `toque_sta`.`client` (`id_client` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_repair_repair_type1`
    FOREIGN KEY (`type_id` )
    REFERENCES `toque_sta`.`repair_type` (`id_type` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_repair_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `toque_sta`.`user` (`id_users` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_repair_inventory1`
    FOREIGN KEY (`inve_id` )
    REFERENCES `toque_sta`.`inventory` (`id_inve` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_repair_stores1`
    FOREIGN KEY (`store_id` )
    REFERENCES `toque_sta`.`stores` (`id_store` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_repair_status1`
    FOREIGN KEY (`status_id` )
    REFERENCES `toque_sta`.`status` (`id_status` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`user_session`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`user_session` (
  `id_session` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `hash` VARCHAR(250) NOT NULL ,
  PRIMARY KEY (`id_session`) ,
  INDEX `fk_user_session_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_user_session_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `toque_sta`.`user` (`id_users` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`accessories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`accessories` (
  `id_accessories` INT NOT NULL AUTO_INCREMENT ,
  `accessDesc` VARCHAR(45) NOT NULL ,
  `accessType` INT NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id_accessories`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`repair_accessory`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`repair_accessory` (
  `repair_id` INT NOT NULL ,
  `accessory_id` INT NOT NULL ,
  `otherDesc` TEXT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`repair_id`, `accessory_id`) ,
  INDEX `fk_repair_accessory_repair1` (`repair_id` ASC) ,
  INDEX `fk_repair_accessory_accessories1` (`accessory_id` ASC) ,
  CONSTRAINT `fk_repair_accessory_repair1`
    FOREIGN KEY (`repair_id` )
    REFERENCES `toque_sta`.`repair` (`id_repair` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_repair_accessory_accessories1`
    FOREIGN KEY (`accessory_id` )
    REFERENCES `toque_sta`.`accessories` (`id_accessories` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`parts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`parts` (
  `id_part` INT NOT NULL AUTO_INCREMENT ,
  `partDesc` VARCHAR(250) NOT NULL ,
  `partCode` VARCHAR(250) NOT NULL ,
  `partPrice` DECIMAL NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  `partQuant` INT NULL ,
  PRIMARY KEY (`id_part`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`repair_parts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`repair_parts` (
  `repair_id` INT NOT NULL ,
  `part_id` INT NOT NULL ,
  `partQuant` INT NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`repair_id`, `part_id`) ,
  INDEX `fk_repair_parts_repair1` (`repair_id` ASC) ,
  INDEX `fk_repair_parts_parts1` (`part_id` ASC) ,
  CONSTRAINT `fk_repair_parts_repair1`
    FOREIGN KEY (`repair_id` )
    REFERENCES `toque_sta`.`repair` (`id_repair` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_repair_parts_parts1`
    FOREIGN KEY (`part_id` )
    REFERENCES `toque_sta`.`parts` (`id_part` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`modLog`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`modLog` (
  `id_log` INT NOT NULL AUTO_INCREMENT ,
  `logDate` DATETIME NOT NULL ,
  `logMessage` TEXT NOT NULL ,
  `logType` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `status` INT NOT NULL ,
  PRIMARY KEY (`id_log`) ,
  INDEX `fk_modLog_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_modLog_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `toque_sta`.`user` (`id_users` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`messages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`messages` (
  `id_message` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `messPriority` INT NULL ,
  `messMessage` TEXT NOT NULL ,
  `messDate` DATETIME NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id_message`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`users_messages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`users_messages` (
  `user_id` INT NOT NULL ,
  `message_id` INT NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`user_id`, `message_id`) ,
  INDEX `fk_users_messages_users1` (`user_id` ASC) ,
  INDEX `fk_users_messages_messages1` (`message_id` ASC) ,
  CONSTRAINT `fk_users_messages_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `toque_sta`.`user` (`id_users` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_messages_messages1`
    FOREIGN KEY (`message_id` )
    REFERENCES `toque_sta`.`messages` (`id_message` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toque_sta`.`equip_brand`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `toque_sta`.`equip_brand` (
  `equip_id` INT NOT NULL ,
  `brand_id` INT NOT NULL ,
  `status` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`equip_id`, `brand_id`) ,
  INDEX `fk_equip_brand_equipaments1` (`equip_id` ASC) ,
  INDEX `fk_equip_brand_brands1` (`brand_id` ASC) ,
  CONSTRAINT `fk_equip_brand_equipaments1`
    FOREIGN KEY (`equip_id` )
    REFERENCES `toque_sta`.`equipaments` (`id_equip` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equip_brand_brands1`
    FOREIGN KEY (`brand_id` )
    REFERENCES `toque_sta`.`brands` (`id_brand` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
