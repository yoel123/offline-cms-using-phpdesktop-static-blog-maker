<?php
/*
define("DB_NAME","yblog");//database name
define("DB_USER", "root");//database username
define("DB_PASSWORD", "");//database password
define("DB_HOST", "localhost");//database host name
define("DB_PORT", "33063");//database port (if you dont need leave empty)
*/
//tables stracture
$tables_struct = <<< SQL
CREATE TABLE IF NOT EXISTS `cats` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT,
	`name` VARCHAR
);
CREATE TABLE IF NOT EXISTS `post` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT,
	`title` VARCHAR(300),
	`date` VARCHAR(300),
	`content` BLOB,
	`cats_ids` VARCHAR(2000)
);

CREATE TABLE IF NOT EXISTS "tst" (
	"id"	INTEGER,
	"name"	TEXT,
	"date"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT)
);


CREATE TABLE IF NOT EXISTS "settings" (
	`id`	INTEGER,
	`name`	TEXT,
	`value`	TEXT,
	PRIMARY KEY(`id` AUTOINCREMENT)
);




ALTER DATABASE post CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER DATABASE cats CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER DATABASE settings CHARACTER SET utf8 COLLATE utf8_general_ci;

SQL;

//call database object
global $PDO;
$PDO = new PDO("sqlite:sqlite.db", "", "");
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$PDO->query($tables_struct);


?>