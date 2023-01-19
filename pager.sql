-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Sty 2023, 11:13
-- Wersja serwera: 10.4.25-MariaDB
-- Wersja PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `pager`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `connection_user_thread`
--

CREATE TABLE `connection_user_thread` (
  `connection_user_id` int(11) NOT NULL,
  `connection_thread_id` int(11) NOT NULL,
  `connection_view_power` int(4) NOT NULL,
  `connection_is_owner` tinyint(1) NOT NULL,
  `connection_edit_permission` tinyint(1) NOT NULL,
  `connection_delete_permission` tinyint(1) NOT NULL,
  `connection_create_power` int(4) NOT NULL,
  `connection_complete_permission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `task_data`
--

CREATE TABLE `task_data` (
  `task_id` int(11) NOT NULL,
  `task_thread_id` int(11) NOT NULL,
  `task_user_id` int(11) NOT NULL,
  `task_title` varchar(256) NOT NULL,
  `task_content` varchar(2024) NOT NULL,
  `task_create_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `task_edit_timestamp` int(11) NOT NULL DEFAULT current_timestamp(),
  `task_power` int(4) NOT NULL,
  `task_is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `task_is_pinned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `thread_data`
--

CREATE TABLE `thread_data` (
  `thread_id` int(11) NOT NULL,
  `thread_owner_id` int(11) NOT NULL,
  `thread_name` varchar(64) NOT NULL,
  `thread_version` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_data`
--

CREATE TABLE `user_data` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_name` varchar(64) NOT NULL,
  `user_is_admin` tinyint(1) NOT NULL,
  `user_last_active` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `task_data`
--
ALTER TABLE `task_data`
  ADD PRIMARY KEY (`task_id`);

--
-- Indeksy dla tabeli `thread_data`
--
ALTER TABLE `thread_data`
  ADD PRIMARY KEY (`thread_id`);

--
-- Indeksy dla tabeli `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `task_data`
--
ALTER TABLE `task_data`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `thread_data`
--
ALTER TABLE `thread_data`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `user_data`
--
ALTER TABLE `user_data`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
