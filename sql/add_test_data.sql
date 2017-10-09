-- Lisää INSERT INTO lauseet tähän tiedostoon


INSERT INTO Usr (email, name, password)
VALUES 
    ('thomas@helsinki', 'Thomas', '123'),
    ('testi@domain','Testaaja','123')
;

INSERT INTO Wine (name, region, wineText,type)
VALUES ('Raimat Abadia',
    'Katalonia, Espanja',
    'Raimat Abadia on hyvä perusviini, joka valmistuu Tempranillo ja Cabernet Sauvignon rypäleistä',
    'punaviini'),
    ('Mud House Central Otago Pinot Noir 2015',
    'Uusi Seelanti',
    'Pinot Noir rypäleestä valmistettu punaviini.',
    'punaviini'),
    ('Raiz de Guzmán Crianza 2011',
    'Espanja',
    'Täyteläinen espanjalainen punaviini Tempranillo rypäleestä.',
    'punaviini')
;

INSERT INTO Tag(tagText)
VALUES 
    ('voimakas'),
    ('tamminen'),
    ('vaniljainen'),
    ('lihan kanssa'),
    ('kalan kanssa'),
    ('kevyt'),
    ('kaakao'),
    ('pähkinäinen'),
    ('makea'),
    ('aromikas')
;

INSERT INTO Review(usrid,wineid,reviewtext,stars)
VALUES (1,1,'Arvosteluteksti 1',3),(1,2,'Arvosteluteksti 2',4)
;

INSERT INTO ReviewTag(reviewId,tagId)
VALUES (1,1),(1,2),(1,4),(2,5)
;