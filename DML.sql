CREATE DATABASE paragka
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
  
USE paragka;

CREATE TABLE users (
     id MEDIUMINT NOT NULL AUTO_INCREMENT,
     email VARCHAR(50) NOT NULL,
	 hashCode VARCHAR(32) NOT NULL,
	 pwd VARCHAR(32) NOT NULL,
	 lastname VARCHAR(50) NOT NULL,
	 firstname VARCHAR(50) NOT NULL,
	 phoneNo VARCHAR(10),
	 active SMALLINT NOT NULL,
	 role SMALLINT NOT NULL,
     PRIMARY KEY (id)
);

CREATE TABLE players (
     id MEDIUMINT NOT NULL AUTO_INCREMENT,
     email VARCHAR(50) NOT NULL,
	 hashCode VARCHAR(32) NOT NULL,
	 lastname VARCHAR(50) NOT NULL,
	 firstname VARCHAR(50) NOT NULL,
	 phoneNo VARCHAR(10),
	 active SMALLINT NOT NULL,
     PRIMARY KEY (id)
);