-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Sze 18. 16:14
-- Kiszolgáló verziója: 10.4.27-MariaDB
-- PHP verzió: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `autoszerelo_munkalapok`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `autok`
--

CREATE TABLE `autok` (
  `auto_id` int(11) NOT NULL,
  `gyartasi_ev` int(11) NOT NULL,
  `gyartmany` varchar(30) NOT NULL,
  `szin` varchar(30) NOT NULL,
  `tulajdonos_neve` varchar(30) NOT NULL,
  `cime` varchar(30) NOT NULL,
  `rendszam` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `autok`
--

INSERT INTO `autok` (`auto_id`, `gyartasi_ev`, `gyartmany`, `szin`, `tulajdonos_neve`, `cime`, `rendszam`) VALUES
(11, 2000, 'Opel', 'fehér', 'Török Dorián', 'Bem u. 47', 'ASD-123'),
(18, 1998, 'Opel', 'fehér', 'Török Dorián', 'Bem u. 47', 'ASD-333'),
(29, 1998, 'Opel', 'fehér', 'Török Dorián', 'Bem u. 47', 'ASD-333'),
(105, 2003, 'Opel', 'fehér', 'Török Dorián', 'Bem u. 47', 'ASD-456');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `munkalapok`
--

CREATE TABLE `munkalapok` (
  `munkalap_id` int(11) NOT NULL,
  `oraallas` varchar(30) NOT NULL,
  `uzemanyagszint` varchar(30) NOT NULL,
  `rovid_leiras` varchar(100) NOT NULL,
  `ok` varchar(30) NOT NULL,
  `ev` int(30) NOT NULL,
  `honap_nap` varchar(30) NOT NULL,
  `munkadij` varchar(30) NOT NULL,
  `egysegar` varchar(30) NOT NULL,
  `megnevezes` varchar(100) NOT NULL,
  `auto_id` int(30) NOT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `munkalapok`
--

INSERT INTO `munkalapok` (`munkalap_id`, `oraallas`, `uzemanyagszint`, `rovid_leiras`, `ok`, `ev`, `honap_nap`, `munkadij`, `egysegar`, `megnevezes`, `auto_id`, `datum`) VALUES
(10, '12304', '4/4', 'TESZT', 'TESZT', 2023, '01.26', '1000', '1000', 'TESZT', 11, '0000-00-00'),
(17, '200', '3/4', 'TESZT', 'TESZT', 2023, '01.26', '10', '10', 'TESZT', 18, '2023-01-26'),
(28, '200', '3/4', 'TESZT', 'TESZT', 2023, '01.26', '10', '10', 'TESZT', 29, '2023-01-26'),
(102, '12304', '3/4', 'testt', 'testt', 2023, '02.22', '10 0000.-', '10 0000.-', 'testzt', 105, '2023-02-22');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `permission` varchar(5) NOT NULL,
  `session_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `permission`, `session_id`) VALUES
(0, 'admin', 'admin', 'admin', 'ou5unpff7j90784dfmm4kjb4gj');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users_data`
--

CREATE TABLE `users_data` (
  `id` int(11) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `about` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `profile_picture` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users_data`
--

INSERT INTO `users_data` (`id`, `surname`, `email`, `about`, `date`, `profile_picture`) VALUES
(0, 'Dr. Török Dorián', 'torok.dorian@gmail.com', 'Teszt üzenet', '2023-03-17', '');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `autok`
--
ALTER TABLE `autok`
  ADD PRIMARY KEY (`auto_id`);

--
-- A tábla indexei `munkalapok`
--
ALTER TABLE `munkalapok`
  ADD PRIMARY KEY (`munkalap_id`),
  ADD UNIQUE KEY `autó_id` (`auto_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users_data`
--
ALTER TABLE `users_data`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `autok`
--
ALTER TABLE `autok`
  MODIFY `auto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT a táblához `munkalapok`
--
ALTER TABLE `munkalapok`
  MODIFY `munkalap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `munkalapok`
--
ALTER TABLE `munkalapok`
  ADD CONSTRAINT `munkalapok_ibfk_1` FOREIGN KEY (`auto_id`) REFERENCES `autok` (`auto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `users_data`
--
ALTER TABLE `users_data`
  ADD CONSTRAINT `users_data_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
