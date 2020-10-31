-- Password is equal to username
INSERT INTO User
(username      , password                                  , name                        , pictureUrl                                                                                              ) VALUES
("dmfr"        , "eff14f9ad2f2ecaa8df1ebb50fc7113d2eac89cb", "Diogo Rodrigues"           , "https://avatars3.githubusercontent.com/u/43684166?s=400&u=03a088a2de6621066111b4d05f40d7489abd494d&v=4"),
("BrenoAccioly", "6ee278a3b837d564187ccb3ecc877057701eb7b2", "Breno Accioly"             , "https://avatars3.githubusercontent.com/u/43919387?s=400&u=dd552fba69b0469db1c0bb3911e13fd46733bd4d&v=4"),
("2dukes"      , "463e890d73f5d6d1f3b1268ee7e426933370f8cb", "Rui Pinto"                 , "https://avatars0.githubusercontent.com/u/22317258?s=400&u=392e493cb6abe197adf4c572550abafcf9db7f27&v=4"),
("TiagooGomess", "0d47223986b750aecf2607ee8f26c58f7fe31e3a", "Tiago Gomes"               , "https://avatars3.githubusercontent.com/u/50210213?s=400&u=037938f7505165a289343a0fb9c7cfac66b29cfd&v=4"),
("asa"         , "65417b70a1a7bd08a6189f4d309d90979cbe7b56", "Arnaldo dos Santos Almeida", "https://picsum.photos/seed/picsum/400/400"                                                             ),
("balves"      , "c00ab69a0a4826bb8f8fb5bdf68503f92183a9be", "Bernardo Alves"            , "https://picsum.photos/seed/picsum/400/400"                                                             ),
("amz"         , "013564dc05c22e397a30d38805fae295ef8cb4cc", "Ana Maria Zevedo"          , "https://picsum.photos/seed/picsum/400/400"                                                             );

INSERT INTO Admin VALUES ("dmfr"), ("BrenoAccioly"), ("2dukes"), ("TiagooGomess");

INSERT INTO Pet(id, name, species, size, color, location, status, postedBy, photoUrl, description) VALUES
(1, "Tareco", "cat", "S", "black", "FEUP", "forAdoption", "dmfr", "https://news.rspca.org.uk/wp-content/uploads/black-cats-1024x705.jpg",
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mollis rhoncus dignissim. Nam ut iaculis sapien. Sed tristique tortor et tellus gravida, tincidunt commodo nisl condimentum. Aliquam at lorem consectetur, lobortis sapien eu, ornare nibh. Aenean cursus nunc egestas, euismod nibh ac, consectetur erat. Suspendisse congue nec quam nec mollis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer posuere euismod tellus sit amet ornare. Nulla eu nunc eget nulla condimentum faucibus. Integer consequat leo ac consectetur ultricies. Vestibulum quis iaculis orci. Donec vestibulum magna arcu, id tristique odio vehicula faucibus.

Fusce auctor a sapien vel rhoncus. Suspendisse eu pretium elit. Vestibulum risus nunc, bibendum non varius vel, pharetra sit amet odio. Phasellus ac nibh pharetra, iaculis diam quis, tincidunt magna. Integer lobortis nulla sed augue facilisis aliquam. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec mollis arcu quis hendrerit feugiat. Aliquam euismod, dolor sed volutpat sollicitudin, nulla velit blandit dui, id accumsan mauris turpis semper nisi. Aenean auctor sit amet dui ac imperdiet. Vivamus mi nisi, sagittis varius massa ac, iaculis efficitur erat. Nulla feugiat facilisis nulla a imperdiet. Vivamus non tristique nisl, id rhoncus justo. Sed gravida, urna nec cursus vestibulum, enim ante faucibus risus, id volutpat eros massa nec nisi.

Ut mollis tincidunt diam. Integer eleifend diam quis lorem eleifend ullamcorper. Phasellus id tincidunt felis. Aenean maximus tellus lectus, sit amet pulvinar dolor maximus at. Ut nec orci ut lectus imperdiet congue ac ut diam. Aenean aliquam sollicitudin turpis id pharetra. Donec accumsan sagittis mi, et consequat nisl hendrerit et. Vivamus fringilla metus vitae purus lobortis, vel euismod dui dignissim.');
