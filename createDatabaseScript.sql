/*
Script to create all the table in the database needed for the BrightSolid project

TODO

*1  -   Need to figure out what datatype to use for the timestampz datatype
*2  -   Need to figure out what datatype "last_updated_by" is supposed to be currently set to int but could possibly be varchar
*3  -   Need to ask client if this is a nessary variable, a primary key will need to be created in the "non_complience" table
*4  -   Need to check datatype, longblob is usually large enough, however there might be a better datatype to use

*/

-- **********************************************************************

DROP DATABASE IF EXISTS `jamiefergusdb`;

CREATE DATABASE `jamiefergusdb`;

USE `jamiefergusdb`;

-- **********************************************************************

CREATE TABLE platform(
	platform_id int NOT NULL AUTO_INCREMENT,
    platform_name varchar(255) NOT NULL,
    PRIMARY KEY(platform_id)
);

CREATE TABLE customer(
	customer_id int NOT NULL AUTO_INCREMENT,
    customer_name varchar(255) NOT NULL
    PRIMARY KEY(customer_id)
);

CREATE TABLE user_role(
	user_role_id int NOT NULL AUTO_INCREMENT,
    user_role_name varchar(255) NOT NULL
    PRIMARY KEY (user_role_id)
);

CREATE TABLE resource_type(
	resource_type_id int NOT NULL AUTO_INCREMENT,
    resource_type_name varchar(255) NOT NULL,
    platform_id int NOT NULL,
    PRIMARY KEY (resource_type_id),
    FOREIGN KEY (platform_id) REFERENCES platform(platform_id)
);

CREATE TABLE account(
	account_id int NOT NULL AUTO_INCREMENT,
    account_ref varchar(255) NOT NULL,
    platform_id int NOT NULL,
    customer_id int NOT NULL,
    PRIMARY KEY (account_id),
    FOREIGN KEY (platform_id) REFERENCES platform(platform_id),
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
);

CREATE TABLE user(
	user_id int NOT NULL AUTO_INCREMENT,
    user_name varchar(255) NOT NULL,
    customer_id int NOT NULL,
    role_id int NOT NULL,
    PRIMARY KEY (user_id),
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id),
    FOREIGN KEY (role_id) REFERENCES user_role(user_role_id)
);

CREATE TABLE resource(
	resource_id int NOT NULL AUTO_INCREMENT,
    resource_ref varchar(255) NOT NULL,
    account_id int NOT NULL,
    resource_type_id int NOT NULL,
    resource_name varchar(255) NOT NULL,
    last_updated varchar(255) NOT NULL,			                                    /*  *1  */
    resource_metadata longblob NOT NULL,		                                    /*  *4  */
    PRIMARY KEY (resource_id),
    FOREIGN KEY (account_id) REFERENCES account(account_id),
    FOREIGN KEY (resource_type_id) REFERENCES resource_type(resource_type_id)
);

 CREATE TABLE rule(
	rule_id int NOT NULL AUTO_INCREMENT,
    rule_name varchar(255) NOT NULL,
    resource_type_id int NOT NULL,
    rule_description varchar(255) NOT NULL,
    PRIMARY KEY (rule_id),
    FOREIGN KEY (resource_type_id) REFERENCES resource_type(resource_type_id)
);

CREATE TABLE non_complience_audit(
	non_complience_audit_id int NOT NULL AUTO_INCREMENT,
    non_complience_id int NOT NULL,                                             /*  *3  */
    resource_id int NOT NULL,
    rule_id int NOT NULL,
    user_id int NOT NULL,
    action varchar(255) NOT NULL,
    action_dt varchar(255) NOT NULL,			                                    /*  *1  */
    PRIMARY KEY (non_complience_audit_id),
    FOREIGN KEY (resource_id) REFERENCES resource(resource_id),
    FOREIGN KEY (rule_id) REFERENCES rule(rule_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE exception(
	exception_id int NOT NULL AUTO_INCREMENT,
    customer_id int NOT NULL,
    rule_id int NOT NULL,
    last_updated_by int NOT NULL,                                                   /*  *2  */
    exception_value varchar(255) NOT NULL,
    justification varchar(255) NOT NULL,
    review_date varchar(255) NOT NULL,                                              /*  *1  */
    last_updated varchar(255) NOT NULL,                                             /*  *1  */
    PRIMARY KEY(exception_id),
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id),
    FOREIGN KEY (rule_id) REFERENCES rule(rule_id),
    FOREIGN KEY (last_updated_by) REFERENCES user(user_id)
);

CREATE TABLE exception_audit(
	exception_audit_id int NOT NULL AUTO_INCREMENT,
    exception_id int NOT NULL,
    user_id int NOT NULL,
    customer_id int NOT NULL,
    rule_id int NOT NULL,
    action_dt varchar(255) NOT NULL,                                                /*  *1  */
    old_exception_value varchar(255) NOT NULL,
    new_exception_value varchar(255) NOT NULL,
    old_justification varchar(255) NOT NULL,
    new_justification varchar(255) NOT NULL,
    old_review_time varchar(255) NOT NULL,                                          /*  *1  */
    new_review_time varchar(255) NOT NULL,                                          /*  *1  */
    PRIMARY KEY(exception_audit_id),
    FOREIGN KEY (exception_id) REFERENCES exception(exception_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id),
    FOREIGN KEY (rule_id) REFERENCES rule(rule_id)
);

CREATE TABLE non_compliance(
    resource_id int NOT NULL,
    rule_id int NOT NULL,
    FOREIGN KEY (resource_id) REFERENCES resource(resource_id),
    FOREIGN KEY (rule_id) REFERENCES rule(rule_id)
);
