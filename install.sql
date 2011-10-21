ALTER TABLE wcf1_user ADD likes MEDIUMINT(7) NOT NULL DEFAULT 0;

DROP TABLE IF EXISTS wcf1_like;
CREATE TABLE wcf1_like (
	likeID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	objectID INT(10) NOT NULL DEFAULT 0,
	objectTypeID INT(10) NOT NULL DEFAULT 0,
	objectUserID INT(10) NOT NULL DEFAULT 0,
	userID INT(10) NOT NULL DEFAULT 0,
	time INT(10) NOT NULL DEFAULT 0,
	likeValue TINYINT(1) NOT NULL DEFAULT 1,
	UNIQUE KEY (objectTypeID, objectID, userID),
	KEY (objectUserID),
	KEY (userID)
);

DROP TABLE IF EXISTS wcf1_like_object;
CREATE TABLE wcf1_like_object (
	likeObjectID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	objectTypeID INT(10) NOT NULL DEFAULT 0,
	objectID INT(10) NOT NULL DEFAULT 0, 
	objectUserID INT(10) NOT NULL DEFAULT 0,
	likes MEDIUMINT(7) NOT NULL DEFAULT 0,
	dislikes MEDIUMINT(7) NOT NULL DEFAULT 0,
	cumulativeLikes MEDIUMINT(7) NOT NULL DEFAULT 0,
	cachedUsers TEXT,
	UNIQUE KEY (objectTypeID, objectID),
	KEY (objectUserID)
);


ALTER TABLE wcf1_like ADD FOREIGN KEY (objectTypeID) REFERENCES wcf1_object_type (objectTypeID) ON DELETE CASCADE;
ALTER TABLE wcf1_like ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;

ALTER TABLE wcf1_like_object ADD FOREIGN KEY (objectTypeID) REFERENCES wcf1_object_type (objectTypeID) ON DELETE CASCADE;

ALTER TABLE wcf1_like_object_type ADD FOREIGN KEY (packageID) REFERENCES wcf1_package (packageID) ON DELETE CASCADE;