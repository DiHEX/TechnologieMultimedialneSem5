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