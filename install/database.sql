-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema db_workshow
-- -----------------------------------------------------
-- ฐานข้อมูลตัวอย่างในการสอน

-- -----------------------------------------------------
-- Schema db_workshow
--
-- ฐานข้อมูลตัวอย่างในการสอน
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_workshow` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `db_workshow` ;

-- -----------------------------------------------------
-- Table `db_workshow`.`{prefix}_work`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_workshow`.`{prefix}_work` (
  `id` INT(2) NOT NULL AUTO_INCREMENT COMMENT '',
  `title` VARCHAR(100) NOT NULL COMMENT '',
  `description` TEXT NOT NULL COMMENT '',
  `fname` VARCHAR(30) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;

--
-- dump ตาราง `{prefix}_01work`
--

INSERT INTO `{prefix}_work` (`id`, `title`, `description`, `fname`) VALUES
(1, 'การเขียนเว็บไซต์', 'ให้นักเรียนนักศึกษาดูจากตัวอย่างที่อาจารย์สอนให้เป็นแบบอย่างในการทำงานต่อไป', 'อ.คำภี');

-- -----------------------------------------------------
-- Table `db_workshow`.`{prefix}_title`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_workshow`.`{prefix}_title` (
  `id` INT(2) NOT NULL AUTO_INCREMENT COMMENT '',
  `title` VARCHAR(6) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_workshow`.`{prefix}_member`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_workshow`.`{prefix}_member` (
  `id` INT(2) NOT NULL AUTO_INCREMENT COMMENT '',
  `title_id` INT(2) NOT NULL COMMENT '',
  `lname` VARCHAR(30) NOT NULL COMMENT '',
  `fname` VARCHAR(30) NOT NULL COMMENT '',
  `email` VARCHAR(30) NOT NULL COMMENT '',
  `tel` VARCHAR(20) NOT NULL COMMENT '',
  `address` TEXT NOT NULL COMMENT '',
  `u_name` VARCHAR(20) NOT NULL COMMENT '',
  `u_pass` VARCHAR(45) NOT NULL COMMENT '',
  `type` ENUM('admin', 'user') NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_{prefix}_member_{prefix}_title_idx` (`title_id` ASC)  COMMENT '',
  CONSTRAINT `fk_{prefix}_member_{prefix}_title`
    FOREIGN KEY (`title_id`)
    REFERENCES `db_workshow`.`{prefix}_title` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_workshow`.`{prefix}_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_workshow`.`{prefix}_type` (
  `id` INT(2) NOT NULL AUTO_INCREMENT COMMENT '',
  `typename` VARCHAR(20) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_workshow`.`{prefix}_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_workshow`.`{prefix}_product` (
  `id` INT(2) NOT NULL AUTO_INCREMENT COMMENT '',
  `code` VARCHAR(5) NOT NULL COMMENT '',
  `proname` VARCHAR(50) NOT NULL COMMENT '',
  `detail` TEXT NOT NULL COMMENT '',
  `price` FLOAT NOT NULL COMMENT '',
  `bal` INT(10) NOT NULL COMMENT '',
  `type_id` INT(2) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_{prefix}_product_{prefix}_type1_idx` (`type_id` ASC)  COMMENT '',
  CONSTRAINT `fk_{prefix}_product_{prefix}_type1`
    FOREIGN KEY (`type_id`)
    REFERENCES `db_workshow`.`{prefix}_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
