SET SQL_MODE='ALLOW_INVALID_DATES';

CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id   INT AUTO_INCREMENT,
  name CHAR(128),
  translation TINYTEXT,
  PRIMARY KEY (id)
);

CREATE TABLE users (
  id        INT AUTO_INCREMENT,
  email     CHAR(128),
  name      CHAR(66),
  registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  password  CHAR(64),
  avatar CHAR(100),
  contacts  TINYTEXT,
  PRIMARY KEY (id),
  UNIQUE KEY (email)
);

CREATE TABLE lots (
  id              INT AUTO_INCREMENT,
  name            CHAR(66),
  description     TINYTEXT,
  image_url       CHAR(100),
  starting_price  INT UNSIGNED,
  rate_step       INT UNSIGNED,
  creation_date   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  completion_date TIMESTAMP,
  category_id     INT,
  winner_id       INT,
  author_id       INT,
  PRIMARY KEY (id),
  FOREIGN KEY (category_id)
    REFERENCES categories (id),
  FOREIGN KEY (winner_id)
    REFERENCES users(id),
  FOREIGN KEY (author_id)
    REFERENCES users(id),
  INDEX (category_id),
  INDEX (winner_id),
  INDEX (author_id)
);

CREATE TABLE rates (
  id             INT AUTO_INCREMENT,
  placement_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  amount         INT UNSIGNED,
  user_id        INT,
  lot_id         INT,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id)
    REFERENCES users(id),
  FOREIGN KEY (lot_id)
    REFERENCES lots(id),
  INDEX (user_id),
  INDEX (lot_id)
);
