
CREATE TABLE user (
  userId integer PRIMARY KEY AUTOINCREMENT NOT NULL,
  firstname varchar(128) NOT NULL,
  lastname varchar(128) NOT NULL,
  email varchar(128) NOT NULL,
  passwd varchar(128) NOT NULL,
  role varchar(128) NOT NULL DEFAULT('registered'),
  dateCreated text(128) NOT NULL,
  dateModified text(128) NOT NULL
);
CREATE UNIQUE INDEX email ON user (email ASC);
CREATE UNIQUE INDEX userId ON user (userId ASC);