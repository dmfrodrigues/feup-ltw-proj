.mode column
.headers ON

PRAGMA foreign_keys=ON;
PRAGMA encoding="UTF-8";

-- Shelter
INSERT INTO Shelter
    VALUES(NULL, 'AnimalAdoption', 'Lisbon', 'We take care of animals.', NULL, strftime("%d/%m/%Y %H:%M", "2018-08-12 20:00"));

-- User
INSERT INTO User
    VALUES('Asdrubal007', '123abc456', 'Asdrubal', NULL, strftime("%d/%m/%Y %H:%M", "2019-02-12 20:00"), NULL);
INSERT INTO User
    VALUES('Romanoff123', 'asd456', 'Roma', NULL, strftime("%d/%m/%Y %H:%M", "2019-02-10 23:00"), 1);

-- Notification
INSERT INTO Notification
    VALUES(NULL, 0, 'MyNotification', 'You received a notification.', 'Asdrubal007');

-- Admin
INSERT INTO Admin
    VALUES('Asdrubal007');

-- Pet
INSERT INTO Pet
    VALUES (NULL, 'Kitty', 'Cat', 'S', 'White', 'Marvila', 'Very cute cat.', 'forAdoption', 'Asdrubal007');
INSERT INTO Pet
    VALUES (NULL, 'Princesa', 'Cat', 'XS', 'Gray', 'Olaias', 'Another very cute cat.', 'forAdoption', 'Asdrubal007');

-- AdoptionRequest
INSERT INTO AdoptionRequest
    VALUES(NULL, 'Please adoptme', 'pending', 1, NULL);
INSERT INTO AdoptionRequest
    VALUES(NULL, 'Please adopt this little cat!', 'accepted', 1, 'Romanoff123');

-- AdoptionRequestMessage
INSERT INTO AdoptionRequestMessage
    VALUES(NULL, 'Sure...', 2);

-- Comment
INSERT INTO Comment
    VALUES(NULL, strftime("%d/%m/%Y %H:%M", "2019-12-07 09:10"), 'A simple comment.', 1, 'Asdrubal007');

INSERT INTO Comment
    VALUES(NULL, strftime("%d/%m/%Y %H:%M", "2019-12-07 09:20"), 'Another simple comment.', 1, 'Asdrubal007');

--AnswerTo
INSERT INTO AnswerTo
    VALUES(1, 2);