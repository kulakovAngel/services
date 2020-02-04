-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 04 2020 г., 17:39
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `services`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_service` int(11) NOT NULL,
  `date` date NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `id_service`, `date`, `done`) VALUES
(34, 2, 1, '2020-02-04', 0),
(35, 3, 1, '2020-02-20', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `done` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `done`) VALUES
(1, 'Nice Service', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas pellentesque viverra nulla vitae laoreet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam venenatis sem ac diam dictum, ac pretium risus lacinia. Praesent in quam congue, scelerisque ante vel, volutpat felis. Donec est sapien, ultricies a quam in, interdum vulputate ante. Duis vel ex justo. Morbi odio lorem, varius sit amet urna a, vehicula accumsan arcu. Suspendisse tempus iaculis nibh at bibendum. Mauris lectus sem, pulvinar sit amet consectetur at, scelerisque ac nunc. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.', 0),
(2, 'Second Service', 'Maecenas nec magna vitae lacus ornare lacinia at nec urna. Pellentesque malesuada, eros at faucibus dapibus, purus velit ultrices nisl, et commodo nunc ligula varius magna. Aenean vitae dui arcu. Donec efficitur urna elit, at gravida dui bibendum id. Curabitur ligula urna, faucibus id enim et, commodo maximus massa. Ut ac nibh quis risus tincidunt auctor. Mauris sapien nisi, rutrum eget convallis ut, mollis in tortor. Donec gravida augue eu nunc dictum pharetra. Donec tristique nibh risus, pulvinar ultricies libero aliquet vel.', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rights` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `hash`, `rights`) VALUES
(1, 'Vasilij', 'vas', '$2y$10$fZdzxX31u0rFbYShaoGrxuP7917q0gHHAc/pnKMgE7aTb/AoXwEEy', 2),
(2, 'Ivan Ivanovich', 'ivan', '$2y$10$fbjzTSHPK5bbzhPLGD.WQu4ollfjJ.SdjLa8hKCxyQY40CYu0qbNq', 1),
(3, 'a', 'a', '$2y$10$2bqFdhE04CnL5iLSj4kd3uDeAoJ8eJVctYGbTpxGSO3LPov3/YS7y', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_service` (`id_service`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_service`) REFERENCES `services` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
