.mode column
.headers ON
PRAGMA encoding="UTF-8";

PRAGMA foreign_keys=OFF;

DROP TABLE IF EXISTS Shelter;
DROP TABLE IF EXISTS ShelterInvite;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Admin;
DROP TABLE IF EXISTS Notification;
DROP TABLE IF EXISTS Pet;
DROP TABLE IF EXISTS PetPhoto;
DROP TABLE IF EXISTS AdoptionRequest;
DROP TABLE IF EXISTS AdoptionRequestMessage;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS FavoritePet;
DROP TABLE IF EXISTS PasswordResetToken;

DROP TRIGGER IF EXISTS Comment_answerPet;
DROP TRIGGER IF EXISTS Comment_answerTime;

PRAGMA foreign_keys=ON;

CREATE TABLE Shelter (
    username    VARCHAR NOT NULL CHECK(username <> ''),
    location    VARCHAR NOT NULL CHECK(location     <> ''),
    description VARCHAR NOT NULL CHECK(description  <> ''),

    CONSTRAINT Shelter_PK PRIMARY KEY(username),
    CONSTRAINT Shelter_FK FOREIGN KEY(username) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ShelterInvite (
    text    VARCHAR NOT NULL CHECK(text <> ''),
    user    VARCHAR NOT NULL, -- Response User
    shelter VARCHAR NOT NULL CHECK(shelter <> ''),
    requestDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT AdoptionRequest_PK PRIMARY KEY(user, shelter),
    CONSTRAINT AdoptionRequest_FK1 FOREIGN KEY(user) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT AdoptionRequest_FK2 FOREIGN KEY(shelter) REFERENCES Shelter ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE User (
    username     VARCHAR NOT NULL CHECK(username <> ''),
    password     VARCHAR NOT NULL,
    email        VARCHAR NOT NULL CHECK(email LIKE "%@%.%"),
    name         VARCHAR NOT NULL CHECK(name     <> ''),
    registeredOn TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    shelter      VARCHAR,

    CONSTRAINT User_PK PRIMARY KEY(username),
    CONSTRAINT User_FK FOREIGN KEY (shelter) REFERENCES Shelter ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Notification (
    id          INTEGER NOT NULL,
    read        INTEGER NOT NULL DEFAULT 0,
    subject     VARCHAR NOT NULL,
    text        VARCHAR NOT NULL CHECK (text <> ''),
    user        VARCHAR NOT NULL,

    CONSTRAINT Notification_PK PRIMARY KEY(id),
    CONSTRAINT Notification_FK FOREIGN KEY(user) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT subjectRule CHECK (subject LIKE 'adoptionProposalOutcome' OR
                                  subject LIKE 'newPetAdoptionProposal' OR
                                  subject LIKE 'newMessage' OR
                                  subject LIKE 'favoriteAdopted' OR
                                  subject LIKE 'proposedPetAdopted' OR
                                  subject LIKE 'shelterInvitation' OR
                                  subject LIKE 'userLeftShelter' OR
                                  subject LIKE 'invitationOutcome' OR
                                  subject LIKE 'associatedPetAdopted' OR
                                  subject LIKE 'myPetFavoritesChanges' OR
                                  subject LIKE 'newPetComment' OR
                                  subject LIKE 'favoriteEdited')
);

CREATE TABLE Pet (
    id          INTEGER NOT NULL,
    name        VARCHAR NOT NULL CHECK(name         <> ''),
    species     VARCHAR NOT NULL CHECK(species      <> ''),
    age         DECIMAL NOT NULL CHECK(age          >   0),
    sex         VARCHAR NOT NULL CHECK(sex IN ('M', 'F')),
    size        VARCHAR NOT NULL CHECK(size IN ('XS', 'S', 'M', 'L', 'XL')),
    color       VARCHAR NOT NULL CHECK(color        <> ''),
    location    VARCHAR NOT NULL CHECK(location     <> ''),
    description VARCHAR NOT NULL CHECK(description  <> ''),
    status      VARCHAR NOT NULL DEFAULT 'forAdoption',
    adoptionDate TIMESTAMP, -- Check date format
    postedBy    VARCHAR NOT NULL,

    CONSTRAINT Pet_PK PRIMARY KEY(id),
    CONSTRAINT Pet_FK FOREIGN KEY(postedBy) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT age CHECK(age >= 0),

    CONSTRAINT sex CHECK (sex in ("M", "F")),

    CONSTRAINT sizeRule CHECK (size IN ('XS','S','M','L','XL')),

    CONSTRAINT statusRule CHECK (status IN ('forAdoption','adopted','delivered'))
);

CREATE TABLE AdoptionRequest (
    id      INTEGER NOT NULL,
    text    VARCHAR NOT NULL CHECK(text <> ''),
    outcome VARCHAR NOT NULL DEFAULT 'pending',
    pet     INTEGER NOT NULL,
    user    VARCHAR NOT NULL, -- Response User
    messageDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT AdoptionRequest_PK PRIMARY KEY(id),
    CONSTRAINT AdoptionRequest_FK1 FOREIGN KEY(pet) REFERENCES Pet ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT AdoptionRequest_FK2 FOREIGN KEY(user) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT outcomeRule CHECK (outcome LIKE 'pending' OR
                                  outcome LIKE 'accepted' OR
                                  outcome LIKE 'rejected')
);

CREATE TABLE AdoptionRequestMessage (
    id      INTEGER NOT NULL,
    text    VARCHAR NOT NULL CHECK(text <> ''),
    request INTEGER NOT NULL,
    messageDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user VARCHAR NOT NULL,

    CONSTRAINT AdoptionRequestMessage_PK PRIMARY KEY(id),
    CONSTRAINT AdoptionRequestMessage_FK1 FOREIGN KEY(request) REFERENCES AdoptionRequest ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT AdoptionRequestMessage_FK2 FOREIGN KEY(user) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Comment (
    id          INTEGER   NOT NULL,
    postedOn    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    text        VARCHAR   NOT NULL,
    pet         INTEGER   NOT NULL,
    user        VARCHAR   NOT NULL,
    answerTo    INTEGER,

    CONSTRAINT Comment_PK PRIMARY KEY(id),
    CONSTRAINT Comment_FK1 FOREIGN KEY(user) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Comment_FK2 FOREIGN KEY(pet) REFERENCES Pet ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Comment_FK3 FOREIGN KEY(answerTo) REFERENCES Comment ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE FavoritePet (
    username VARCHAR,
    petId INTEGER,

    CONSTRAINT FavoritePet_PK PRIMARY KEY(username, petId),
    CONSTRAINT FavoritePet_FK1 FOREIGN KEY(username) REFERENCES User ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FavoritePet_FK2 FOREIGN KEY(petId) REFERENCES Pet ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE PasswordResetToken (
    username    VARCHAR     NOT NULL REFERENCES User,
    token       VARCHAR     NOT NULL,
    created     TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    expires     TIMESTAMP   NOT NULL
);

CREATE TRIGGER Comment_answerPet
BEFORE INSERT ON Comment
FOR EACH ROW
WHEN NEW.answerTo IS NOT NULL AND
(SELECT pet FROM Comment WHERE id=NEW.answerTo) != NEW.pet
BEGIN
    SELECT raise(rollback, 'Answer must have same pet');
END;

CREATE TRIGGER Comment_answerTime
BEFORE INSERT ON Comment
FOR EACH ROW
WHEN NEW.answerTo IS NOT NULL AND
(SELECT postedOn FROM Comment WHERE id=NEW.answerTo) > NEW.postedOn
BEGIN
    SELECT raise(rollback, 'Answer must come after comment it answers to');
END;

CREATE TRIGGER Adoption_accepted
BEFORE UPDATE ON Pet
FOR EACH ROW
WHEN NEW.status = 'adopted' OR NEW.status = 'delivered'
BEGIN
    UPDATE Pet SET adoptionDate = CURRENT_TIMESTAMP WHERE id = NEW.id;
END;