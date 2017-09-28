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
tagText varchar(50) NOT NULL
);


CREATE TABLE Review(
id SERIAL PRIMARY KEY,
usrId INTEGER NOT NULL REFERENCES Usr(id),
wineId INTEGER NOT NULL REFERENCES Wine(id) ON DELETE CASCADE,
reviewText varchar(500),
stars integer CHECK(stars<=5 AND stars>=1)
);

CREATE TABLE ReviewTag(
id SERIAL PRIMARY KEY,
reviewId INTEGER NOT NULL REFERENCES Review(id) ON DELETE CASCADE,
tagId INTEGER NOT NULL REFERENCES Tag(id)
);

