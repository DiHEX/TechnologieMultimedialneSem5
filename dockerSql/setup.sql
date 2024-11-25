CREATE TABLE `users` (
    `id` smallint(6) NOT NULL,
    `username` varchar(128) COLLATE utf8_polish_ci NOT NULL,
    `password` varchar(128) COLLATE utf8_polish_ci NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

ALTER TABLE `users` ADD PRIMARY KEY (`id`);

ALTER TABLE `users` MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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