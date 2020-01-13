This is the commands to create the tables of the database

CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR(255), email VARCHAR(255), password VARCHAR(255), biography VARCHAR(255), avatar VARCHAR(255));

CREATE TABLE posts (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, image VARCHAR(255), description VARCHAR(255));

CREATE TABLE likes (id INTEGER PRIMARY KEY AUTOINCREMENT, post_id INTEGER, user_id INTEGER, liked VARCHAR(50), disliked VARCHAR(50));
