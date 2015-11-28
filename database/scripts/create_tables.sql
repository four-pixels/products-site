-- -----------------------------------------------------
-- Table shopping.user
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shopping.user (
  id INT NOT NULL AUTO_INCREMENT,
  firstname VARCHAR(45) NOT NULL,
  lastname VARCHAR(45) NOT NULL,
  username VARCHAR(45) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(128) NOT NULL,
  PRIMARY KEY (id));

-- -----------------------------------------------------
-- Table shopping.product
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shopping.product (
  id INT NOT NULL AUTO_INCREMENT,
  productname VARCHAR(45) NOT NULL,
  description TEXT NOT NULL,
  price FLOAT NOT NULL,
  quatity INT NOT NULL,
  PRIMARY KEY (id));

-- -----------------------------------------------------
-- Table shopping.image
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS shopping.image (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(45) NOT NULL,
  featured TINYINT(1) NOT NULL DEFAULT 0,
  path VARCHAR(255) NOT NULL,
  product_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX fk_image_product1_idx (product_id ASC),
  CONSTRAINT fk_image_product1
    FOREIGN KEY (product_id)
    REFERENCES shopping.product (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


