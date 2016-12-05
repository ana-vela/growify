

-- drop table if exists statements
DROP TABLE IF EXISTS companionPlant;
DROP TABLE IF EXISTS combativePlant;
DROP TABLE IF EXISTS garden;
DROP TABLE IF EXISTS plantArea;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS zipCode;
DROP TABLE IF EXISTS plant;
DROP TABLE IF EXISTS location;




CREATE TABLE location(
	locationZipCode VARCHAR(5) NOT NULL,
	locationLatitude FLOAT NOT NULL,
	locationLongitude FLOAT NOT NULL,
	INDEX(locationZipCode),
	PRIMARY KEY(locationZipCode)
);

CREATE TABLE zipCode(
	zipCodeCode VARCHAR(5)NOT NULL, -- made a varchar for easier validation but can change to unsigned int
	zipCodeZone VARCHAR(2) NOT NULL,
	-- foreign key and indexing
	INDEX(zipCodeZone),
	PRIMARY KEY(zipCodeCode)
);

CREATE TABLE profile(
	profileId INT UNSIGNED AUTO_INCREMENT, -- PRIMARY KEY
	profileZipCode CHAR(5) NOT NULL, -- FOREIGN KEY
	profileHash CHAR(128) NOT NULL,
	profileActivation CHAR(16) UNIQUE,
	profileSalt CHAR(64) NOT NULL,
	profileUsername VARCHAR(24) UNIQUE NOT NULL,
	profileEmail VARCHAR(160) UNIQUE NOT NULL,
	-- PRIMARY KEY AND FOREIGN KEY
	PRIMARY KEY (profileId),
	FOREIGN KEY (profileZipCode) REFERENCES zipCode(zipCodeCode)
);


CREATE TABLE plant(

	plantId SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT, -- PRIMARY KEY
	plantName VARCHAR(64) ,
	plantLatinName VARCHAR (72) ,
	plantVariety VARCHAR(64) ,
	plantType VARCHAR(32)  ,
	plantDescription TEXT,
	plantSpread FLOAT UNSIGNED ,
	plantHeight FLOAT UNSIGNED ,
	plantDaysToHarvest SMALLINT UNSIGNED ,
	plantMinTemp TINYINT SIGNED NOT NULL,
	plantMaxTemp TINYINT SIGNED ,
	plantSoilMoisture VARCHAR(32) ,
	PRIMARY KEY (plantId) -- ,
	-- FOREIGN KEY (plantId) REFERENCES garden(gardenPlantId),
	-- FOREIGN KEY (plantId) REFERENCES plantArea(plantAreaPlantId)
);

CREATE TABLE companionPlant(

	companionPlant1Name VARCHAR(64) NOT NULL,
	companionPlant1LatinName VARCHAR(72) NOT NULL,
	companionPlant2Name VARCHAR(64) NOT NULL,
	companionPlant2LatinName VARCHAR(72) NOT NULL,
	-- index and create foreign keys
	INDEX(companionPlant1Name),
	INDEX(companionPlant1LatinName),
	INDEX(companionPlant2Name),
	INDEX(companionPlant2LatinName)
);

CREATE TABLE combativePlant(
	combativePlant1Name VARCHAR(64) NOT NULL,
	combativePlant1LatinName VARCHAR(72) NOT NULL,
	combativePlant2Name VARCHAR(64) NOT NULL,
	combativePlant2LatinName VARCHAR(72) NOT NULL,
	-- index foreign keys
	INDEX(combativePlant1Name),
	INDEX(combativePLant1LatinName),
	INDEX(combativePlant2Name),
	INDEX(combativePlant2LatinName)
);

CREATE TABLE garden (
	-- gardenId SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT, -- PRIMARY KEY
	gardenProfileId INT UNSIGNED,
	gardenPlantId SMALLINT UNSIGNED,
	gardenDatePlanted DATE,
	-- index and create keys
	-- PRIMARY KEY (gardenId),
	FOREIGN KEY(gardenProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(gardenPlantId) REFERENCES plant(plantId),
	INDEX(gardenProfileId),
	INDEX(gardenPlantId)
);

CREATE TABLE plantArea(
	plantAreaId SMALLINT UNSIGNED AUTO_INCREMENT, -- Primary Key
	plantAreaPlantId SMALLINT UNSIGNED NOT NULL, -- Foreign Key

	plantAreaStartDay TINYINT NOT NULL,
	plantAreaEndDay TINYINT NOT NULL,
	plantAreaStartMonth TINYINT NOT NULL,
	plantAreaEndMonth TINYINT NOT NULL,
	plantAreaNumber VARCHAR(2),
	-- index and create foreign key
	INDEX(plantAreaPlantId),
	FOREIGN KEY(plantAreaPlantId) REFERENCES plant(plantId),
	PRIMARY KEY (plantAreaId)
);



