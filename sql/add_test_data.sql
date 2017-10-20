-- Lisää INSERT INTO lauseet tähän tiedostoon


INSERT INTO Usr (email, name, admin, password)
VALUES 
    ('admin@wine', 'Pääkäyttäjä', 'true',  '321'),
    ('thomas@helsinki', 'Thomas', 'false', '123'),
    ('testi@wine','Testaaja', 'false', '123')
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
    ('hyvä hinta-laatusuhde'),
    ('lihan kanssa'),
    ('kalan kanssa'),
    ('riistaruokien kanssa'),
    ('kasvisruokien kanssa'),
    ('voimakas'),
    ('kevyt'),
    ('raikas'),
    ('kuiva'),
    ('makea'),
    ('kupliva'),
    ('maukas'),
    ('aromikas'),
    ('tamminen'),
    ('vaniljainen'),
    ('mineraalinen'),    
    ('pähkinäinen'),
    ('herukkainen'),
    ('marjainen'),
    ('raskas'),
    ('kitkerä'),
    ('hapan')
;

INSERT INTO Review(usrid,wineid,reviewtext,stars)
VALUES (1,1,'Arvosteluteksti 1',3),(1,2,'Arvosteluteksti 2',4)
;

INSERT INTO ReviewTag(reviewId,tagId)
VALUES (1,1),(1,2),(1,4),(2,5)
;