<?php
require_once('.config.php');

$mysqli = new mysqli($config['dbHostname'], $config['dbUser'], $config['dbPassword']);

$mysqli->query("CREATE DATABASE `{$config['dbName']}` IF NOT EXISTS /*!40100 DEFAULT CHARACTER SET utf8 */");


$mysqli->query("CREATE TABLE {$config['dbName']}.`tv_series` IF NOT EXISTS (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `episode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");