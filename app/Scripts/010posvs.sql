-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 07-02-2022 a las 05:52:00
-- Versión del servidor: 8.0.21
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `posvs`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

DROP TABLE IF EXISTS `articulos`;
CREATE TABLE IF NOT EXISTS `articulos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `precio_venta` decimal(10,0) NOT NULL DEFAULT '0',
  `precio_compra` decimal(10,0) NOT NULL DEFAULT '0',
  `existencias` int NOT NULL DEFAULT '0',
  `stock_minimo` int NOT NULL DEFAULT '0',
  `inventariable` tinyint NOT NULL,
  `id_unidad` smallint NOT NULL,
  `id_categoria` smallint NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_edit` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `fk_articulo_unidad` (`id_unidad`),
  KEY `fk_articulo_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `codigo`, `nombre`, `precio_venta`, `precio_compra`, `existencias`, `stock_minimo`, `inventariable`, `id_unidad`, `id_categoria`, `activo`, `fecha_edit`) VALUES
(1, '123456701', 'Tenis', '150', '50', 10, 8, 1, 13, 1, 1, '2022-02-06 05:21:51'),
(2, '123456702', 'Tenis verdes', '450', '0', 3, 5, 1, 9, 1, 1, '2022-02-06 00:29:31'),
(3, '123456703', 'Tenis grises', '350', '200', 6, 5, 1, 9, 1, 1, '2022-02-06 00:36:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_edit` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `activo`, `fecha_edit`) VALUES
(1, 'Calzado x', 1, '2022-02-06 03:34:20'),
(2, 'Blancos', 1, NULL),
(3, 'Calzado x', 1, '2022-02-07 04:15:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_edit` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `direccion`, `telefono`, `correo`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(1, 'Alma Madero Silva De Alegría', 'El Coyote Cojo 31', '55 6969-6969', 'maderoalma@porlatierra.com', 1, '2022-02-07 05:44:29', '2022-02-07 05:50:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `precio_venta` decimal(10,0) NOT NULL DEFAULT '0',
  `precio_compra` decimal(10,0) NOT NULL DEFAULT '0',
  `existencias` int NOT NULL DEFAULT '0',
  `stock_minimo` int NOT NULL DEFAULT '0',
  `inventariable` tinyint NOT NULL,
  `id_unidad` smallint NOT NULL,
  `id_categoria` smallint NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `fk_producto_unidad` (`id_unidad`),
  KEY `fk_producto_categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

DROP TABLE IF EXISTS `unidades`;
CREATE TABLE IF NOT EXISTS `unidades` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_corto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `activo` int NOT NULL DEFAULT '1',
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_edit` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre`, `nombre_corto`, `activo`, `fecha_edit`) VALUES
(1, 'litro', 'lt', 1, '2022-02-05 19:20:45'),
(2, 'Mililitro x', 'ml', 1, '2022-02-06 01:45:03'),
(3, 'KiloGramo', 'kg/kgs x', 1, '2022-02-06 01:39:57'),
(4, 'Gramo', 'gr/grs', 1, '2022-02-06 01:44:48'),
(5, 'Onza líquida oculta', 'fl.oz.', 1, '2022-02-06 01:43:40'),
(6, 'Onza peso oculta', '', 1, '2022-02-06 01:43:21'),
(7, 'tonelada', 'ton.', 1, '2022-02-05 16:15:30'),
(8, 'metro', 'm.', 1, '2022-02-04 06:13:14'),
(9, 'caja', 'cj', 1, '2022-02-06 01:44:05'),
(10, 'Libra', 'lb', 1, '2022-02-06 01:44:55'),
(11, 'Galón', 'Gal.', 1, '2022-02-06 01:41:46'),
(12, 'pieza', 'pza', 1, '2022-02-04 04:25:54'),
(13, 'Unidad ex', 'Unit ex', 1, '2022-02-06 01:41:51'),
(14, 'Bolsa', 'bsa', 1, '2022-02-06 01:45:00');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `fk_articulo_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_articulo_unidad` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_producto_unidad` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
