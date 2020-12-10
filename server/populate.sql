.mode column
.headers ON

PRAGMA foreign_keys=ON;
PRAGMA encoding="UTF-8";



-- User
INSERT INTO User
(username      , password                                  , name             ) VALUES
("dmfr"        , "eff14f9ad2f2ecaa8df1ebb50fc7113d2eac89cb", "Diogo Rodrigues"),
("BrenoAccioly", "6ee278a3b837d564187ccb3ecc877057701eb7b2", "Breno Accioly"  ),
("2dukes"      , "463e890d73f5d6d1f3b1268ee7e426933370f8cb", "Rui Pinto"      ),
("TiagooGomess", "0d47223986b750aecf2607ee8f26c58f7fe31e3a", "Tiago Gomes"    ),
("Asdrubal007" , "65417b70a1a7bd08a6189f4d309d90979cbe7b56", "Asdrubal"       ),
("balves"      , "c00ab69a0a4826bb8f8fb5bdf68503f92183a9be", "Bernardo Alves" ),
("harold"      , "b131867c5de6fc08a4ce1fc50393cad671c82bd5", "Harold"         ),
("Romanoff123" , "013564dc05c22e397a30d38805fae295ef8cb4cc", "Romanoff"       ),
('AAOrg'       , "806715632407A53335EA3DE53B4148580870E693", 'AnimalAdoption' );

-- Shelter
INSERT INTO Shelter(username, location, description) VALUES
('AAOrg', 'Lisbon', 'We take care of animals.');

-- Admin
INSERT INTO Admin VALUES ("dmfr"), ("BrenoAccioly"), ("2dukes"), ("TiagooGomess");

-- Pet
INSERT INTO Pet
(name      , species, age, sex, size, color  , location , description             , status       , postedBy      ) VALUES
(   'Kitty',   'Cat',   3, 'F',  'S', 'White', 'Marvila', 'Very cute cat.'        , 'forAdoption', '2dukes'      ),
(   'Kitty',   'Cat',   3, 'F',  'S', 'White', 'Marvila', 'Very cute cat.'        , 'forAdoption', 'TiagooGomess'),
('Princesa',   'Cat',   5, 'M', 'XS',  'Gray',  'Olaias', 'Another very cute cat.', 'forAdoption', 'dmfr'        ),
(   'Oscar',   'Cat',   6, 'M',  'S', 'White',    'Gaia', 'Just a white cat.'     , 'forAdoption', 'dmfr'        );


-- Comment
INSERT INTO Comment(id, pet, user, text, answerTo) VALUES
(1, 1, 'Asdrubal007', 'A simple comment.', NULL),
(2, 1, 'dmfr'       , 'Hello!'           , NULL),
(3, 1, 'Asdrubal007', 'Another simple comment.', 1);

-- FavoritePet
INSERT INTO FavoritePet(username, petId) VALUES
('Romanoff123', 1);
