DROP TABLE IF EXISTS Recruits;

CREATE TABLE Recruits (
  
  UserName varchar(255),
  Planet varchar(255),
  Pass varchar(255),
  HighScore int(11),
  
  PRIMARY KEY(UserName)
);