SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `GoTPeople`;
DROP TABLE IF EXISTS `GoTHouses`;
DROP TABLE IF EXISTS `GoTTerritories`;
DROP TABLE IF EXISTS `GoTEvents`;
DROP TABLE IF EXISTS `GoTPeopleEvents`;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE GoTPeople
(
 id INT AUTO_INCREMENT PRIMARY KEY,
 FirstName VARCHAR(255) NOT NULL,
 LastName VARCHAR(255),
 Occupation VARCHAR(255),
 Status VARCHAR(255),
 HouseId INT
);



CREATE TABLE GoTHouses
(
 id INT AUTO_INCREMENT PRIMARY KEY,
 Name VARCHAR(255) NOT NULL,
 HeadId INT,
 Colors VARCHAR(255) NOT NULL,
 Sigil VARCHAR(255) NOT NULL,
 HouseWords VARCHAR(255), 
 FOREIGN KEY(HeadId) REFERENCES GoTPeople(id)
 ON DELETE SET NULL ON UPDATE CASCADE
);



ALTER TABLE GoTPeople
  ADD FOREIGN KEY (HouseId) REFERENCES GoTHouses(id)
  ON DELETE SET NULL ON UPDATE CASCADE;



CREATE TABLE GoTTerritories
(
 id INT AUTO_INCREMENT PRIMARY KEY,
 Name VARCHAR(255) NOT NULL,
 Climate VARCHAR(255),
 Location VARCHAR(255),
 Continent VARCHAR(255) NOT NULL,
 RuledById INT, 
 FOREIGN KEY(RuledById) REFERENCES GoTHouses(id)
 ON DELETE SET NULL ON UPDATE CASCADE
);




CREATE TABLE GoTEvents
(
 id INT AUTO_INCREMENT PRIMARY KEY,
 Name VARCHAR(255),
 LocationId INT,
 Casualties BOOLEAN,
 Type VARCHAR(255), 
 FOREIGN KEY(LocationId) REFERENCES GoTTerritories(id)
 ON DELETE SET NULL ON UPDATE CASCADE
);



CREATE TABLE GoTPeopleEvents
(
 id INT AUTO_INCREMENT PRIMARY KEY,
 Pid INT,
 Eid INT, 
 FOREIGN KEY(Pid) REFERENCES GoTPeople(id)
 ON DELETE SET NULL ON UPDATE CASCADE,
 FOREIGN KEY(Eid) REFERENCES GoTEvents(id)
 ON DELETE SET NULL ON UPDATE CASCADE
);




INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Stark', 'Grey, White and Green', 'Direwolf', 'Winter is coming.' );

INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Jon', 'Snow', 'Lord Commander', 'Resurrected', (SELECT id FROM GoTHouses WHERE Name = 'Stark'));

INSERT INTO GoTTerritories (Name, Climate, Location, Continent, RuledById)
VALUES ('Winterfell', 'Cold and Snowy', 'North', 'Westeros', (SELECT id FROM GoTHouses WHERE Name = 'Stark'));

UPDATE GoTHouses SET HeadId = (SELECT id FROM GoTPeople WHERE FirstName = 'Jon' AND LastName = 'Snow')
WHERE Name = 'Stark';

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Lannister', 'Red and Gold', 'Lion', 'Hear Me Roar!' );

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Baratheon', 'Yellow and Black', 'Stag', 'Ours is the Fury.' );

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Greyjoy', 'Black and White', 'Kraken', 'We Do Not Sow.' );

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Targaryen', 'Red and Black', '3-Headed Dragon', 'Fire and Blood.' );

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Arryn', 'White and Blue', 'Falcon and Crescent', 'As High as Honor.' );

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Tully', 'Silver, Red and Blue', 'Trout', 'Family, Duty, Honor.' );

INSERT INTO GoTHouses (Name, Colors, Sigil)
VALUES ('Umber', 'Red and Silver', '4 Chains');

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Karstark', 'White and Black', 'Sunburst', 'The Sun of Winter.' );

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Stark', 'Grey, White and Green', 'Direwolf', 'Winter is coming.' );

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Martell', 'Red, Gold and Orange', 'Spear pierced Sun', 'Unbowed, Unbent, Unbroken.' );

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Tyrell', 'Green and Gold', 'Rose', 'Growing Strong.' );

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Frey', 'Grey and Blue', 'Two Towers', 'We Stand Together.' );

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Bolton', 'Red, White and Black', 'Flayed Man', 'Our Blades are Sharp.' );

INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords)
VALUES ('Mormont', 'Black, Green and White', 'Bear', 'Here We Stand.' );

INSERT INTO GoTHouses (Name, Colors, Sigil)
VALUES ('Reed', 'Green and Black', 'Crocodile');





INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Jamie', 'Lannister', 'Lord', 'Alive', (SELECT id FROM GoTHouses WHERE Name = 'Lannister'));

UPDATE GoTHouses SET HeadId = (SELECT id FROM GoTPeople WHERE FirstName = 'Jamie' AND LastName = 'Lannister') 
WHERE Name = 'Lannister';

INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Euron', 'Greyjoy', 'King', 'Alive', (SELECT id FROM GoTHouses WHERE Name = 'Greyjoy'));

UPDATE GoTHouses SET HeadId = (SELECT id FROM GoTPeople WHERE FirstName = 'Euron' AND LastName = 'Greyjoy') 
WHERE Name = 'Greyjoy';

INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Daenerys', 'Targaryen', 'Queen', 'Alive', (SELECT id FROM GoTHouses WHERE Name = 'Targaryen'));

UPDATE GoTHouses SET HeadId = (SELECT id FROM GoTPeople WHERE FirstName = 'Daenerys' AND LastName = 'Targaryen') 
WHERE Name = 'Targaryen';

INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Robin', 'Arryn', 'Lord', 'Alive', (SELECT id FROM GoTHouses WHERE Name = 'Arryn'));

UPDATE GoTHouses SET HeadId = (SELECT id FROM GoTPeople WHERE FirstName = 'Robin' AND LastName = 'Arryn') 
WHERE Name = 'Arryn';

INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Edmure', 'Tully', 'Lord', 'Alive', (SELECT id FROM GoTHouses WHERE Name = 'Tully'));

UPDATE GoTHouses SET HeadId = (SELECT id FROM GoTPeople WHERE FirstName = 'Edmure' AND LastName = 'Tully') 
WHERE Name = 'Tully';

INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Harald', 'Karstark', 'Lord', 'Unknown', (SELECT id FROM GoTHouses WHERE Name = 'Karstark'));

UPDATE GoTHouses SET HeadId = (SELECT id FROM GoTPeople WHERE FirstName = 'Harald' AND LastName = 'Karstark') 
WHERE Name = 'Karstark';

INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Ellaria', 'Sand', 'Queen', 'Alive', (SELECT id FROM GoTHouses WHERE Name = 'Martell'));

UPDATE GoTHouses SET HeadId = (SELECT id FROM GoTPeople WHERE FirstName = 'Ellaria' AND LastName = 'Sand') 
WHERE Name = 'Martell';

INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Olenna', 'Tyrell', 'Lady', 'Alive', (SELECT id FROM GoTHouses WHERE Name = 'Tyrell'));

UPDATE GoTHouses SET HeadId = (SELECT id FROM GoTPeople WHERE FirstName = 'Olenna' AND LastName = 'Tyrell') 
WHERE Name = 'Tyrell';

INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Lyanna', 'Mormont', 'Lady', 'Alive', (SELECT id FROM GoTHouses WHERE Name = 'Mormont'));

UPDATE GoTHouses SET HeadId = (SELECT id FROM GoTPeople WHERE FirstName = 'Lyanna' AND LastName = 'Mormont') 
WHERE Name = 'Mormont';

INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Howland', 'Reed', 'Lord', 'Unknown', (SELECT id FROM GoTHouses WHERE Name = 'Reed'));

UPDATE GoTHouses SET HeadId = (SELECT id FROM GoTPeople WHERE FirstName = 'Howland' AND LastName = 'Reed') 
WHERE Name = 'Reed';

INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId)
VALUES ('Frey', 'Walder', 'Lord', 'Deceased', (SELECT id FROM GoTHouses WHERE Name = 'Frey'));

INSERT INTO GoTTerritories (Name, Climate, Location, Continent, RuledById)
VALUES ('Casterly Rock', 'Warm', 'Westerlands', 'Westeros', (SELECT id FROM GoTHouses WHERE Name = 'Lannister'));

INSERT INTO GoTTerritories (Name, Climate, Location, Continent, RuledById)
VALUES ('Iron Islands', 'Cold and Damp', 'Iron Islands', 'Westeros', (SELECT id FROM GoTHouses WHERE Name = 'Greyjoy'));

INSERT INTO GoTTerritories (Name, Climate, Location, Continent, RuledById)
VALUES ('DragonStone', 'Warm', 'Crowlands', 'Westeros', (SELECT id FROM GoTHouses WHERE Name = 'Baratheon'));

INSERT INTO GoTTerritories (Name, Climate, Location, Continent, RuledById)
VALUES ('Highgarden', 'Fair', 'The Reach', 'Westeros', (SELECT id FROM GoTHouses WHERE Name = 'Tyrell'));

INSERT INTO GoTTerritories (Name, Climate, Location, Continent, RuledById)
VALUES ('Sunspear', 'Warm and Dry', 'Dorne', 'Westeros', (SELECT id FROM GoTHouses WHERE Name = 'Martell'));

INSERT INTO GoTTerritories (Name, Climate, Location, Continent, RuledById)
VALUES ('The Eeyrie', 'Fair', 'The Vale', 'Westeros', (SELECT id FROM GoTHouses WHERE Name = 'Arryn'));

INSERT INTO GoTTerritories (Name, Climate, Location, Continent, RuledById)
VALUES ('Bear Island', 'Cold and Snowy', 'North', 'Westeros', (SELECT id FROM GoTHouses WHERE Name = 'Mormont'));

INSERT INTO GoTTerritories (Name, Climate, Location, Continent, RuledById)
VALUES ('The Twins', 'Cold and Damp', 'The Riverlands', 'Westeros', (SELECT id FROM GoTHouses WHERE Name = 'Frey'));



INSERT INTO GoTEvents (Name, LocationId, Casualties, Type)
VALUES ('The Red Wedding', (SELECT id FROM GoTTerritories WHERE Name = 'The Twins'), true, 'Wedding');

INSERT INTO GoTPeopleEvents (Pid, Eid)
VALUES ((SELECT id FROM GoTPeople WHERE FirstName = 'Edmure' AND LastName = 'Tully'),
		(SELECT id FROM GoTEvents WHERE Name = 'The Red Wedding'));

INSERT INTO GoTPeopleEvents (Pid, Eid)
VALUES ((SELECT id FROM GoTPeople WHERE FirstName = 'Walder' AND LastName = 'Frey'),
		(SELECT id FROM GoTEvents WHERE Name = 'The Red Wedding'));


