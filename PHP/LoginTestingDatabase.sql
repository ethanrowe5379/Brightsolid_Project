DROP DATABASE IF EXISTS `appusers`;
CREATE DATABASE `appusers`;
USE `appusers`;

SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `user_role`(
	user_role_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_role_name varchar(255) NOT NULL
);

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` (`user_role_name`)
VALUES
    ('Manager'),
    ('Auditor');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

CREATE TABLE `user`(
	user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_name varchar(255) NOT NULL,
    customer_id int NOT NULL,
    role_id int NOT NULL,
    user_password varchar(255) NOT NULL,

    FOREIGN KEY (role_id) REFERENCES user_role(user_role_id)
);

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_name`,`customer_id`,`role_id`, `user_password`)
VALUES
    ('User1', 123, 1,'7833dc6e82e9378117bcb03128ac8fdd95d9073161ebc963783b3010dd847ff3'),
    ('User2', 234, 2,'8d71292c2d52e804d6e43412655bf3ec8020354446913b30e0813baaf675651e');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;