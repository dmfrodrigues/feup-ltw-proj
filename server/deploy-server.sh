rm *.db

sqlite3 database.db ".read script.sql"
sqlite3 database.db ".read populate.sql"

mkdir -p resources/img/profiles
cd resources/img/profiles
curl -L "https://avatars3.githubusercontent.com/u/43684166?s=400&u=03a088a2de6621066111b4d05f40d7489abd494d&v=4" --output dmfr.jpg
curl -L "https://avatars3.githubusercontent.com/u/43919387?s=400&u=dd552fba69b0469db1c0bb3911e13fd46733bd4d&v=4" --output BrenoAccioly.jpg
curl -L "https://avatars0.githubusercontent.com/u/22317258?s=400&u=392e493cb6abe197adf4c572550abafcf9db7f27&v=4" --output 2dukes.jpg
curl -L "https://avatars3.githubusercontent.com/u/50210213?s=400&u=037938f7505165a289343a0fb9c7cfac66b29cfd&v=4" --output TiagooGomess.jpg
curl -L "https://picsum.photos/seed/picsum/400/400"                                                              --output Asdrubal007.jpg
curl -L "https://picsum.photos/seed/picsum/400/400"                                                              --output balves.jpg
curl -L "https://picsum.photos/seed/picsum/400/400"                                                              --output Romanoff123.jpg
cd ../../..

mkdir -p resources/img/pets
cd resources/img/pets

mkdir -p 1
curl -L "https://news.rspca.org.uk/wp-content/uploads/black-cats-1024x705.jpg" --output 1/001.jpg
curl -L "https://images.pexels.com/photos/7470/eyes-cats-cat-couch.jpg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" --output 1/002.jpg
curl -L "https://images.pexels.com/photos/881142/pexels-photo-881142.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" --output 1/003.jpg


mkdir -p 2
