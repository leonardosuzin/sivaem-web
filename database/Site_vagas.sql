create database Site_vagas;

use Site_vagas;

CREATE TABLE `usuario` (
 `user_id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(255) NOT NULL,
 `password` varchar(255) NOT NULL,
 `tipo_usuario` smallint(1) NOT NULL,
 PRIMARY KEY (`user_id`)
);

CREATE TABLE `vaga` (
 `vaga_id` int(11) NOT NULL AUTO_INCREMENT,
 `descricao` varchar(255) DEFAULT NULL,
 `cargo` varchar(255) DEFAULT NULL,
 `salario` double(10,2) DEFAULT NULL,
 PRIMARY KEY (`vaga_id`)
);

CREATE TABLE `curriculo` (
 `curriculo_id` int(11) NOT NULL AUTO_INCREMENT,
 `descricao` varchar(255) DEFAULT NULL,
 `cargo` varchar(255) DEFAULT NULL,
 `experiencia` varchar(255) DEFAULT NULL,
 `salario` double(10,2) DEFAULT NULL,
 PRIMARY KEY (`curriculo_id`)
);
