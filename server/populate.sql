.mode column
.headers ON

PRAGMA foreign_keys=ON;
PRAGMA encoding="UTF-8";

-- Shelter
INSERT INTO Shelter
    VALUES(NULL, 'AnimalAdoption', 'Lisbon', 'We take care of animals.', NULL, strftime("%d/%m/%Y %H:%M", "2018-08-12 20:00"));

-- User
INSERT INTO User
(username      , password                                  , name                        , pictureUrl                                                                                              ) VALUES
("dmfr"        , "eff14f9ad2f2ecaa8df1ebb50fc7113d2eac89cb", "Diogo Rodrigues"           , "https://avatars3.githubusercontent.com/u/43684166?s=400&u=03a088a2de6621066111b4d05f40d7489abd494d&v=4"),
("BrenoAccioly", "6ee278a3b837d564187ccb3ecc877057701eb7b2", "Breno Accioly"             , "https://avatars3.githubusercontent.com/u/43919387?s=400&u=dd552fba69b0469db1c0bb3911e13fd46733bd4d&v=4"),
("2dukes"      , "463e890d73f5d6d1f3b1268ee7e426933370f8cb", "Rui Pinto"                 , "https://avatars0.githubusercontent.com/u/22317258?s=400&u=392e493cb6abe197adf4c572550abafcf9db7f27&v=4"),
("TiagooGomess", "0d47223986b750aecf2607ee8f26c58f7fe31e3a", "Tiago Gomes"               , "https://avatars3.githubusercontent.com/u/50210213?s=400&u=037938f7505165a289343a0fb9c7cfac66b29cfd&v=4"),
("Asdrubal007" , "65417b70a1a7bd08a6189f4d309d90979cbe7b56", "Asdrubal"                  , "https://picsum.photos/seed/picsum/400/400"                                                             ),
("balves"      , "c00ab69a0a4826bb8f8fb5bdf68503f92183a9be", "Bernardo Alves"            , "https://picsum.photos/seed/picsum/400/400"                                                             ),
("Romanoff123" , "013564dc05c22e397a30d38805fae295ef8cb4cc", "Romanoff"                  , "https://picsum.photos/seed/picsum/400/400"                                                             ); 

-- Notification
INSERT INTO Notification
    VALUES(NULL, 0, 'MyNotification', 'You received a notification.', 'Asdrubal007');

-- Admin
INSERT INTO Admin VALUES ("dmfr"), ("BrenoAccioly"), ("2dukes"), ("TiagooGomess");

-- Pet
INSERT INTO Pet
    VALUES (NULL, 'Kitty', 'Cat', 3, 'F', 'S', 'White', 'Marvila', 'Very cute cat.', 'forAdoption', 'Asdrubal007');
INSERT INTO Pet
    VALUES (NULL, 'Princesa', 'Cat', 5, 'M', 'XS', 'Gray', 'Olaias', 'Another very cute cat.', 'forAdoption', 'Asdrubal007');

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
    VALUES(NULL, strftime("%d/%m/%Y %H:%M", "2019-12-07 09:10"), 'A simple comment.', 1, 'Asdrubal007', NULL);

INSERT INTO Comment
    VALUES(NULL, strftime("%d/%m/%Y %H:%M", "2019-12-07 09:20"), 'Another simple comment.', 1, 'Asdrubal007', 1);

-- PetPhoto
INSERT INTO PetPhoto(petId, id, url) 
    VALUES (1, 1, "https://news.rspca.org.uk/wp-content/uploads/black-cats-1024x705.jpg");

-- CommentPhoto
INSERT INTO CommentPhoto 
    VALUES (1, "https://news.rspca.org.uk/wp-content/uploads/black-cats-1024x705.jpg");

-- FavoritePet
INSERT INTO FavoritePet
    VALUES('Romanoff123', 1);
