use db;
CREATE TABLE IF NOT EXISTS user(
  `id` INT(11) NOT NULL auto_increment PRIMARY KEY,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO user (id, name) VALUES (1, "test");
INSERT INTO user (id, name) VALUES (2, "test1");
INSERT INTO user (id, name) VALUES (3, "test2");
INSERT INTO user (id, name) VALUES (4, "tanaka");
INSERT INTO user (id, name) VALUES (5, "yamada");