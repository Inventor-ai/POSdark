-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 07-02-2022 a las 01:43:04
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

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `fk_articulo_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_articulo_unidad` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
