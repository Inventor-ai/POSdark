-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 18-03-2022 a las 04:10:35
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
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `folio` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `fecha_alta` timestamp NOT NULL,
  `usuario_id` int NOT NULL,
  `caja_id` int NOT NULL,
  `cliente_id` int NOT NULL,
  `forma_pago` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  `timbrado` int DEFAULT NULL,
  `uuid` varchar(36) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_timbrado` varchar(19) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `folio`, `total`, `fecha_alta`, `usuario_id`, `caja_id`, `cliente_id`, `forma_pago`, `activo`, `timbrado`, `uuid`, `fecha_timbrado`) VALUES
(1, '621326e697bae', '3750', '2022-02-22 05:48:10', 2, 1, 1, '001', 1, NULL, NULL, NULL),
(2, '621326e697bae', '3750', '2022-02-22 05:49:55', 2, 1, 1, '001', 1, NULL, NULL, NULL),
(3, '62153d66bf3d9', '2250', '2022-02-22 19:47:31', 1, 1, 1, '001', 0, NULL, NULL, NULL),
(4, '621564b53aca1', '3000', '2022-02-22 23:11:36', 1, 1, 10, '01', 1, NULL, NULL, NULL),
(5, '6215985f43240', '1850', '2022-02-23 02:18:03', 3, 2, 6, '002', 1, NULL, NULL, NULL),
(6, '6215c5c4aca27', '450', '2022-02-23 05:29:08', 3, 2, 2, '001', 0, NULL, NULL, NULL),
(7, '6225455d5f3e2', '2750', '2022-03-06 23:45:03', 3, 2, 1, '001', 1, NULL, NULL, NULL),
(8, '62254a1b2dcb9', '1050', '2022-03-06 23:56:42', 3, 2, 1, '001', 1, NULL, NULL, NULL),
(9, '6226d010c3fd7', '500', '2022-03-08 03:41:08', 3, 2, 1, '001', 1, NULL, NULL, NULL),
(10, '1', '450', '2022-03-11 17:01:33', 3, 2, 1, '001', 1, NULL, NULL, NULL),
(11, '2', '350', '2022-03-11 17:02:15', 3, 2, 1, '001', 1, NULL, NULL, NULL),
(12, '3', '800', '2022-03-11 17:08:33', 3, 2, 1, '001', 1, NULL, NULL, NULL),
(13, '4', '150', '2022-03-11 17:10:44', 3, 2, 1, '001', 1, NULL, NULL, NULL),
(14, '5', '1025', '2022-03-11 17:11:47', 3, 2, 1, '001', 1, NULL, NULL, NULL),
(15, '6', '300', '2022-03-12 04:13:03', 3, 2, 1, '01', 1, NULL, NULL, NULL),
(16, '7', '1250', '2022-03-12 04:14:04', 3, 2, 1, '01', 1, NULL, NULL, NULL),
(17, '8', '1700', '2022-03-17 08:44:43', 3, 2, 1, '01', 1, NULL, NULL, NULL),
(18, '1', '25', '2022-03-18 03:59:56', 1, 1, 6, '01', 1, NULL, NULL, NULL),
(19, '2', '1425', '2022-03-18 04:00:56', 1, 1, 6, '01', 1, 1, 'E311A4BE-A668-11EC-A1AA-A70EE2474935', '2022-03-17T21:09:55');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
