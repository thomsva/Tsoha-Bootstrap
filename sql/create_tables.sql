-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Player(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  name varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
  password varchar(50) NOT NULL,
  test varchar(10)
);

CREATE TABLE Usr(
id serial PRIMARY KEY,
email	varchar(50) NOT NULL,
name varchar(50) NOT NULL,
password varchar(50) NOT NULL
);

CREATE TABLE Wine(
id serial PRIMARY KEY,
name	varchar(50) NOT NULL,
region varchar(50),
wineText varchar(500),
type varchar(50)
);

CREATE TABLE Tag(
id serial PRIMARY KEY,
text varchar(50) NOT NULL,
);

CREATE TABLE Review(
id serial PRIMARY KEY,
usrId	varchar(50) NOT NULL,
wineId varchar(50) NOT NULL,
reviewText varchar(500),
stars int4range[1,5]),
FOREIGN KEY(usrId) REFERENCES Usr(id),
FOREIGN KEY(wineId) REFERENCES Wine(id)
);

CREATE TABLE ReviewTag(
id serial PRIMARY KEY,
reviewId varchar(50) NOT NULL,
tagId varchar(50) NOT NULL,
FOREIGN KEY(reviewId) REFERENCES Review(id),
FOREIGN KEY(tagId) REFERENCES Tag(id)
);

