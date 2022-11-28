-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20221125.2e001c186a
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2022 a las 06:53:37
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `codigoMesa` varchar(6) NOT NULL,
  `codigoPedido` varchar(6) NOT NULL,
  `notaMesa` int(11) NOT NULL,
  `notaRestaurante` int(11) NOT NULL,
  `notaMozo` int(11) NOT NULL,
  `notaCocinero` int(11) NOT NULL,
  `comentario` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id`, `codigoMesa`, `codigoPedido`, `notaMesa`, `notaRestaurante`, `notaMozo`, `notaCocinero`, `comentario`) VALUES
(1, '0GI28', '7TQQL', 8, 7, 7, 7, 'Comida abundante y buena relación precio-calidad'),
(2, '0GI28', '8SR61', 4, 3, 2, 5, 'La comida no es la gran cosa, tardo mucho el mozo, me llego frío y la mesa estaba sucia. No recomendado'),
(6, 'ATI38', '9JJE4', 7, 8, 9, 9, 'Muy rico todo!');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotospedidos`
--

CREATE TABLE `fotospedidos` (
  `id` int(11) NOT NULL,
  `codigoPedido` varchar(6) NOT NULL,
  `origen` varchar(300) NOT NULL,
  `destino` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `fotospedidos`
--

INSERT INTO `fotospedidos` (`id`, `codigoPedido`, `origen`, `destino`) VALUES
(30, '8SR61', 'C:xampp	mpphp46F2.tmp', 'ImagenesPedidos/0GI28/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loglogin`
--

CREATE TABLE `loglogin` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaLogin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `loglogin`
--

INSERT INTO `loglogin` (`id`, `idUsuario`, `fechaLogin`) VALUES
(3, 5, '2022-09-18 17:18:13'),
(5, 5, '2022-09-18 17:50:16'),
(6, 5, '2022-09-18 19:21:29'),
(7, 5, '2022-09-18 19:21:59'),
(8, 5, '2022-09-18 19:22:00'),
(9, 5, '2022-09-18 19:22:00'),
(10, 5, '2022-09-18 19:22:01'),
(11, 5, '2022-09-18 19:22:02'),
(12, 5, '2022-09-18 19:22:02'),
(13, 5, '2022-09-18 19:22:03'),
(14, 5, '2022-09-18 19:22:04'),
(15, 5, '2022-09-18 19:22:05'),
(16, 5, '2022-09-18 19:22:06'),
(17, 5, '2022-09-18 19:22:07'),
(18, 5, '2022-09-18 19:26:15'),
(19, 5, '2022-09-18 19:29:05'),
(20, 5, '2022-09-18 19:29:22'),
(21, 5, '2022-09-18 19:29:38'),
(22, 5, '2022-09-18 19:29:53'),
(23, 5, '2022-09-18 19:30:18'),
(24, 5, '2022-09-18 19:30:19'),
(25, 5, '2022-09-18 19:30:20'),
(26, 5, '2022-09-18 19:30:21'),
(27, 5, '2022-09-18 19:30:21'),
(28, 5, '2022-09-18 19:30:22'),
(29, 5, '2022-09-18 19:30:23'),
(30, 5, '2022-09-18 19:30:52'),
(31, 5, '2022-09-18 19:31:11'),
(32, 5, '2022-09-18 19:35:52'),
(33, 5, '2022-09-18 19:38:17'),
(34, 5, '2022-09-18 19:39:54'),
(35, 5, '2022-09-18 20:08:17'),
(36, 5, '2022-09-18 20:10:44'),
(37, 5, '2022-09-18 20:10:59'),
(38, 5, '2022-09-18 20:14:28'),
(39, 5, '2022-09-18 20:14:38'),
(40, 5, '2022-09-18 20:20:23'),
(41, 5, '2022-09-18 20:20:34'),
(42, 5, '2022-09-18 20:20:35'),
(43, 5, '2022-09-18 20:20:36'),
(44, 5, '2022-09-18 20:20:51'),
(45, 5, '2022-09-18 20:25:21'),
(46, 5, '2022-09-18 20:30:12'),
(47, 5, '2022-09-18 20:30:26'),
(48, 5, '2022-09-18 20:34:50'),
(49, 5, '2022-09-18 20:35:56'),
(50, 5, '2022-09-18 20:36:23'),
(51, 5, '2022-09-18 20:36:30'),
(52, 5, '2022-09-18 20:36:38'),
(53, 5, '2022-09-18 20:36:49'),
(54, 5, '2022-09-18 20:37:35'),
(55, 5, '2022-09-18 20:39:28'),
(56, 5, '2022-09-18 20:39:32'),
(57, 5, '2022-09-18 20:39:51'),
(58, 5, '2022-09-18 20:39:59'),
(59, 5, '2022-09-18 20:44:26'),
(60, 5, '2022-09-18 22:04:39'),
(61, 5, '2022-09-18 22:07:14'),
(62, 10, '2022-09-19 04:11:49'),
(63, 5, '2022-09-19 04:12:22'),
(64, 5, '2022-09-22 16:38:37'),
(65, 10, '2022-09-23 00:22:43'),
(66, 10, '2022-09-23 02:41:47'),
(67, 5, '2022-09-23 02:42:43'),
(68, 5, '2022-09-25 19:33:23'),
(69, 5, '2022-09-25 19:34:16'),
(70, 5, '2022-09-25 19:34:55'),
(71, 5, '2022-09-25 19:35:02'),
(72, 5, '2022-09-25 19:35:09'),
(73, 5, '2022-09-25 19:35:22'),
(74, 5, '2022-09-25 19:35:37'),
(75, 5, '2022-09-25 19:36:11'),
(76, 5, '2022-09-25 19:36:33'),
(77, 5, '2022-09-25 19:36:57'),
(78, 5, '2022-09-25 19:37:11'),
(79, 5, '2022-09-25 19:37:25'),
(80, 5, '2022-09-25 19:38:12'),
(81, 5, '2022-09-25 19:38:20'),
(82, 5, '2022-09-25 19:40:20'),
(83, 5, '2022-09-25 20:20:01'),
(84, 5, '2022-09-25 20:20:32'),
(85, 5, '2022-09-25 20:28:24'),
(86, 5, '2022-09-25 20:28:47'),
(87, 5, '2022-09-25 20:28:51'),
(88, 5, '2022-09-25 20:28:54'),
(89, 5, '2022-09-25 20:56:12'),
(90, 5, '2022-10-15 22:32:43'),
(91, 5, '2022-10-17 15:21:25'),
(92, 5, '2022-10-22 03:36:50'),
(93, 5, '2022-10-27 21:53:02'),
(94, 5, '2022-10-29 03:38:56'),
(95, 5, '2022-11-05 03:28:57'),
(96, 5, '2022-11-05 23:05:29'),
(97, 5, '2022-11-07 10:18:53'),
(98, 5, '2022-11-09 12:30:49'),
(99, 10, '2022-11-09 14:12:48'),
(100, 10, '2022-11-10 19:42:03'),
(101, 11, '2022-11-11 11:30:09'),
(102, 10, '2022-11-11 11:31:04'),
(103, 11, '2022-11-11 11:31:38'),
(104, 5, '2022-11-11 11:40:55'),
(105, 5, '2022-11-17 13:46:12'),
(106, 5, '2022-11-25 22:09:04'),
(107, 5, '2022-11-27 00:39:07'),
(108, 5, '2022-11-28 01:01:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logoperaciones`
--

CREATE TABLE `logoperaciones` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `operacion` varchar(250) NOT NULL,
  `fechaOperacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `logoperaciones`
--

INSERT INTO `logoperaciones` (`id`, `idUsuario`, `operacion`, `fechaOperacion`) VALUES
(4, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo al usuario con id 5 Octavio Villegas', '2022-09-19 02:13:20'),
(5, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com dio de alta un nuevo usuario llamado Eros Gonzalez con email juanlopez666@gmail.com', '2022-09-19 04:05:20'),
(6, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com dio de alta un nuevo usuario llamado Eros Gonzalez con email juanlopez666@gmail.com', '2022-09-19 04:05:49'),
(7, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com dio de alta un nuevo usuario llamado Eros Gonzalez con email erosgonzalez66@gmail.com', '2022-09-19 04:11:21'),
(8, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com listo a todos los usuarios activos ', '2022-09-19 04:11:56'),
(9, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com listo al usuario Octavio Villegas con email octaviovillegas@gmail.com', '2022-09-19 04:12:06'),
(10, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-09-19 04:12:26'),
(11, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo al usuario Octavio Villegas con email octaviovillegas@gmail.com', '2022-09-19 04:12:29'),
(12, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a SUSPENDIDO ', '2022-09-19 04:14:23'),
(13, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-09-19 04:14:31'),
(14, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a ACTIVO ', '2022-09-19 04:14:37'),
(15, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo al usuario Octavio Villegas con email octaviovillegas@gmail.com', '2022-09-19 04:14:42'),
(16, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-09-19 04:14:48'),
(17, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo al usuario Octavio Villegas con email octaviovillegas@gmail.com', '2022-09-22 16:38:43'),
(18, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-09-22 22:28:11'),
(19, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-09-22 22:29:44'),
(20, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-09-22 22:41:02'),
(21, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo al usuario Octavio Villegas con email octaviovillegas@gmail.com', '2022-09-23 02:42:51'),
(22, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-09-23 02:42:55'),
(23, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com creo un nuevo pedido con el codigo 95O:E para la mesa ', '2022-09-23 03:06:25'),
(24, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com creo un nuevo pedido con el codigo S0:GG para la mesa ', '2022-09-23 03:17:36'),
(25, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com creo un nuevo pedido con el codigo 8[R61 para la mesa 0GI28', '2022-09-23 03:18:06'),
(26, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Milanesa con Papas al pedido con codigo  para la mesa ', '2022-09-23 03:36:54'),
(27, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Milanesa con Papas al pedido con codigo  para la mesa ', '2022-09-23 03:37:49'),
(28, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Milanesa con Papas al pedido con codigo 8[R61 para la mesa 0GI28', '2022-09-23 03:38:22'),
(29, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-09-25 20:28:59'),
(30, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-09-25 20:56:32'),
(31, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo al usuario Octavio Villegas con email octaviovillegas@gmail.com', '2022-09-25 20:56:39'),
(32, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 20:59:59'),
(33, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:03:23'),
(34, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:04:58'),
(35, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:05:06'),
(36, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:05:20'),
(37, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:05:28'),
(38, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:06:21'),
(39, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:06:54'),
(40, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:08:00'),
(41, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:08:08'),
(42, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:08:12'),
(43, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:08:23'),
(44, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:10:59'),
(45, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:11:12'),
(46, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:12:09'),
(47, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:13:23'),
(48, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8[R61', '2022-09-25 21:13:35'),
(49, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 21:16:01'),
(50, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 21:16:47'),
(51, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 21:19:10'),
(52, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 21:20:33'),
(53, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 21:21:24'),
(54, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 21:24:34'),
(55, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 21:26:09'),
(56, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 21:26:25'),
(57, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 21:51:52'),
(58, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 21:58:33'),
(59, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 21:59:02'),
(60, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 22:01:42'),
(61, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 22:02:15'),
(62, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 22:06:50'),
(63, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 22:08:13'),
(64, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 22:08:32'),
(65, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 22:19:24'),
(66, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 22:19:53'),
(67, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 22:20:12'),
(68, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 22:21:01'),
(69, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 22:22:57'),
(70, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 23:51:00'),
(71, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 23:53:26'),
(72, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-25 23:53:44'),
(73, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-26 00:01:38'),
(74, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-26 00:02:22'),
(75, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-26 00:05:40'),
(76, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-26 00:06:43'),
(77, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-26 00:08:48'),
(78, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com saco una foto de la mesa con codigo 0GI28 para el pedido 8SR61', '2022-09-26 00:08:56'),
(79, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a 1 ', '2022-09-26 00:27:05'),
(80, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a activo ', '2022-09-26 00:28:37'),
(81, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a suspendido ', '2022-09-26 00:32:07'),
(82, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a eliminado ', '2022-09-26 00:32:34'),
(83, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a activo ', '2022-09-26 00:32:47'),
(84, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a suspendido ', '2022-09-26 00:32:58'),
(85, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a activo ', '2022-09-26 00:33:33'),
(86, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-09-26 00:53:18'),
(87, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo al usuario Octavio Villegas con email octaviovillegas@gmail.com', '2022-09-26 00:55:05'),
(88, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado de la mesa con código 0GI28 a  ', '2022-09-26 01:09:12'),
(89, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado de la mesa con código 0GI28 a cerrada ', '2022-09-26 01:10:47'),
(90, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado de la mesa con código 0GI28 a esperando ', '2022-09-26 01:10:59'),
(91, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado de la mesa con código 0GI28 a comiendo ', '2022-09-26 01:11:14'),
(92, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado de la mesa con código 0GI28 a pagando ', '2022-09-26 01:11:27'),
(93, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado de la mesa con código 0GI28 a  ', '2022-09-26 01:11:36'),
(94, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado de la mesa con código 0GI28 a cerrada ', '2022-09-26 01:14:47'),
(95, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-10-15 22:32:55'),
(96, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Cuba Libre al pedido con codigo 8SR61 para la mesa 0GI28', '2022-10-15 22:39:30'),
(97, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Milanesa con Papas al pedido con codigo 8SR61 para la mesa 0GI28', '2022-10-15 22:39:38'),
(98, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Milanesa con Papas al pedido con codigo 8SR61 para la mesa 0GI28', '2022-10-15 22:39:43'),
(99, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com creo un nuevo pedido con el codigo W93A8 para la mesa 0GI28', '2022-10-15 22:40:32'),
(100, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com creo un nuevo pedido con el codigo 7TQQL para la mesa 0GI28', '2022-10-15 22:41:40'),
(101, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Milanesa con Papas al pedido con codigo 8SR61 para la mesa 0GI28', '2022-10-15 23:27:36'),
(102, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Cuba Libre al pedido con codigo 8SR61 para la mesa 0GI28', '2022-10-15 23:27:45'),
(103, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Cuba Libre al pedido con codigo W93A8 para la mesa 0GI28', '2022-10-15 23:31:04'),
(104, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com creo un nuevo pedido con el codigo 9JJE4 para la mesa ATI38', '2022-10-16 00:10:40'),
(105, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com creo un nuevo pedido con el codigo EPATG para la mesa D7YSX', '2022-10-16 00:10:51'),
(106, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Cuba Libre al pedido con codigo 9JJE4 para la mesa ATI38', '2022-10-16 00:11:54'),
(107, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Milanesa con Papas al pedido con codigo 9JJE4 para la mesa ATI38', '2022-10-16 00:12:00'),
(108, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com cargo un producto Milanesa con Papas al pedido con codigo EPATG para la mesa D7YSX', '2022-10-16 00:12:16'),
(109, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 15:21:30'),
(110, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 15:31:37'),
(111, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 15:31:54'),
(112, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 15:33:22'),
(113, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 15:34:01'),
(114, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 15:35:07'),
(115, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 15:35:35'),
(116, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 15:40:00'),
(117, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 15:41:50'),
(118, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 15:41:52'),
(119, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 15:42:39'),
(120, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 15:42:40'),
(121, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 15:42:41'),
(122, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 15:42:42'),
(123, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 15:42:55'),
(124, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 15:42:56'),
(125, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 15:42:57'),
(126, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 15:43:34'),
(127, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 15:43:42'),
(128, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 16:21:10'),
(129, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:29:26'),
(130, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:30:28'),
(131, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:31:17'),
(132, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:31:55'),
(133, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:32:21'),
(134, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:32:37'),
(135, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:32:39'),
(136, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:32:40'),
(137, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:32:52'),
(138, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:33:40'),
(139, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:34:34'),
(140, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:34:45'),
(141, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:37:40'),
(142, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:37:48'),
(143, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:37:56'),
(144, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:38:23'),
(145, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:39:18'),
(146, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 16:48:12'),
(147, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 17:05:58'),
(148, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que menos dinero recaudaron', '2022-10-17 17:09:26'),
(149, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que menos dinero recaudaron', '2022-10-17 17:09:58'),
(150, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 17:10:13'),
(151, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que menos dinero recaudaron', '2022-10-17 17:10:18'),
(152, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 17:10:22'),
(153, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 17:19:04'),
(154, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 17:19:32'),
(155, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que más dinero recaudaron', '2022-10-17 17:33:33'),
(156, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las que menos dinero recaudaron', '2022-10-17 17:33:39'),
(157, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 17:58:31'),
(158, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 17:59:24'),
(159, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 18:05:27'),
(160, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 18:05:28'),
(161, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 18:06:22'),
(162, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 18:06:26'),
(163, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 18:06:29'),
(164, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 18:06:30'),
(165, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 18:06:33'),
(166, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 18:06:40'),
(167, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-10-17 18:08:01'),
(168, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-10-17 18:08:05'),
(169, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-10-17 18:18:48'),
(170, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-10-17 18:19:06'),
(171, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-10-17 18:53:02'),
(172, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-10-17 18:53:05'),
(173, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 18:57:58'),
(174, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-10-17 18:58:11'),
(175, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:00:25'),
(176, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:01:35'),
(177, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:01:53'),
(178, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:03:57'),
(179, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:04:08'),
(180, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:04:52'),
(181, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:05:19'),
(182, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:06:04'),
(183, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:06:11'),
(184, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:06:35'),
(185, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:07:02'),
(186, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:07:14'),
(187, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:08:18'),
(188, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:09:31'),
(189, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:09:32'),
(190, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:09:33'),
(191, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:09:34'),
(192, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:09:34'),
(193, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:09:35'),
(194, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:09:46'),
(195, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:09:48'),
(196, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:09:48'),
(197, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:10:11'),
(198, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:11:03'),
(199, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más barata', '2022-10-17 19:11:52'),
(200, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-17 19:12:08'),
(201, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre la mesa con código 0GI28', '2022-10-18 03:00:05'),
(202, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre la mesa con código 0GI28', '2022-10-18 03:03:51'),
(203, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas  y ', '2022-10-18 03:04:49'),
(204, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas  y ', '2022-10-18 03:05:34'),
(205, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas  y 09-11-2022', '2022-10-18 03:06:45'),
(206, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre la mesa con código 0GI28', '2022-10-18 03:16:31'),
(207, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas  y 09-11-2022', '2022-10-18 03:16:36'),
(208, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 05-11-2022 y 09-11-2022', '2022-10-18 03:17:35'),
(209, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 05-11-2022 y 09-11-2022', '2022-10-18 03:18:25'),
(210, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 05-10-2022 y 09-11-2022', '2022-10-18 03:18:35'),
(211, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-04 y 2022-10-11', '2022-10-18 03:19:28'),
(212, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-04 y 2022-10-9', '2022-10-18 03:19:38'),
(213, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-04 y 2022-10-09', '2022-10-18 03:19:42'),
(214, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-05 y 2022-10-09', '2022-10-18 03:19:47'),
(215, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-05 y 2022-10-14', '2022-10-18 03:19:55'),
(216, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-06 y 2022-10-14', '2022-10-18 03:20:01'),
(217, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-06 y 2022-10-12', '2022-10-18 03:20:06'),
(218, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-03 y 2022-10-12', '2022-10-18 03:20:12'),
(219, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-03 y 2022-10-19', '2022-10-18 03:20:17'),
(220, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-10-18 03:20:26'),
(221, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre la mesa con código 0GI28', '2022-10-18 04:08:55'),
(222, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre la mesa con código 0GI28', '2022-10-18 04:09:08'),
(223, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más barata', '2022-10-18 04:09:15'),
(224, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-10-18 04:16:37'),
(225, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre la mesa con código 0GI28', '2022-10-18 04:17:45'),
(226, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-10-18 04:17:50'),
(227, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-10-18 04:18:26'),
(228, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-10-18 04:19:33'),
(229, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-10-18 04:19:50'),
(230, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-10-18 04:21:33'),
(231, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-10-18 04:22:50'),
(232, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-10-22 03:37:54'),
(233, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-10-22 03:38:22'),
(234, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-10-22 03:41:12'),
(235, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-10-22 03:41:41'),
(236, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-10-22 03:41:45'),
(237, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-10-22 03:42:07'),
(238, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-10-22 03:42:11'),
(239, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 04:38:32'),
(240, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 04:39:07'),
(241, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 04:40:14'),
(242, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:08:30'),
(243, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:13:09'),
(244, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:13:30'),
(245, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:18:54'),
(246, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:18:55'),
(247, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:19:21'),
(248, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:20:16'),
(249, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:21:30'),
(250, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:21:55'),
(251, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:22:07'),
(252, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:22:26'),
(253, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:27:33'),
(254, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:27:44'),
(255, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:27:45'),
(256, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:27:48'),
(257, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:27:49'),
(258, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:27:51'),
(259, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-22 05:36:06'),
(260, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos cancelados', '2022-10-22 05:41:54'),
(261, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-10-27 21:53:05'),
(262, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo al usuario Octavio Villegas con email octaviovillegas@gmail.com', '2022-10-27 21:53:13'),
(263, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-10-27 22:41:21'),
(264, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-10-27 22:41:28'),
(265, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-27 22:41:38'),
(266, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-10-29 03:39:16'),
(267, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-10-29 03:39:21'),
(268, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-10-29 03:39:26'),
(269, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-10-29 03:44:56'),
(270, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-10-29 03:45:05'),
(271, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre la mesa con código 0GI28', '2022-10-29 03:46:12'),
(272, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-10-29 04:07:34'),
(273, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-10-29 04:07:41'),
(274, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-29 04:07:47'),
(275, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-10-29 05:22:34'),
(276, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos en estado terminado', '2022-10-29 05:24:49'),
(277, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos en estado cancelado', '2022-10-29 06:02:29'),
(278, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos en estado cancelado', '2022-10-29 06:02:39'),
(279, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos en estado terminado', '2022-10-29 06:03:34'),
(280, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos en estado terminado', '2022-10-29 06:04:56'),
(281, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com dio de alta un nuevo usuario llamado Maria Gimenez con email mariagimenez12@gmail.com', '2022-11-05 03:29:39'),
(282, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre la mesa con código 0GI28', '2022-11-05 04:03:25'),
(283, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todas las mesas', '2022-11-05 04:06:08'),
(284, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-11-05 04:29:42'),
(285, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-11-05 04:29:47'),
(286, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-11-05 04:30:44'),
(287, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-11-05 04:31:07'),
(288, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-11-05 04:31:17'),
(289, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-11-05 04:31:19'),
(290, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-11-05 04:31:21'),
(291, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-11-05 04:39:11'),
(292, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-11-05 04:39:13'),
(293, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más alta de 1', '2022-11-05 04:54:27'),
(294, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más alta de 1', '2022-11-05 04:55:18'),
(295, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más alta de notaMozo', '2022-11-05 04:56:06'),
(296, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más alta de notaMozo', '2022-11-05 04:56:23'),
(297, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más alta de notaMesa', '2022-11-05 04:56:30'),
(298, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más alta de notaMozo', '2022-11-05 04:56:39'),
(299, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más alta de notaMesa', '2022-11-05 04:56:48'),
(300, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más baja de notaMesa', '2022-11-05 05:00:03'),
(301, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-05 05:00:50'),
(302, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-05 06:16:12'),
(303, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com dio de alta un nuevo usuario llamado Jose Lopez con email josesito@gmail.com', '2022-11-05 23:06:32'),
(304, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com dio de alta la mesa con código 9I4HG', '2022-11-05 23:40:48'),
(305, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-06 03:22:59'),
(306, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-06 03:25:12'),
(307, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-06 03:56:50'),
(308, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-06 04:41:03'),
(309, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-06 04:41:16'),
(310, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-06 04:41:21'),
(311, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-06 04:42:11'),
(312, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-11-06 04:46:34'),
(313, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-11-06 04:47:01'),
(314, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 04:49:01'),
(315, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 04:52:48'),
(316, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 05:10:10'),
(317, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 05:10:35'),
(318, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 05:16:08'),
(319, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 05:23:00'),
(320, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 05:23:27');
INSERT INTO `logoperaciones` (`id`, `idUsuario`, `operacion`, `fechaOperacion`) VALUES
(321, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 05:24:02'),
(322, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 05:24:07'),
(323, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos en estado terminado', '2022-11-06 05:28:59'),
(324, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos en estado terminado', '2022-11-06 05:29:03'),
(325, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos en estado terminado', '2022-11-06 05:29:13'),
(326, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos en estado terminado', '2022-11-06 05:29:26'),
(327, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 05:32:38'),
(328, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 06:25:09'),
(329, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-06 06:25:26'),
(330, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-06 06:25:42'),
(331, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-06 06:25:51'),
(332, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 06:26:12'),
(333, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 06:26:48'),
(334, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-06 06:27:03'),
(335, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-06 06:42:21'),
(336, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 06:43:42'),
(337, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-06 06:43:48'),
(338, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 06:44:18'),
(339, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:49:07'),
(340, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:49:24'),
(341, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:49:39'),
(342, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:49:43'),
(343, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:49:51'),
(344, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:50:04'),
(345, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:52:01'),
(346, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:52:12'),
(347, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:52:16'),
(348, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:52:22'),
(349, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:52:33'),
(350, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 06:52:44'),
(351, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 07:06:21'),
(352, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-11-06 07:07:42'),
(353, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-11-06 07:07:54'),
(354, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más barata', '2022-11-06 07:11:23'),
(355, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más barata', '2022-11-06 07:11:39'),
(356, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más barata', '2022-11-06 07:11:44'),
(357, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-06 07:12:01'),
(358, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-06 07:23:43'),
(359, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-06 07:24:06'),
(360, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-11-06 07:25:22'),
(361, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más barata', '2022-11-06 07:31:30'),
(362, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-06 07:31:35'),
(363, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-06 08:59:36'),
(364, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:00:57'),
(365, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:01:15'),
(366, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:01:55'),
(367, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:02:27'),
(368, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:04:35'),
(369, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:05:05'),
(370, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:05:15'),
(371, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:05:23'),
(372, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 09:13:47'),
(373, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-06 09:18:18'),
(374, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-06 09:18:24'),
(375, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-11-06 09:18:32'),
(376, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:19:10'),
(377, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:19:49'),
(378, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:20:30'),
(379, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:22:46'),
(380, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:22:53'),
(381, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:23:12'),
(382, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:26:12'),
(383, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:40:44'),
(384, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:41:32'),
(385, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:41:47'),
(386, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 09:41:58'),
(387, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 10:04:52'),
(388, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 10:07:07'),
(389, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 10:19:19'),
(390, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:21:18'),
(391, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:21:36'),
(392, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:49:14'),
(393, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 10:49:27'),
(394, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:53:39'),
(395, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:55:59'),
(396, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:56:59'),
(397, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:57:17'),
(398, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:57:33'),
(399, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:57:40'),
(400, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:57:44'),
(401, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:57:56'),
(402, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:58:42'),
(403, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 10:58:46'),
(404, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:19:37'),
(405, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:23:57'),
(406, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:24:38'),
(407, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:27:05'),
(408, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:28:48'),
(409, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:29:49'),
(410, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:29:51'),
(411, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:30:04'),
(412, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:30:05'),
(413, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:30:06'),
(414, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:31:01'),
(415, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:31:04'),
(416, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:31:06'),
(417, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:31:35'),
(418, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:31:37'),
(419, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:31:38'),
(420, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:31:50'),
(421, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:32:46'),
(422, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:32:48'),
(423, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:32:52'),
(424, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 11:34:17'),
(425, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 11:34:54'),
(426, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 11:36:08'),
(427, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 11:39:02'),
(428, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre todos los productos ordenados por cantidad de ventas', '2022-11-06 11:40:11'),
(429, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas ordenadas por recaudación', '2022-11-06 11:40:35'),
(430, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 11:40:46'),
(431, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a suspendido ', '2022-11-06 11:46:59'),
(432, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a activo ', '2022-11-06 11:47:25'),
(433, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a suspendido ', '2022-11-06 11:48:14'),
(434, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com modifico el estado del usuario Eros Gonzalez a activo ', '2022-11-06 11:48:38'),
(435, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-06 11:57:06'),
(436, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-11-06 11:57:10'),
(437, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 11:57:17'),
(438, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 11:59:00'),
(439, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 12:01:03'),
(440, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-06 12:01:17'),
(441, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 12:01:28'),
(442, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-06 12:01:40'),
(443, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 12:04:01'),
(444, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-06 12:04:09'),
(445, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 12:04:13'),
(446, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 12:05:38'),
(447, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 12:05:44'),
(448, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 12:06:05'),
(449, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 12:06:57'),
(450, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-06 12:07:01'),
(451, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-06 12:08:14'),
(452, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-06 12:08:20'),
(453, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 12:08:23'),
(454, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-06 12:08:27'),
(455, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-11-06 12:11:11'),
(456, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-11-06 12:11:38'),
(457, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-11-06 12:12:02'),
(458, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-11-06 12:15:04'),
(459, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-11-06 12:16:14'),
(460, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más barata', '2022-11-06 12:23:54'),
(461, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-11-06 12:24:04'),
(462, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más barata', '2022-11-06 12:24:12'),
(463, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-06 12:25:11'),
(464, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-06 12:25:15'),
(465, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-11-06 12:26:02'),
(466, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más alta de notaMesa', '2022-11-06 12:26:05'),
(467, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-11-06 12:26:11'),
(468, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más baja de notaMesa', '2022-11-06 12:26:16'),
(469, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir', '2022-11-06 12:54:43'),
(470, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-06 12:59:03'),
(471, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-06 12:59:16'),
(472, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-06 12:59:41'),
(473, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-06 13:30:46'),
(474, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-06 13:30:53'),
(475, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-06 13:31:44'),
(476, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-07 10:19:05'),
(477, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-07 10:20:12'),
(478, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-11-09 14:11:54'),
(479, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-09 15:38:15'),
(480, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-09 15:38:32'),
(481, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-09 15:39:35'),
(482, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-09 15:47:54'),
(483, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-09 15:47:55'),
(484, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-09 15:48:31'),
(485, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-09 15:49:52'),
(486, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 00:49:25'),
(487, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 00:49:29'),
(488, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 00:51:33'),
(489, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 00:51:49'),
(490, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 00:52:01'),
(491, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 00:53:22'),
(492, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 00:53:39'),
(493, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 00:57:40'),
(494, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 00:58:28'),
(495, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:28:40'),
(496, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:28:43'),
(497, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:28:44'),
(498, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:39:10'),
(499, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:39:13'),
(500, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:39:14'),
(501, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:39:44'),
(502, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:43:20'),
(503, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:43:22'),
(504, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:43:23'),
(505, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:48:54'),
(506, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:50:39'),
(507, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:52:14'),
(508, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:56:58'),
(509, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:57:07'),
(510, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:57:08'),
(511, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:57:09'),
(512, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:57:10'),
(513, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:57:25'),
(514, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a enpreparacion', '2022-11-10 01:59:19'),
(515, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a terminado', '2022-11-11 11:08:49'),
(516, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a terminado', '2022-11-11 11:14:02'),
(517, 10, 'El empleado bartender Eros Gonzalez con mail erosgonzalez66@gmail.com modifico el estado del producto con id 1 perteneciente al pedido con código 7TQQL a terminado', '2022-11-11 11:31:19'),
(518, 11, 'El empleado mozo Maria Gimenez con mail mariagimenez12@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 11:40:12'),
(519, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 11:48:51'),
(520, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 11:51:17'),
(521, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 11:58:15'),
(522, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 12:00:28'),
(523, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 12:39:54'),
(524, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 12:42:32'),
(525, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 12:58:50'),
(526, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 12:59:17'),
(527, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 12:59:37'),
(528, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 13:01:39'),
(529, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 13:01:51'),
(530, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 13:02:11'),
(531, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 13:02:13'),
(532, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 13:02:14'),
(533, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 13:02:26'),
(534, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 13:03:53'),
(535, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com Sirvio exitosamente el pedido con el codigo 7TQQL', '2022-11-11 13:05:24'),
(536, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com trajo los pedidos listos para servir de su propiedad', '2022-11-11 13:10:14'),
(537, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com Sirvio exitosamente el pedido con el codigo 7TQQL', '2022-11-11 13:10:19'),
(538, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 13:46:18'),
(539, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 13:46:29'),
(540, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 13:46:33'),
(541, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más alta de notaMesa', '2022-11-17 13:46:45'),
(542, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 13:47:56'),
(543, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 13:48:01'),
(544, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 13:48:20'),
(545, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 13:48:30'),
(546, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 13:53:22'),
(547, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 13:54:58'),
(548, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 21:01:14'),
(549, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 21:02:00'),
(550, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 21:03:00'),
(551, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 21:03:07'),
(552, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 21:03:44'),
(553, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 21:04:02'),
(554, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 21:04:27'),
(555, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 21:05:42'),
(556, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:07:12'),
(557, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:07:32'),
(558, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:08:00'),
(559, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:08:38'),
(560, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:08:50'),
(561, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:09:11'),
(562, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:10:00'),
(563, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:10:26'),
(564, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:12:57'),
(565, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:13:04'),
(566, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:13:08'),
(567, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:13:24'),
(568, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:14:04'),
(569, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com descargo un pdf con el logo de la empresa', '2022-11-17 21:14:14'),
(570, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 21:19:16'),
(571, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 21:19:38'),
(572, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 21:20:15'),
(573, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 21:22:18'),
(574, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 21:47:34'),
(575, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 21:47:42'),
(576, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-17 22:42:30'),
(577, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-17 22:44:02'),
(578, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-17 22:44:12'),
(579, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-11-17 22:45:14'),
(580, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-11-17 22:45:33'),
(581, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-11-17 22:45:58'),
(582, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos más vendidos', '2022-11-17 23:05:38'),
(583, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-11-17 23:05:42'),
(584, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-17 23:07:35'),
(585, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 23:17:17'),
(586, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 23:25:24'),
(587, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 23:32:09'),
(588, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-17 23:32:17'),
(589, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-17 23:32:22'),
(590, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-17 23:32:27'),
(591, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-17 23:33:41'),
(592, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-17 23:34:19'),
(593, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-17 23:34:47'),
(594, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-17 23:35:15'),
(595, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-17 23:35:25'),
(596, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-17 23:35:36'),
(597, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más cara', '2022-11-17 23:44:26'),
(598, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más barata', '2022-11-17 23:44:33'),
(599, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura más barata', '2022-11-17 23:44:45'),
(600, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-17 23:45:07'),
(601, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-17 23:45:32'),
(602, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-17 23:46:07'),
(603, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-17 23:46:29'),
(604, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con código 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-17 23:50:07'),
(605, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-11-17 23:59:05'),
(606, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-11-17 23:59:29'),
(607, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios mejor valorados de la mesa con código 0GI28', '2022-11-18 00:01:08'),
(608, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más alta de notaMesa', '2022-11-18 00:01:22'),
(609, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más alta de notaMesa', '2022-11-18 00:01:28'),
(610, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-11-18 00:01:49'),
(611, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-11-18 00:01:52'),
(612, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-11-18 00:01:57'),
(613, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-11-18 00:02:11'),
(614, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-11-18 00:02:27'),
(615, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más baja de notaMesa', '2022-11-18 00:02:44'),
(616, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios peor valorados de la mesa con código 0GI28', '2022-11-18 00:05:26'),
(617, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio información sobre los comentarios con la nota más baja de notaMesa', '2022-11-18 00:05:31'),
(618, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com listo a todos los usuarios activos ', '2022-11-25 22:09:08'),
(619, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-25 22:09:25'),
(620, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos mas vendidos', '2022-11-26 15:33:19'),
(621, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los productos menos vendidos', '2022-11-26 15:36:01'),
(622, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-26 15:36:30'),
(623, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre el/los pedidos no entregados a tiempo', '2022-11-26 15:36:44'),
(624, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-26 15:39:54'),
(625, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas menos usadas', '2022-11-26 15:40:05'),
(626, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-26 15:40:16'),
(627, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas dinero recaudaron', '2022-11-26 15:40:25'),
(628, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura mas cara', '2022-11-26 15:40:35');
INSERT INTO `logoperaciones` (`id`, `idUsuario`, `operacion`, `fechaOperacion`) VALUES
(629, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura mas barata', '2022-11-26 15:40:45'),
(630, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-26 15:41:09'),
(631, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre los comentarios mejor valorados de la mesa con codigo 0GI28', '2022-11-26 15:41:20'),
(632, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre los comentarios con la nota mas alta de notaMesa', '2022-11-26 15:41:29'),
(633, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre los comentarios peor valorados de la mesa con codigo 0GI28', '2022-11-26 15:41:39'),
(634, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre los comentarios con la nota mas baja de notaMesa', '2022-11-26 15:42:05'),
(635, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre los comentarios peor valorados de la mesa con codigo 0GI28', '2022-11-26 15:42:12'),
(636, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre los comentarios con la nota mas baja de notaMesa', '2022-11-26 15:42:22'),
(637, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-26 15:43:10'),
(638, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre los comentarios mejor valorados de la mesa con codigo 0GI28', '2022-11-26 15:43:34'),
(639, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre los comentarios con la nota mas alta de notaMesa', '2022-11-26 15:43:37'),
(640, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre los comentarios peor valorados de la mesa con codigo 0GI28', '2022-11-26 15:43:41'),
(641, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre los comentarios con la nota mas baja de notaMesa', '2022-11-26 15:43:44'),
(642, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:39:21'),
(643, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:40:06'),
(644, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:40:25'),
(645, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:40:38'),
(646, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:40:47'),
(647, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura mas barata', '2022-11-27 00:43:51'),
(648, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:43:55'),
(649, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:44:49'),
(650, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:45:39'),
(651, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura mas barata', '2022-11-27 00:46:15'),
(652, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:46:20'),
(653, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:47:51'),
(654, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura mas barata', '2022-11-27 00:47:56'),
(655, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:48:02'),
(656, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:48:25'),
(657, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura mas cara', '2022-11-27 00:48:37'),
(658, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:49:05'),
(659, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:50:58'),
(660, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre los comentarios mejor valorados de la mesa con codigo 0GI28', '2022-11-27 00:51:10'),
(661, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:52:11'),
(662, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas que emitieron la factura mas barata', '2022-11-27 00:52:56'),
(663, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:54:58'),
(664, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio la facturación de la mesa con codigo 0GI28 entre las fechas 2022-10-09 y 2022-10-19', '2022-11-27 00:55:18'),
(665, 5, 'El socio Octavio Villegas con mail octaviovillegas@gmail.com pidio informacion sobre la/las mesas mas usadas', '2022-11-28 01:01:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `codigo` varchar(20) NOT NULL,
  `estado` int(11) NOT NULL,
  `fechaDeCreacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`codigo`, `estado`, `fechaDeCreacion`) VALUES
('0GI28', 1, '2022-09-02'),
('9I4HG', -1, '2022-11-05'),
('A622M', -1, '2022-11-22'),
('AA28N', -1, '2022-11-15'),
('ATI38', -1, '2022-10-15'),
('D5A92', 1, '2022-11-02'),
('D7YSX', -1, '2022-10-15'),
('ISZH7', -1, '2022-10-15'),
('XVMMN', -1, '2022-10-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `codigoMesa` varchar(20) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `horaInicio` datetime DEFAULT NULL,
  `horaFinal` datetime DEFAULT NULL,
  `codigo` varchar(6) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`codigoMesa`, `idUsuario`, `horaInicio`, `horaFinal`, `codigo`, `estado`) VALUES
('0GI28', 5, '2022-10-15 22:41:40', '2022-11-11 13:10:19', '7TQQL', 2),
('0GI28', 5, '2022-09-23 03:18:06', '2022-09-23 03:27:21', '8SR61', 2),
('ATI38', 5, '2022-10-16 00:10:40', '2022-10-16 00:19:55', '9JJE4', 2),
('ATI38', 5, '2022-10-16 00:10:51', '2022-10-16 00:20:06', 'EPATG', 2),
('D7YSX', 5, '2022-10-15 22:40:32', '2022-10-15 22:49:47', 'W93A8', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedprod`
--

CREATE TABLE `pedprod` (
  `id` int(11) NOT NULL,
  `codigoPedido` varchar(6) NOT NULL,
  `idProducto` int(6) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `horaInicio` datetime DEFAULT NULL,
  `horaFinal` datetime DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedprod`
--

INSERT INTO `pedprod` (`id`, `codigoPedido`, `idProducto`, `cantidad`, `horaInicio`, `horaFinal`, `estado`, `precio`) VALUES
(8, '8SR61', 3, 4, '2022-10-11 02:39:01', '2022-10-12 04:16:15', 2, 7196),
(9, '8SR61', 1, 2, '2022-10-03 02:39:26', '2022-10-04 02:39:28', 2, 699.98),
(10, '8SR61', 3, 3, '2022-10-06 02:39:38', '2022-10-07 02:39:41', 2, 5397),
(11, '8SR61', 3, 4, '2022-10-13 02:39:48', '2022-10-14 02:39:53', 2, 7196),
(12, '7TQQL', 3, 3, '2022-10-01 02:40:00', '2022-10-02 02:40:04', 2, 5397),
(13, '7TQQL', 1, 4, '2022-11-10 01:59:19', '2022-11-10 02:04:19', 2, 1399.96),
(14, 'W93A8', 1, 4, '2022-10-04 02:40:20', '2022-10-05 02:40:23', 2, 1399.96),
(15, '9JJE4', 1, 5, '2022-10-12 02:40:26', '2022-10-13 02:40:30', 2, 1749.95),
(16, '9JJE4', 3, 2, '2022-10-05 02:40:33', '2022-10-06 02:40:36', 2, 3598),
(17, 'EPATG', 3, 3, '2022-10-06 02:40:47', '2022-10-07 02:40:53', 2, 5397);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `nombre` varchar(30) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `rol` varchar(30) NOT NULL,
  `fechaDeCreacion` datetime NOT NULL,
  `precio` float NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`nombre`, `tipo`, `rol`, `fechaDeCreacion`, `precio`, `id`) VALUES
('Cuba Libre', 'bebida', 'bartender', '2022-09-03 00:00:00', 349.99, 1),
('Milanesa con Papas', 'comida', 'cocinero', '2022-09-04 06:32:09', 1799, 3),
('milanesa a caballo', 'comida', 'cocinero', '2022-11-05 03:31:06', 3200, 5),
('hamburguesa de garbanzo', 'comida', 'cocinero', '2022-11-05 03:31:37', 1600, 6),
('corona', 'bebida', 'cervecero', '2022-11-05 03:32:04', 500, 7),
('Daikiri', 'bebida', 'bartender', '2022-11-05 03:32:22', 700, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `rol` varchar(30) NOT NULL,
  `fechaDeInicioActividades` date NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `clave`, `tipo`, `rol`, `fechaDeInicioActividades`, `estado`) VALUES
(5, 'Octavio', 'Villegas', 'octaviovillegas@gmail.com', '$2y$10$652sfGvUUXZK9HfuwIH1NeiypI81DuHnmMFEojuSVIbplXsn/Rram', 'socio', 'todos', '2022-05-09', 1),
(6, 'Jose', 'López', 'juanlopez666@gmail.com', '$2y$10$i1r9iUt3rLe0CHVDwMWXM.Ynhhx5xUf4WUlXuOaDbcZauKsSO1eyq', 'empleado', 'bartender', '2022-05-11', 1),
(10, 'Eros', 'Gonzalez', 'erosgonzalez66@gmail.com', '$2y$10$0cc7S8seKbvqr9NqNkdQwuhlBK49myTGo54znWfN0gj7iAMBMw3Mm', 'empleado', 'bartender', '2022-05-11', 1),
(11, 'Maria', 'Gimenez', 'mariagimenez12@gmail.com', '$2y$10$ZTVWh2QAzoKLgE3EFAhhPeKDiZQKPZSG6FTDGWDeIUbc6HUH3TumS', 'empleado', 'mozo', '2022-05-22', 1),
(12, 'Jose', 'Lopez', 'josesito@gmail.com', '$2y$10$jK7PXgX/uC9L7JSqHOW2p.sh55/Gquuul3UZOQUf4KKbS1XGyNHOi', 'empleado', 'cervecero', '2022-11-05', 1),
(33, 'Juan', 'Perez', 'juanperez@gmail.com', '$2y$10$ItgDtnwnl7QIV5ZQHuMU6uqd2j1F8tJjJJc8B3ekZC4wqTn6SZ91u', 'empleado', 'mozo', '2022-11-11', 1),
(44, 'Facundo', 'Gomez', 'facugomez@gmail.com', '$2y$10$RdaExT3P/eZ/HEOXHhrtvu7zycBVaQ8.BGpgW.oQNNSWzJwLJ03J2', 'empleado', 'bartender', '0000-00-00', 1),
(55, 'Lionel', ' Messi', 'leomessi@gmail.com', '$2y$10$wSKbK2zWTqyRJiWC/7rZe.ML0IYMtSsWR50/RdPEnSIwc277BXhGm', 'empleado', 'cocinero', '2022-11-22', 1),
(66, 'Diego', 'Castro', 'diegocastro@gmail.com', '$2y$10$k60PLH1b6KHhHy4TsLdZlejX1Ej1TboBI9daiA24DpxSVq6M6lKbm', 'empleado', 'cervecero', '2022-11-24', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fotospedidos`
--
ALTER TABLE `fotospedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `loglogin`
--
ALTER TABLE `loglogin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logoperaciones`
--
ALTER TABLE `logoperaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `pedprod`
--
ALTER TABLE `pedprod`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `fotospedidos`
--
ALTER TABLE `fotospedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `loglogin`
--
ALTER TABLE `loglogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `logoperaciones`
--
ALTER TABLE `logoperaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=666;

--
-- AUTO_INCREMENT de la tabla `pedprod`
--
ALTER TABLE `pedprod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
