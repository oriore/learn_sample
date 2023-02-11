use db;
CREATE TABLE IF NOT EXISTS user(
  'id' INT(11) NOT NULL auto_increment PRIMARY KEY,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;