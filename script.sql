.mode column
.headers ON

PRAGMA foreign_keys=ON;
PRAGMA encoding="UTF-8";

CREATE TABLE Shelter (
    id INTEGER,
    name VARCHAR NOT NULL,
    location VARCHAR NOT NULL,
    description VARCHAR NOT NULL,
    pictureUrl VARCHAR,
    registeredOn INTEGER NOT NULL,

    CONSTRAINT Shelter_PK PRIMARY KEY(id)
);

CREATE TABLE User (
    username VARCHAR,
    password VARCHAR NOT NULL,
    name VARCHAR NOT NULL,
    pictureUrl VARCHAR,
    registeredOn INTEGER NOT NULL,
    shelter INTEGER,

    CONSTRAINT User_PK PRIMARY KEY(username)
    CONSTRAINT User_FK FOREIGN KEY (shelter) REFERENCES Shelter ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Admin (
    username VARCHAR,

    CONSTRAINT Admin_PK PRIMARY KEY(username),
    CONSTRAINT Admin_FK FOREIGN KEY(username) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Notification (
    id INTEGER,
    read INTEGER DEFAULT 0 NOT NULL,
    subject VARCHAR NOT NULL,
    text VARCHAR,
    user VARCHAR NOT NULL,

    CONSTRAINT Notification_PK PRIMARY KEY(id),
    CONSTRAINT Notification_FK FOREIGN KEY(user) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Pet (
    id INTEGER,
    name VARCHAR,
    species VARCHAR NOT NULL,
    size VARCHAR NOT NULL,
    color VARCHAR NOT NULL,
    location VARCHAR NOT NULL,
    description VARCHAR NOT NULL,
    status VARCHAR DEFAULT 'forAdoption' NOT NULL,
    postedBy VARCHAR NOT NULL,

    CONSTRAINT Pet_PK PRIMARY KEY(id),
    CONSTRAINT Pet_FK FOREIGN KEY(postedBy) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT sizeRule CHECK (size LIKE 'XS' OR
                               size LIKE 'S' OR
                               size LIKE 'M' OR
                               size LIKE 'L' OR
                               size LIKE 'XL'),

    CONSTRAINT statusRule CHECK (status LIKE 'forAdoption' OR
                                 status LIKE 'addopted' OR
                                 status LIKE 'delivered')
);

CREATE TABLE PetPhoto (
    petId INTEGER,
    url VARCHAR NOT NULL, -- Assuming every row has an URL

    CONSTRAINT PetPhoto_PK PRIMARY KEY(petId),
    CONSTRAINT PetPhoto_FK FOREIGN KEY(petId) REFERENCES Pet ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE AdoptionRequest (
    id INTEGER NOT NULL,
    text VARCHAR NOT NULL,
    outcome VARCHAR DEFAULT 'pending' NOT NULL,
    pet INTEGER NOT NULL,
    user VARCHAR, -- Response User

    CONSTRAINT AdoptionRequest_PK PRIMARY KEY(id),
    CONSTRAINT AdoptionRequest_FK1 FOREIGN KEY(pet) REFERENCES Pet ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT AdoptionRequest_FK2 FOREIGN KEY(user) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT outcomeRule CHECK (outcome LIKE 'pending' OR
                                  outcome LIKE 'accepted' OR
                                  outcome LIKE 'rejected')
);

CREATE TABLE AdoptionRequestMessage (
    id INTEGER,
    text VARCHAR NOT NULL,
    request INTEGER NOT NULL,

    CONSTRAINT AdoptionRequestMessage_PK PRIMARY KEY(id),
    CONSTRAINT AdoptionRequestMessage_FK FOREIGN KEY(request) REFERENCES AdoptionRequest ON DELETE CASCADE ON DELETE CASCADE
);

CREATE TABLE Comment (
    id INTEGER,
    postedOn INTEGER NOT NULL,
    text VARCHAR NOT NULL,
    pet INTEGER NOT NULL,
    user VARCHAR NOT NULL,

    CONSTRAINT Comment_PK PRIMARY KEY(id),
    CONSTRAINT Comment_FK1 FOREIGN KEY(user) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Comment_FK2 FOREIGN KEY(pet) REFERENCES Pet ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE Table AnswerTo (
    idFather INTEGER, -- Referal
    idSon INTEGER NOT NULL,

    CONSTRAINT AnswerTo_PK PRIMARY KEY(idSon),
    CONSTRAINT AnswerTo_FK1 FOREIGN KEY(idFather) REFERENCES Comment ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT AnswerTo_FK2 FOREIGN KEY(idSon) REFERENCES Comment ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE PetPhotoInComment (
    commentId INTEGER
    url VARCHAR NOT NULL, -- Assuming every row has an URL

    CONSTRAINT PetPhotoInComment_PK PRIMARY KEY(commentId),
    CONSTRAINT PetPhotoInComment_FK FOREIGN KEY(commentId) REFERENCES Comment ON DELETE CASCADE ON UPDATE CASCADE
);