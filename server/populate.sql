.mode column
.headers ON

PRAGMA foreign_keys=ON;
PRAGMA encoding="UTF-8";

-- User
INSERT INTO User
(username      , password                                                      , email                       , name                             ) VALUES
("dmfr"        , "$2y$12$EoGlSpd.GFAjAfFdce4YwOXyJnYDuWgHHUQctTZSyGtVaOJlRvHXa", "dmfrodrigues2000@gmail.com", "Diogo Rodrigues"                ),
("BrenoAccioly", "$2y$12$HhHbS9d5oBM4tBI7FAktkOSQ.wSEVNViUu87ol10ZUmqD1wn2vhFW", "a@b.c"                     , "Breno Accioly"                  ),
("2dukes"      , "$2y$12$ECt9IhyVUdCo.puADzqPHO0Ej0mW2VwciSllvK3cUwrDljo8khSHu", "b@b.c"                     , "Rui Pinto"                      ),
("TiagooGomess", "$2y$12$zk0AAfNkceZO/mWEuy1NyutU5G9tWwnZAee2S3BJvRcWqxK9APmC2", "c@b.c"                     , "Tiago Gomes"                    ),
("Asdrubal007" , "$2y$12$OEXd2oJuhCXbbeR5PHoka.Ia34mWEFb57QZktugj4gvMVZ3kBVM9C", "d@b.c"                     , "Asdrubal"                       ),
("balves"      , "$2y$12$cT/o/IB5m8b3qorTIMIJCO2NY6Kojx5qcUpSTsR0yD6rgRUpup6HS", "e@b.c"                     , "Bernardo Alves"                 ),
("harold"      , "$2y$12$/4T.xjbm/zQL0/7dokZzbOW5X3zyi2I.1LvKVulki0U8.TDnUHMRe", "f@b.c"                     , "Harold"                         ),
("Romanoff123" , "$2y$12$JnFOKQEtl4H2Z1uskJHijubPMLT.B7JRSrOfnIpoR9CZVamGYXPVm", "g@b.c"                     , "Romanoff"                       ),
('AAOrg'       , "$2y$12$yEQM.B.ns.Ck3y6QANAnWe.xe99OR.Wj/G0QVdb8zVrLKWZvDfDYC", "h@b.c"                     , 'AnimalAdoption'                 ),
('APA'         , "$2y$12$tZg0pfo16a82dBUv1iYaZOlGOsssnXULAESxp7/srmlv3QTar1LIC", "i@b.c"                     , 'Associação Protetora de Animais'),
('SPA'         , "$2y$12$5B2Tz7oEF1hnbn/iwawJE.QktOot6yD180cjRc0WhVCfmnq/fz4MK", "j@b.c"                     , 'Sociedade Protetora de Animais' ),
('WFFA'        , "$2y$12$rpy6I9Rx78Y6si/IbIEQguke5p2crE.DOUQvMyoOW.U3FzqoFTWK.", "k@b.c"                     , 'We Fight For Animals'           );

-- Shelter
INSERT INTO Shelter(username, location, description) VALUES
('AAOrg', 'Lisbon' , 'We take care of animals.     '),
('APA'  , 'Braga'  , 'We love animals!             '),
('SPA'  , 'Lisbon' , 'Animals are everything to us!'),
('WFFA' , 'Algarve', 'Among animals we stand.      ');

UPDATE User SET shelter = 'AAOrg' WHERE username = 'dmfr';
UPDATE User SET shelter = 'AAOrg' WHERE username = 'BrenoAccioly';

-- Admin
-- INSERT INTO Admin VALUES ("dmfr"), ("BrenoAccioly"), ("2dukes"), ("TiagooGomess");

-- Pet
INSERT INTO Pet
(name          , species, age, sex, size, color  ,  location , description               , status       , postedBy      ) VALUES
(   'Kitty'    ,   'Cat',   3, 'F',  'S', 'White',  'Marvila', 'Very cute cat.'          , 'forAdoption', '2dukes'      ),
( 'Belinha'    ,   'Cat',   3, 'F',  'S', 'White',  'Marvila', 'Very cute cat.'          , 'forAdoption', 'TiagooGomess'),
('Princesa'    ,   'Cat',   5, 'M', 'XS',  'Gray',   'Olaias', 'Another very cute cat.'  , 'forAdoption', 'dmfr'        ),
(   'Oscar'    ,   'Cat',   1, 'M',  'S', 'White',     'Gaia', 'Just a white cat.'       , 'adopted'    , 'dmfr'        ),
(    'Abby'    ,   'Dog',   2, 'F',  'L', 'White', 'Barcelos', 'Very cute puppy.'        , 'forAdoption', '2dukes'      ),
(   'Flash'    ,   'Dog',   3, 'F', 'XL', 'Black',    'Braga', 'Very cute puppy.'        , 'forAdoption', 'TiagooGomess'),
(   'Haley'    ,   'Dog',   5, 'M',  'L',  'Gray',    'Porto', 'Another very cute puppy.', 'forAdoption', 'dmfr'        ),
(   'Raven'    , 'Snake',   6, 'M',  'S', 'Brown',     'Gaia', 'Just a white puppy.'     , 'forAdoption', 'BrenoAccioly'),
(   'Bolt'    ,    'Dog',   3, 'F',  'S', 'White',    'Minho', 'Very cute dog.'          , 'forAdoption', '2dukes'      ),
('Ratatouille' , 'Mouse',   3, 'F',  'S', 'White',  'Marvila', 'Very cute cat.'          , 'adopted'    , 'TiagooGomess'),
('Princesa'    ,   'Cat',   5, 'M', 'XS',  'Gray',   'Olaias', 'Another very cute cat.'  , 'forAdoption', 'dmfr'        ),
(   'Oscar'    ,  'Lion',   1, 'M',  'S', 'White',     'Gaia', 'Just a white cat.'       , 'forAdoption', 'dmfr'        );


-- Comment
INSERT INTO Comment(id, pet, user, text, answerTo) VALUES
(1, 1, 'Asdrubal007'   , 'A simple comment.'        , NULL),
(2, 1, 'dmfr'          , 'Hello!'                   , NULL),
(3, 1, 'Asdrubal007'   , 'Another simple comment.'  , 1   ),
(4, 2, 'TiagooGomess'  , 'A simple comment.'        , NULL),
(5, 3, '2dukes'        , 'Hello!'                   , NULL),
(6, 4, 'Asdrubal007'   , 'A simple comment.'        , NULL),
(7, 5, 'dmfr'          , 'Hello!'                   , NULL),
(8, 5, 'Asdrubal007'   , 'A simple comment.'        , 7   ),
(9, 6, 'dmfr'          , 'Hello!'                   , NULL);

-- FavoritePet
INSERT INTO FavoritePet(username, petId) VALUES
('Romanoff123'    , 1),
('dmfr'           , 1),
('dmfr'           , 8),
('dmfr'           , 9),
('dmfr'           , 10),
('2dukes'         , 2),
('TiagooGomess'   , 1);


INSERT INTO AdoptionRequest(text, outcome, pet, user, messageDate) VALUES
('I want to adopt your pet!', 'pending' , 3 , '2dukes'       , '2020-12-17 19:51:55'),
('I want to adopt your pet!', 'pending' , 3 , 'TiagooGomess' , '2020-12-17 19:51:55'),
('I want to adopt your pet!', 'pending' , 3 , 'BrenoAccioly' , '2020-12-17 19:51:55'),
('I want to adopt your pet!', 'accepted', 4 , '2dukes'       , '2020-12-17 19:51:55'),
('I want to adopt your pet!', 'accepted', 4 , '2dukes'       , '2020-12-17 19:51:55'),
('I want to adopt your pet!', 'accepted', 10, 'dmfr'         , '2020-12-17 19:51:55');


INSERT INTO ShelterInvite(text, user, shelter, requestDate) VALUES
('Please join us!', 'dmfr', 'AAOrg', '2020-12-17 19:51:55'),
('Please join us!', 'dmfr',  'WFFA', '2020-12-17 19:51:55');



