-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 15 2025 г., 21:25
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `belyo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id_cart` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `act_price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id_categori` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id_categori`, `name`) VALUES
(3, 'Демисезонное'),
(2, 'Зимнее'),
(1, 'Летнее');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id_order` int NOT NULL,
  `id_user` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `created_at`, `id_status`) VALUES
(1, 1, '2025-03-28 13:54:30', 1),
(2, 1, '2025-03-28 14:43:21', 1),
(3, 1, '2025-03-31 22:26:31', 1),
(4, 1, '2025-04-01 11:33:01', 1),
(5, 1, '2025-04-03 19:12:04', 1),
(6, 1, '2025-04-10 20:27:31', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `order_prod`
--

CREATE TABLE `order_prod` (
  `id` int NOT NULL,
  `id_order` int NOT NULL,
  `id_product` int NOT NULL,
  `quantity` int NOT NULL,
  `act_price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `order_prod`
--

INSERT INTO `order_prod` (`id`, `id_order`, `id_product`, `quantity`, `act_price`) VALUES
(1, 1, 5, 1, 1800),
(2, 1, 4, 1, 4500),
(3, 1, 3, 1, 2900),
(4, 1, 2, 1, 3200),
(5, 1, 1, 1, 2500),
(6, 2, 3, 1, 2900),
(7, 3, 2, 3, 3200),
(8, 4, 5, 2, 1800),
(9, 5, 6, 1, 5600),
(10, 6, 2, 1, 3200);

-- --------------------------------------------------------

--
-- Структура таблицы `pol`
--

CREATE TABLE `pol` (
  `id_pola` int NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `pol`
--

INSERT INTO `pol` (`id_pola`, `name`) VALUES
(1, 'Мужчина'),
(2, 'Женщина');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id_product` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `kol_vo` int DEFAULT '0',
  `id_size` int NOT NULL,
  `image_url` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id_product`, `name`, `description`, `price`, `category_id`, `kol_vo`, `id_size`, `image_url`) VALUES
(1, 'Летний хлопковый комплект', 'Легкое постельное белье из 100% хлопка, идеально для летнего сезона.', 2500, 1, 9, 3, 'https://nauka-sna.ru/im.xp/049057055051052.jpg'),
(2, 'Зимний фланелевый комплект', 'Теплое и уютное постельное белье из фланели, отлично сохраняет тепло.', 3200, 2, 3, 4, 'https://img.joomcdn.net/e1df056a79c03d90dec989b3dc771163647d3483_original.jpeg'),
(3, 'Демисезонный сатиновый комплект', 'Мягкое и гладкое белье из сатина, подходит для любого времени года.', 2900, 3, 10, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRrySrqBM7pg4cu75GIrikic3u7CA3Ilr1BCQ&s'),
(4, 'Семейный комплект с вышивкой', 'Роскошное постельное белье с декоративной вышивкой, комплект для всей семьи.', 4500, 3, 4, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMULGOSUkjvqzz2IdpMzRiwVK868oCTB4hVw&s'),
(5, 'Детский комплект с принтом', 'Яркое и мягкое детское белье с веселыми рисунками.', 1800, 1, 12, 1, 'https://linobambino.ru/upload/iblock/1a7/82lqs08365eaf3rir6djhdqizcn1oivv.jpg'),
(6, 'Демисезонный хлопковый комплект', 'Мягкий и приятный комплект белья для всей семьи', 5600, 3, 64, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRKdpdl_Nk0aueMj2Uig_NU8gBatffnJYgKZQ&s');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id_role` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id_role`, `name`) VALUES
(1, 'Пользователь'),
(2, 'Админ');

-- --------------------------------------------------------

--
-- Структура таблицы `sizes`
--

CREATE TABLE `sizes` (
  `id_size` int NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `sizes`
--

INSERT INTO `sizes` (`id_size`, `name`) VALUES
(1, 'Детский'),
(2, 'Полуторный'),
(3, 'Евро'),
(4, 'Двухспальный'),
(5, 'Семейный');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id_status` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id_status`, `name`) VALUES
(1, 'В обработке'),
(2, 'Оплачен'),
(3, 'Получен');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `second_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_pol` int NOT NULL,
  `data_rozd` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_role` int NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `first_name`, `second_name`, `id_pol`, `data_rozd`, `email`, `password`, `id_role`, `created`) VALUES
(1, 'Антон', 'Иванов', 1, '2025-03-06', 'anton@gmail.com', 'antiva', 1, '2025-03-18 13:27:20'),
(4, 'Игорь', 'Иванов', 1, '1997-06-14', 'igor@gmail.com', 'igoriva', 1, '2025-04-11 13:52:08');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categori`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_status` (`id_status`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `order_prod`
--
ALTER TABLE `order_prod`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Индексы таблицы `pol`
--
ALTER TABLE `pol`
  ADD PRIMARY KEY (`id_pola`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `id_size` (`id_size`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Индексы таблицы `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id_size`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_pol` (`id_pol`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id_categori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `order_prod`
--
ALTER TABLE `order_prod`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id_product`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `order_prod`
--
ALTER TABLE `order_prod`
  ADD CONSTRAINT `order_prod_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_prod_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id_categori`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`id_size`) REFERENCES `sizes` (`id_size`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_pol`) REFERENCES `pol` (`id_pola`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
