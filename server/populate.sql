.mode column
.headers ON

PRAGMA foreign_keys=ON;
PRAGMA encoding="UTF-8";



-- User
INSERT INTO User
(username      , password                                  , name             ) VALUES
("dmfr"        , "$2y$12$EoGlSpd.GFAjAfFdce4YwOXyJnYDuWgHHUQctTZSyGtVaOJlRvHXa", "Diogo Rodrigues"),
("BrenoAccioly", "$2y$12$HhHbS9d5oBM4tBI7FAktkOSQ.wSEVNViUu87ol10ZUmqD1wn2vhFW", "Breno Accioly"  ),
("2dukes"      , "$2y$12$ECt9IhyVUdCo.puADzqPHO0Ej0mW2VwciSllvK3cUwrDljo8khSHu", "Rui Pinto"      ),
("TiagooGomess", "$2y$12$zk0AAfNkceZO/mWEuy1NyutU5G9tWwnZAee2S3BJvRcWqxK9APmC2", "Tiago Gomes"    ),
("Asdrubal007" , "$2y$12$OEXd2oJuhCXbbeR5PHoka.Ia34mWEFb57QZktugj4gvMVZ3kBVM9C", "Asdrubal"       ),
("balves"      , "$2y$12$cT/o/IB5m8b3qorTIMIJCO2NY6Kojx5qcUpSTsR0yD6rgRUpup6HS", "Bernardo Alves" ),
("harold"      , "$2y$12$/4T.xjbm/zQL0/7dokZzbOW5X3zyi2I.1LvKVulki0U8.TDnUHMRe", "Harold"         ),
("Romanoff123" , "$2y$12$JnFOKQEtl4H2Z1uskJHijubPMLT.B7JRSrOfnIpoR9CZVamGYXPVm", "Romanoff"       ),
('AAOrg'       , "$2y$12$yEQM.B.ns.Ck3y6QANAnWe.xe99OR.Wj/G0QVdb8zVrLKWZvDfDYC", 'AnimalAdoption' );

-- Shelter
INSERT INTO Shelter(username, location, description) VALUES
('AAOrg', 'Lisbon', 'We take care of animals.');

-- Admin
-- INSERT INTO Admin VALUES ("dmfr"), ("BrenoAccioly"), ("2dukes"), ("TiagooGomess");

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
