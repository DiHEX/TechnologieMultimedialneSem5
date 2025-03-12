CREATE DATABASE IF NOT EXISTS tm_mysql_database;
USE tm_mysql_database;

CREATE TABLE `users` (
    `id` smallint(6) NOT NULL,
    `username` varchar(128) COLLATE utf8_polish_ci NOT NULL,
    `password` varchar(128) COLLATE utf8_polish_ci NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

ALTER TABLE `users` ADD PRIMARY KEY (`id`);

ALTER TABLE `users` MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO 
    `users` (`id`, `username`, `password`) 
VALUES
    (1, 'user1', 'pass1'),
    (2, 'user2', 'pass2');


CREATE TABLE goscieportalu (
    id SERIAL PRIMARY KEY, -- Automatyczne numerowanie ID (dla baz danych takich jak PostgreSQL)
    region VARCHAR(100), -- Region użytkownika
    country VARCHAR(100), -- Kraj użytkownika
    city VARCHAR(100), -- Miasto użytkownika
    location VARCHAR(255), -- Lokalizacja użytkownika (np. współrzędne)
    ipaddress VARCHAR(45), -- Adres IP użytkownika (IPv4 lub IPv6)
    datetime DATETIME, -- Czas wizyty (domyślnie obecny czas)
    browsername VARCHAR(100), -- Nazwa przeglądarki
    screenresolution VARCHAR(50), -- Rozdzielczość ekranu
    browserresolution VARCHAR(50), -- Rozdzielczość okna przeglądarki
    colors VARCHAR(20), -- Głębia kolorów
    cookiesenabled BOOLEAN, -- Czy ciasteczka są włączone
    java_enabled BOOLEAN, -- Czy Java jest włączona
    language VARCHAR(50), -- Język przeglądarki
    ilosc INT DEFAULT 0
);


CREATE TABLE `hosts` (
  `id` smallint(6) NOT NULL,
  `host` text NOT NULL,
  `port` int NOT NULL,
  `userId` smallint(6),
  FOREIGN KEY (`userId`) REFERENCES `users`(`id`)
);

ALTER TABLE `hosts` ADD PRIMARY KEY (`id`);

ALTER TABLE `hosts` MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- Create table for login history
CREATE TABLE login_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    ip_address VARCHAR(255),
    loc VARCHAR(255),
    user_agent VARCHAR(255),
    login_time VARCHAR(255)
);

-- Create table for invalid logins
CREATE TABLE invalid_logins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    last_entry_date VARCHAR(255),
    last_ip_address VARCHAR(255),
    count INT
);


CREATE TABLE playlistname (
    idpl INT AUTO_INCREMENT PRIMARY KEY,
    idu INT,
    name VARCHAR(255),
    public BOOLEAN ,
    datetime VARCHAR(255)
);

CREATE TABLE songs (
    ids INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    musician VARCHAR(255),
    datetime VARCHAR(255),
    idu INT,
    filename VARCHAR(255),
    lyrics VARCHAR(255),
    idmt INT
);


CREATE TABLE musictype(
    idmt INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE playlistdatabase (
    idpldb INT AUTO_INCREMENT PRIMARY KEY,
    idpl INT,
    ids INT,
    FOREIGN KEY (idpl) REFERENCES playlistname(idpl),
    FOREIGN KEY (ids) REFERENCES songs(ids)
);

INSERT INTO musictype (idmt, name) VALUES
(1, 'pop'),
(2, 'rock'),
(3, 'hip-hop'),
(4, 'electronic dance'),
(5, 'R&B'),
(6, 'latin'),
(7, 'country'),
(8, 'metal'),
(9, 'jazz'),
(10, 'classic'),
(11, 'inny');



CREATE TABLE films (
    ids INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    director VARCHAR(255),
    datetime VARCHAR(255),
    idu INT,
    filename VARCHAR(255),
    subtitle VARCHAR(255),
    idft INT
);

CREATE TABLE filmtype (
    idft INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE playlistnameFilms (
    idpl INT AUTO_INCREMENT PRIMARY KEY,
    idu INT,
    name VARCHAR(255),
    public BOOLEAN,
    datetime VARCHAR(255)
);

CREATE TABLE playlistdatabaseFilms (
    idpldb INT AUTO_INCREMENT PRIMARY KEY,
    idpl INT,
    ids INT,
    FOREIGN KEY (idpl) REFERENCES playlistnameFilms(idpl),
    FOREIGN KEY (ids) REFERENCES films(ids)
);


INSERT INTO filmtype (idft, name) VALUES
(1, 'dokument'),
(2, 'reportaż'),
(3, 'publicystyka'),
(4, 'film akcji'),
(5, 'sci-fi'),
(6, 'horror'),
(7, 'familijny'),
(8, 'przyrodniczy'),
(9, 'koncert'),
(10, 'animowany'),
(11, 'inny');



CREATE DATABASE IF NOT EXISTS tm_mysql_zadanie7;
USE tm_mysql_zadanie7;

CREATE TABLE ajax_from_db (
  id smallint(6) NOT NULL,
  text1 VARCHAR(40),
  datetime DATETIME DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE ajax_from_db ADD PRIMARY KEY (id);

ALTER TABLE ajax_from_db MODIFY id smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO ajax_from_db (text1) VALUES
('test1');

CREATE TABLE pomiary (
    id INT AUTO_INCREMENT PRIMARY KEY,
    x1 FLOAT,
    x2 FLOAT,
    x3 FLOAT,
    x4 FLOAT,
    x5 FLOAT,
    datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO pomiary (x1, x2, x3, x4, x5) VALUES
(1.1, 2.2, 3.3, 4.4, 5.5);


CREATE DATABASE IF NOT EXISTS tm_mysql_zadanie9;
USE tm_mysql_zadanie9;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    ip VARCHAR(45),
    registration_date DATETIME
);

CREATE TABLE IF NOT EXISTS messages (
    idk INT AUTO_INCREMENT PRIMARY KEY,
    datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    message TEXT,
    user VARCHAR(50),
    recipient VARCHAR(50),
    attachment_url VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS login_history (
    entry_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    login_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    loc VARCHAR(50),
    user_agent TEXT
);

CREATE TABLE IF NOT EXISTS invalid_logins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    count INT,
    last_entry_date DATETIME
);

INSERT INTO users (username, password, ip, registration_date) VALUES
('admin', 'admin', '8.8.8.8', NOW());