CREATE TABLE Usr(
id SERIAL PRIMARY KEY,
email	varchar(50) NOT NULL,
name varchar(50) NOT NULL,
password varchar(50) NOT NULL
);

CREATE TABLE Wine(
id SERIAL PRIMARY KEY,
name varchar(50) NOT NULL,
region varchar(50),
wineText varchar(500),
type varchar(50)
);

CREATE TABLE Tag(
id SERIAL PRIMARY KEY,
text varchar(50) NOT NULL,
);

CREATE TABLE Review(
id SERIAL PRIMARY KEY,
usrId	integer NOT NULL,
wineId integer NOT NULL,
reviewText varchar(500),
stars integer,
FOREIGN KEY(usrId) REFERENCES Usr(id),
FOREIGN KEY(wineId) REFERENCES Wine(id)
);

CREATE TABLE ReviewTag(
id SERIAL PRIMARY KEY,
reviewId integer NOT NULL,
tagId integer NOT NULL,
FOREIGN KEY(reviewId) REFERENCES Review(id),
FOREIGN KEY(tagId) REFERENCES Tag(id)
);
