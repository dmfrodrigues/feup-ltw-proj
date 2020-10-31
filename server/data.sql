-- Password is equal to username
INSERT INTO User(username, password, name, pictureUrl) VALUES
("dmfr", "eff14f9ad2f2ecaa8df1ebb50fc7113d2eac89cb", "Diogo Rodrigues", "https://avatars3.githubusercontent.com/u/43684166?s=400&u=03a088a2de6621066111b4d05f40d7489abd494d&v=4"),
("BrenoAccioly", "6ee278a3b837d564187ccb3ecc877057701eb7b2", "Breno Accioly", "https://avatars3.githubusercontent.com/u/43919387?s=400&u=dd552fba69b0469db1c0bb3911e13fd46733bd4d&v=4"),
("2dukes", "463e890d73f5d6d1f3b1268ee7e426933370f8cb", "Rui Pinto", "https://avatars0.githubusercontent.com/u/22317258?s=400&u=392e493cb6abe197adf4c572550abafcf9db7f27&v=4"),
("TiagooGomess", "0d47223986b750aecf2607ee8f26c58f7fe31e3a", "Tiago Gomes", "https://avatars3.githubusercontent.com/u/50210213?s=400&u=037938f7505165a289343a0fb9c7cfac66b29cfd&v=4"),
("asa", , "Arnaldo dos Santos Almeida", "https://picsum.photos/seed/picsum/400/400"),
("balves", , "Bernardo Alves", "https://picsum.photos/seed/picsum/400/400"),
("amz", , "Ana Maria Zevedo", "https://picsum.photos/seed/picsum/400/400")
;

INSERT INTO Admin VALUES ("dmfr"), ("BrenoAccioly"), ("2dukes"), ("TiagooGomess");

INSERT INTO Pet(id, name, species, size, color, location, description, status, postedBy) VALUES
(1, "Tareco", "cat", "S", "black", "FEUP", "Lorem ipsum dolor sit amet.", "forAdoption", "dmfr");

INSERT INTO PetPhoto(petId, url)
(1, "http://7-themes.com/data_images/out/12/6809883-small-black-cat.jpg");
