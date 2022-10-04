LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/account.csv'
INTO TABLE account
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/customer.csv'
INTO TABLE customer
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/exception.csv'
INTO TABLE exception
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/exception_audit.csv'
INTO TABLE exception_audit
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/non_compliance.csv'
INTO TABLE non_compliance
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/non_compliance_audit.csv'
INTO TABLE non_compliance_audit
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/platform.csv'
INTO TABLE platform
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/resource.csv'
INTO TABLE resource
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/resource_type.csv'
INTO TABLE resource_type
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/rule.csv'
INTO TABLE rule
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/user.csv'
INTO TABLE user
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'u:/"Industrial Team Project"/Inputs/user_role.csv'
INTO TABLE user_role
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

