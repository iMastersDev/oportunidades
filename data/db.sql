CREATE DATABASE IF NOT EXISTS`ophportunidades`;

use `ophportunidades`;

CREATE TABLE IF NOT EXISTS `position`(
	id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	title VARCHAR(155),
	description TEXT,
	place VARCHAR(255)
);