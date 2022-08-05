-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 05 2022 г., 20:09
-- Версия сервера: 8.0.19
-- Версия PHP: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `offers`
--

CREATE TABLE `offers` (
  `id` int NOT NULL,
  `offer_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cost` int NOT NULL,
  `offer_url` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `theme` varchar(256) NOT NULL,
  `id_owner` int NOT NULL,
  `subscribers` int DEFAULT '0',
  `activity` varchar(8) NOT NULL DEFAULT 'YES'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `offers`
--

INSERT INTO `offers` (`id`, `offer_name`, `cost`, `offer_url`, `theme`, `id_owner`, `subscribers`, `activity`) VALUES
(1, 'q', 2, 'https://sf-rtisedSite.php', 'q', 2, 0, 'YES'),
(2, 'w', 2, 'https://sf-roject/2', 'd', 2, 2, 'YES'),
(3, 'a', 2, 'https://sf-3', 'c', 2, 2, 'NO'),
(4, 'c', 2, 'https://sf-project/example/advertisedSite1.php', 'v', 2, 1, 'YES'),
(5, 'm', 2, 'https://sf-project/example/advertisedSite2.php', 'q', 2, 0, 'YES'),
(6, 'z', 2, 'https://sf-project/example/advertisedSite3.php', 'q', 2, 1, 'YES'),
(7, 'x', 1, 'https://sf-project/example/advertisedSite.php', 'q', 2, 0, 'NO'),
(8, 'b', 1, 'https://sf-project/example/advertisedSite.php', 'q', 2, 1, 'NO'),
(10, 'h', 1, 'http://sf-project/index.php', 'fd', 2, 1, 'NO'),
(11, 'j', 1, 'https://sf-Site.php', 'd', 2, 0, 'NO'),
(12, 'l', 1, 'https://sf', 'bb', 3, 1, 'YES'),
(13, 't', 1, 'https://sf-project/example/advertisedSite.php', 'we', 2, 0, 'NO'),
(14, 'n', 1, 'https://sf-project/example/advertisedSite.php', 'gfg', 2, 0, 'NO'),
(15, 's', 2, 'https://sf-project/example/advertisedSite.php', 'r', 5, 0, 'YES'),
(16, 'ds', 3, 'https://sf-project/example/advertisedSite.php', 'we', 5, 0, 'NO');

-- --------------------------------------------------------

--
-- Структура таблицы `subscriptions`
--

CREATE TABLE `subscriptions` (
  `index` int NOT NULL,
  `offer_id` int NOT NULL,
  `webMaster_id` int NOT NULL,
  `owner_id` int NOT NULL,
  `link_cost` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subscriptions`
--

INSERT INTO `subscriptions` (`index`, `offer_id`, `webMaster_id`, `owner_id`, `link_cost`) VALUES
(34, 6, 1, 2, 1),
(36, 3, 1, 2, 2),
(41, 2, 6, 2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `cookie_token` varchar(256) DEFAULT NULL,
  `role` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `login`, `password`, `cookie_token`, `role`) VALUES
(1, 'rrr', '1f32aa4c9a1d2ea010adcf2348166a04', NULL, 'wm'),
(2, 'sss', 'd9b1d7db4cd6e70935368a1efb10e377', NULL, 'ad'),
(3, 'fff', 'd9b1d7db4cd6e70935368a1efb10e377', NULL, 'ad'),
(4, 'mmm', 'd9b1d7db4cd6e70935368a1efb10e377', NULL, 'wm'),
(5, 'ppp', 'ec6a6536ca304edf844d1d248a4f08dc', NULL, 'ad'),
(6, 'hhh', 'ec6a6536ca304edf844d1d248a4f08dc', NULL, 'wm');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`offer_name`),
  ADD UNIQUE KEY `offer_name` (`offer_name`),
  ADD KEY `id_owner` (`id_owner`);

--
-- Индексы таблицы `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`index`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `index` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`id_owner`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
