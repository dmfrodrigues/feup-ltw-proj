rm -f *.db

sqlite3 database.db ".read script.sql"
sqlite3 database.db ".read populate.sql"

chmod 777 database.db

mkdir -p resources/img/profiles
curl -L "https://avatars3.githubusercontent.com/u/43684166?s=400&u=03a088a2de6621066111b4d05f40d7489abd494d&v=4" --output resources/img/profiles/dmfr.jpg
curl -L "https://avatars3.githubusercontent.com/u/43919387?s=400&u=dd552fba69b0469db1c0bb3911e13fd46733bd4d&v=4" --output resources/img/profiles/BrenoAccioly.jpg
curl -L "https://avatars0.githubusercontent.com/u/22317258?s=400&u=392e493cb6abe197adf4c572550abafcf9db7f27&v=4" --output resources/img/profiles/2dukes.jpg
curl -L "https://avatars3.githubusercontent.com/u/50210213?s=400&u=037938f7505165a289343a0fb9c7cfac66b29cfd&v=4" --output resources/img/profiles/TiagooGomess.jpg
curl -L "https://picsum.photos/seed/picsum/400/400"                                                              --output resources/img/profiles/Asdrubal007.jpg
curl -L "https://picsum.photos/seed/picsum/400/400"                                                              --output resources/img/profiles/balves.jpg
curl -L "https://picsum.photos/seed/picsum/400/400"                                                              --output resources/img/profiles/Romanoff123.jpg
curl -L "https://dailynewshungary.com/wp-content/uploads/2018/01/18622628_146041712604173_5023056421634447578_n.jpg" --output resources/img/profiles/harold.jpg

mkdir -p resources/img/pets
mkdir -p resources/img/pets/1
curl -L "https://news.rspca.org.uk/wp-content/uploads/black-cats-1024x705.jpg"                                          --output resources/img/pets/1/000.jpg
curl -L "https://images.pexels.com/photos/7470/eyes-cats-cat-couch.jpg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260"    --output resources/img/pets/1/001.jpg
curl -L "https://images.pexels.com/photos/881142/pexels-photo-881142.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" --output resources/img/pets/1/002.jpg

mkdir -p resources/img/pets/2

mkdir -p resources/img/pets/3

mkdir -p resources/img/pets/4
curl -L "https://t1.ea.ltmcdn.com/en/images/9/6/2/img_caring_for_a_white_cat_not_albino_1269_orig.jpg" --output resources/img/pets/4/000.jpg
curl -L "https://www.titania-foto.com/wp-content/uploads/2018/09/weisse-katze.jpg"                     --output resources/img/pets/4/001.jpg

mkdir -p resources/img/comments
curl -L "https://d17fnq9dkz9hgj.cloudfront.net/breed-uploads/2018/08/bombay-card-small.jpg" --output resources/img/comments/1.jpg
