CREATE SCHEMA IF NOT EXISTS `logistic` DEFAULT CHARACTER SET latin1; 

CREATE TABLE IF NOT EXISTS `logistic`.`login` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `usertype` VARCHAR(45) NOT NULL,
  `lastattempt` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'User credent info';

CREATE TABLE IF NOT EXISTS `logistic`.`depot` (
  `depotNo` INT(11) NOT NULL AUTO_INCREMENT,
  `depotName` VARCHAR(45) NOT NULL,
  `depotLocation` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`depotNo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Depot info';


CREATE TABLE IF NOT EXISTS `logistic`.`carType` (
  `carTypeId` INT(11) NOT NULL AUTO_INCREMENT,
  `carTypeName` VARCHAR(45) NOT NULL,
  `x_dimen` DOUBLE NULL DEFAULT NULL,
  `y_dimen` DOUBLE NULL DEFAULT NULL,
  `z_dimen` DOUBLE NULL DEFAULT NULL,
  `max_weight` DOUBLE NULL DEFAULT NULL,
  PRIMARY KEY (`carTypeId`),
  UNIQUE INDEX `carTypeName_UNIQUE` (`carTypeName` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'car type info';

CREATE TABLE IF NOT EXISTS `logistic`.`car` (
  `carId` INT(11) NOT NULL AUTO_INCREMENT,
  `carName` VARCHAR(45) NULL DEFAULT NULL,
  `carType` INT(11) NOT NULL,
  PRIMARY KEY (`carId`),
  UNIQUE INDEX `carName_UNIQUE` (`carName` ASC),
  INDEX `carType_idx` (`carType` ASC),
  CONSTRAINT `carType`
    FOREIGN KEY (`carType`)
    REFERENCES `logistic`.`carType` (`carTypeId`)
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'database of current car in company';

CREATE TABLE IF NOT EXISTS `logistic`.`route` (
  `routeId` INT(11) NOT NULL AUTO_INCREMENT,
  `status` VARCHAR(45) NOT NULL DEFAULT 'incomplete',
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `carId` INT(11) NOT NULL,
  PRIMARY KEY (`routeId`),
  INDEX `carId_idx` (`carId` ASC),
  CONSTRAINT `carId`
    FOREIGN KEY (`carId`)
    REFERENCES `logistic`.`car` (`carId`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'route info';

CREATE TABLE IF NOT EXISTS `logistic`.`customer` (
  `customerId` INT(11) NOT NULL AUTO_INCREMENT,
  `customerName` VARCHAR(45) NOT NULL,
  `contactDetail` VARCHAR(45) NULL DEFAULT NULL,
  `otherInfo` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`customerId`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'customer info';

CREATE TABLE IF NOT EXISTS `logistic`.`transaction` (
  `transactionId` INT(11) NOT NULL AUTO_INCREMENT,
  `customerId` INT(11) NOT NULL,
  `latlong` VARCHAR(45) NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  `routeId` INT(11) NOT NULL,
  `createDate` TIMESTAMP NULL DEFAULT NULL,
  `statusDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transactionId`),
  UNIQUE INDEX `transactionId_UNIQUE` (`transactionId` ASC),
  INDEX `customerId_idx` (`customerId` ASC),
  INDEX `routeId_idx` (`routeId` ASC),
  CONSTRAINT `customerId`
    FOREIGN KEY (`customerId`)
    REFERENCES `logistic`.`customer` (`customerId`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `routeId`
    FOREIGN KEY (`routeId`)
    REFERENCES `logistic`.`route` (`routeId`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Info of transaction';

CREATE TABLE IF NOT EXISTS `logistic`.`package` (
  `packageId` INT(11) NOT NULL AUTO_INCREMENT,
  `pkgName` VARCHAR(45) NOT NULL,
  `pkgXDimen` DOUBLE NOT NULL,
  `pkgYDimen` DOUBLE NOT NULL,
  `pkgZDimen` DOUBLE NOT NULL,
  `pkgWeight` DOUBLE NOT NULL,
  PRIMARY KEY (`packageId`),
  UNIQUE INDEX `pkgName_UNIQUE` (`pkgName` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'type of package in database';

CREATE TABLE IF NOT EXISTS `logistic`.`transactionGood` (
  `tgId` INT(11) NOT NULL AUTO_INCREMENT,
  `transactionId` INT(11) NOT NULL,
  `pkgId` INT(11) NOT NULL,
  `qty` INT(11) NOT NULL,
  PRIMARY KEY (`tgId`),
  UNIQUE INDEX `tgId_UNIQUE` (`tgId` ASC),
  INDEX `transactionId_idx` (`transactionId` ASC),
  INDEX `pkgId_idx` (`pkgId` ASC),
  CONSTRAINT `transactionId`
    FOREIGN KEY (`transactionId`)
    REFERENCES `logistic`.`transaction` (`transactionId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `pkgId`
    FOREIGN KEY (`pkgId`)
    REFERENCES `logistic`.`package` (`packageId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'info of good of every transaction';