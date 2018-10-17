CREATE DATABASE comagaru;
USE comagaru;
CREATE TABLE users ( id smallint unsigned not null auto_increment, name varchar(20) not null, constraint pk_example primary key (id) );
-- INSERT INTO users ( id, name ) VALUES ( null, 'Sample data' );

mysql -u root -p
GRANT ALL PRIVILEGES ON *.* TO 'username'@'localhost' IDENTIFIED BY 'password';
\q


CREATE DATABASE dbname;
USE dbname;
CREATE TABLE tablename ( id smallint unsigned not null auto_increment, name varchar(20) not null, constraint pk_example primary key (id) );
INSERT INTO tablename ( id, name ) VALUES ( null, 'Sample data' );