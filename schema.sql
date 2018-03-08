DROP DATABASE IF EXISTS yeticave;

SET SQL_MODE = 'ALLOW_INVALID_DATES';

CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id    INT AUTO_INCREMENT,
  name  CHAR(66),
  alias CHAR(66),
  PRIMARY KEY (id)
);

CREATE TABLE users (
  id                INT       AUTO_INCREMENT,
  email             CHAR(128),
  name              CHAR(66),
  registration_date DATETIME,
  password          CHAR(64),
  avatar            CHAR(100),
  contacts          TINYTEXT,
  PRIMARY KEY (id),
  UNIQUE KEY (email)
);

CREATE TABLE lots (
  id              INT       AUTO_INCREMENT,
  name            CHAR(66),
  description     TINYTEXT,
  image_url       CHAR(100),
  starting_price  INT UNSIGNED,
  rate_step       INT UNSIGNED,
  creation_date   DATETIME,
  completion_date DATETIME,
  category_id     INT,
  winner_id       INT,
  author_id       INT,
  PRIMARY KEY (id),
  FOREIGN KEY (category_id)
  REFERENCES categories (id),
  FOREIGN KEY (winner_id)
  REFERENCES users (id),
  FOREIGN KEY (author_id)
  REFERENCES users (id),
  INDEX (category_id),
  INDEX (winner_id),
  INDEX (author_id),
  FULLTEXT (name, description)
);

CREATE TABLE rates (
  id             INT       AUTO_INCREMENT,
  placement_date DATETIME,
  amount         INT UNSIGNED,
  user_id        INT,
  lot_id         INT,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id)
  REFERENCES users (id),
  FOREIGN KEY (lot_id)
  REFERENCES lots (id),
  INDEX (user_id),
  INDEX (lot_id)
);

