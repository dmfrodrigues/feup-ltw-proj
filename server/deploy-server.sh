rm *.db
sqlite3 database.db ".read script.sql"
sqlite3 database.db ".read data.sql"
