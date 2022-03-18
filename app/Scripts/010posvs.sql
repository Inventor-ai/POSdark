-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 18-03-2022 a las 04:11:06
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
  `fotos` tinyint NOT NULL DEFAULT '0',
  `activo` tinyint NOT NULL DEFAULT '1',
  `fecha_alta` timestamp NOT NULL,
  `fecha_edit` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `fk_articulo_unidad` (`id_unidad`),
  KEY `fk_articulo_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `codigo`, `nombre`, `precio_venta`, `precio_compra`, `existencias`, `stock_minimo`, `inventariable`, `id_unidad`, `id_categoria`, `fotos`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(1, '123456701', 'Tenis', '150', '50', 19, 8, 1, 13, 1, 6, 1, '2022-02-06 05:21:51', '2022-03-18 04:00:57'),
(2, '123456702', 'Tenis verdes', '450', '150', 0, 5, 1, 9, 1, 4, 1, '2022-02-15 11:42:08', '2022-03-18 04:00:57'),
(3, '123456703', 'Tenis grises', '350', '200', -1, 5, 1, 9, 1, 3, 1, '2022-02-06 00:36:27', '2022-03-18 04:00:57'),
(4, '12345001', 'fotos', '25', '10', -3, 5, 1, 2, 1, 0, 1, '2022-02-27 20:23:48', '2022-03-18 04:00:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

DROP TABLE IF EXISTS `cajas`;
CREATE TABLE IF NOT EXISTS `cajas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `caja` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `folio` int NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_edit` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`id`, `caja`, `nombre`, `folio`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(1, '1', 'Caja general', 3, 1, '2022-02-09 03:40:15', '2022-03-18 04:00:56'),
(2, '2', 'Caja secundaria', 9, 1, '2022-02-09 03:42:52', '2022-03-17 08:44:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas_arqueo`
--

DROP TABLE IF EXISTS `cajas_arqueo`;
CREATE TABLE IF NOT EXISTS `cajas_arqueo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `caja_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_final` datetime DEFAULT NULL,
  `monto_inicial` decimal(10,2) NOT NULL,
  `monto_final` decimal(10,2) DEFAULT NULL,
  `total_ventas` int NOT NULL,
  `estatus` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cajas_arqueo`
--

INSERT INTO `cajas_arqueo` (`id`, `caja_id`, `usuario_id`, `fecha_inicio`, `fecha_final`, `monto_inicial`, `monto_final`, `total_ventas`, `estatus`) VALUES
(1, 2, 3, '2022-03-11 18:55:29', '2022-03-12 15:42:14', '1500.00', '5525.00', 7, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `direccion`, `telefono`, `correo`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(1, 'Alma Madero Silva De Alegría', 'El Coyote Cojo 31', '55 6969-6969', 'maderoalma@porlatierra.com', 1, '2022-02-07 05:44:29', '2022-02-07 05:50:14'),
(2, 'Katie Banks', 'Canadian', '2707806 123', 'katie.banks@rt.com', 1, '2022-02-22 20:24:30', '2022-02-22 20:24:30'),
(3, 'Kacey Quinn', 'Florida, United States of America', '1722934', 'kacey.quinn@rt.com', 1, '2022-02-22 20:27:27', '2022-02-22 20:27:27'),
(4, 'Megan Sage', 'California, United States of America', '1989120', 'Megan.Sage@rt.com', 1, '2022-02-22 20:31:45', '2022-02-22 20:32:42'),
(5, 'Lizz Tayler', 'Arizona, United States of America', '11753961', 'Lizz.Tayler@rt.com', 1, '2022-02-22 21:17:53', '2022-02-22 21:17:53'),
(6, 'Monica Asis', 'Florida, United States of America 34C-27-40', '39342631', 'Monica.Asis@rt.com', 1, '2022-02-22 21:24:09', '2022-02-22 21:24:09'),
(7, 'Maru Karv', 'Brazilian  34D-24-39', '40295261', 'maru.karv@rt.com', 1, '2022-02-22 21:28:08', '2022-02-22 21:28:08'),
(8, 'Alexa Chandler', 'American 36D-25-36', '40212441', 'AlexaChandler@rt.com', 1, '2022-02-22 21:54:05', '2022-02-22 22:01:29'),
(9, 'Angel Lima', '', '', 'Angel.Lima@rt.com', 1, '2022-02-22 22:08:56', '2022-02-22 22:08:56'),
(10, 'Mary Jane Mayhem', 'California, United States of America 35D-27-37', '174986 40954841', 'MaryJane.Mayhem@rt.com', 1, '2022-02-22 22:20:25', '2022-02-22 22:20:25'),
(11, 'Lulu Reynolds', 'Australian 32C-26-40', '1961771 4669641', 'Lulu.Reynolds@rt.com', 1, '2022-02-22 22:29:11', '2022-02-22 22:29:11'),
(12, 'Renee Perez', 'Nevada, United States of America 34B-24-36', '39803971 40823181', 'Renee.Perez@rt.com', 1, '2022-02-22 22:31:06', '2022-02-22 22:31:06'),
(13, 'Layla Monroe', 'California, United States of America 34C-25-35', '40141401 39273611', 'Layla Monroe', 1, '2022-02-23 01:55:08', '2022-02-23 01:55:08'),
(14, 'Lilyan Red', 'Unknown 34B-24-36', '35293221 5508791', 'Lilyan.Red@rt.com', 1, '2022-02-23 02:05:06', '2022-02-23 02:05:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

DROP TABLE IF EXISTS `compras`;
CREATE TABLE IF NOT EXISTS `compras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `folio` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `usuario_id` int NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_compras_usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `folio`, `total`, `usuario_id`, `activo`, `fecha_alta`) VALUES
(1, '620fbc6ac5488', '2350', 3, 1, '2022-02-18 15:39:48'),
(2, '6211a85a0df68', '14225', 3, 1, '2022-02-20 02:46:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras_detalle`
--

DROP TABLE IF EXISTS `compras_detalle`;
CREATE TABLE IF NOT EXISTS `compras_detalle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `compra_id` int NOT NULL,
  `articulo_id` int NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_compra` (`compra_id`),
  KEY `fk_detalle_articulo` (`articulo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `compras_detalle`
--

INSERT INTO `compras_detalle` (`id`, `compra_id`, `articulo_id`, `nombre`, `cantidad`, `precio`, `fecha_alta`) VALUES
(1, 1, 1, 'Tenis', 3, '50', '2022-02-18 15:39:48'),
(2, 1, 1, 'Tenis', 2, '55', '2022-02-18 15:39:48'),
(3, 1, 2, 'Tenis verdes', 2, '150', '2022-02-18 15:39:48'),
(4, 1, 2, 'Tenis verdes', 4, '175', '2022-02-18 15:39:48'),
(5, 1, 3, 'Tenis grises', 2, '200', '2022-02-18 15:39:48'),
(6, 1, 3, 'Tenis grises', 3, '230', '2022-02-18 15:39:48'),
(7, 2, 1, 'Tenis', 15, '50', '2022-02-20 02:46:56'),
(8, 2, 2, 'Tenis verdes', 6, '150', '2022-02-20 02:46:56'),
(9, 2, 3, 'Tenis grises', 7, '200', '2022-02-20 02:46:56'),
(10, 2, 1, 'Tenis', 15, '75', '2022-02-20 02:46:56'),
(11, 2, 3, 'Tenis grises', 4, '1200', '2022-02-20 02:46:56'),
(12, 2, 2, 'Tenis verdes', 3, '1750', '2022-02-20 02:46:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras_temporal`
--

DROP TABLE IF EXISTS `compras_temporal`;
CREATE TABLE IF NOT EXISTS `compras_temporal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `folio` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `articulo_id` int NOT NULL,
  `codigo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `compras_temporal`
--

INSERT INTO `compras_temporal` (`id`, `folio`, `articulo_id`, `codigo`, `nombre`, `cantidad`, `precio`, `subtotal`) VALUES
(8, '620cbb964c56e', 1, '123456701', 'Tenis', 11, '150.00', '1650.00'),
(15, '62123841ec0a3', 1, '123456701', 'Tenis', 10001, '50.00', '500050.00'),
(16, '62123841ec0a3', 1, '123456701', 'Tenis', 1, '150.00', '150.00'),
(17, '62123841ec0a3', 1, '123456701', 'Tenis', 1, '250.00', '250.00'),
(18, '62123841ec0a3', 1, '123456701', 'Tenis', 1, '350.00', '350.00'),
(27, '621592ade4b6c', 3, '123456703', 'Tenis grises', 1, '350.00', '350.00'),
(33, '621326e697bae', 2, '123456702', 'Tenis verdes', 1, '450.00', '450.00'),
(36, '6225495b89b9a', 3, '123456703', 'Tenis grises', 3, '350.00', '1050.00'),
(53, '6233f33ae679e', 2, '123456702', 'Tenis verdes', 4, '450.00', '1800.00'),
(54, '6233f33ae679e', 3, '123456703', 'Tenis grises', 1, '350.00', '350.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones`
--

DROP TABLE IF EXISTS `configuraciones`;
CREATE TABLE IF NOT EXISTS `configuraciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `valor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `configuraciones`
--

INSERT INTO `configuraciones` (`id`, `nombre`, `valor`) VALUES
(1, 'tienda_nombre', 'Virtual Army Store - VAS'),
(2, 'tienda_rfc', 'TCM970625MB1'),
(3, 'tienda_telefono', '777 777 7777'),
(4, 'tienda_email', 'sucursal1@armystore.com'),
(5, 'tienda_direccion', 'En la calle del Coyote Cojo 3'),
(6, 'ticket_leyenda', '¡Gracias por visitarnos y compra!'),
(7, 'tienda_siglas', 'Army Store'),
(8, 'tienda_pagweb', 'http://mamiyasedonde.com/pos/'),
(9, 'tienda_vincularchk', '0'),
(10, 'tienda_logo', 'images/logotipo'),
(11, 'tienda_logoBak', 'https://static.wixstatic.com/media/cb0763_b933a7cf090a4889821743cd56b86c33~mv2.png'),
(12, 'logotipo', 'bolasTenis.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `evento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL,
  `ip` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `detalles` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`id`, `usuario_id`, `evento`, `fecha`, `ip`, `detalles`) VALUES
(1, 3, 'Inicio de sesión', '2022-03-08 22:50:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.10'),
(2, 3, 'Cierre de sesión', '2022-03-09 00:13:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.10'),
(3, 3, 'Inicio de sesión', '2022-03-10 03:30:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(4, 3, 'Cierre de sesión', '2022-03-10 04:37:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(5, 3, 'Inicio de sesión', '2022-03-10 04:37:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(6, 1, 'Inicio de sesión', '2022-03-11 05:41:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(7, 1, 'Cierre de sesión', '2022-03-11 05:42:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(8, 3, 'Inicio de sesión', '2022-03-11 05:42:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(9, 1, 'Inicio de sesión', '2022-03-11 16:56:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(10, 1, 'Cierre de sesión', '2022-03-11 16:57:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(11, 2, 'Inicio de sesión', '2022-03-11 16:57:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(12, 2, 'Cierre de sesión', '2022-03-11 16:58:54', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(13, 3, 'Inicio de sesión', '2022-03-11 16:59:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(14, 3, 'Inicio de sesión', '2022-03-11 20:04:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(15, 3, 'Inicio de sesión', '2022-03-12 00:49:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(16, 3, 'Inicio de sesión', '2022-03-12 15:40:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(17, 3, 'Inicio de sesión', '2022-03-11 20:15:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(18, 3, 'Inicio de sesión', '2022-03-11 20:57:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(19, 3, 'Inicio de sesión', '2022-03-11 21:05:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(20, 3, 'Cierre de sesión', '2022-03-11 21:11:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(21, 3, 'Inicio de sesión', '2022-03-11 21:11:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(22, 3, 'Inicio de sesión', '2022-03-13 03:30:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(23, 3, 'Inicio de sesión', '2022-03-14 04:11:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(24, 3, 'Inicio de sesión', '2022-03-15 04:57:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(25, 3, 'Inicio de sesión', '2022-03-16 06:26:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(26, 3, 'Inicio de sesión', '2022-03-17 06:04:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(27, 3, 'Inicio de sesión', '2022-03-17 08:42:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(28, 3, 'Inicio de sesión', '2022-03-18 03:58:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(29, 3, 'Cierre de sesión', '2022-03-18 03:59:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51'),
(30, 1, 'Inicio de sesión', '2022-03-18 03:59:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE IF NOT EXISTS `permisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`, `tipo`) VALUES
(1, 'MenuProductos', 1),
(2, 'SubProductos', 2),
(3, 'xMenuProductos', 1),
(4, 'xsubProductos', 2),
(5, 'ProductosCatalogo', 3),
(6, 'ProductosNuevo', 3),
(7, 'ProductosEditar', 3),
(8, 'ProductosNuevo', 3),
(9, 'SubUnidades', 2),
(10, 'UnidadesCatalogo', 3),
(11, 'UnidadesNuevo', 3),
(12, 'SubCategoria', 2),
(13, 'MenuClientes', 1),
(14, 'ClientesCatalogo', 2);

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
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_edit` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(1, 'Administrador', 1, '2022-02-09 03:13:43', '2022-02-12 17:04:55'),
(2, 'Cajero', 1, '2022-02-09 03:15:44', '2022-02-12 17:04:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

DROP TABLE IF EXISTS `roles_permisos`;
CREATE TABLE IF NOT EXISTS `roles_permisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol_id` int NOT NULL,
  `permiso_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles_permisos`
--

INSERT INTO `roles_permisos` (`id`, `rol_id`, `permiso_id`) VALUES
(74, 2, 1),
(75, 2, 2),
(76, 2, 5),
(77, 2, 9),
(78, 2, 10),
(79, 2, 11),
(80, 2, 13);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(130) COLLATE utf8_spanish_ci NOT NULL,
  `caja_id` int NOT NULL,
  `rol_id` int NOT NULL,
  `activo` int NOT NULL DEFAULT '1',
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_edit` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `caja_id` (`caja_id`),
  KEY `rol_id` (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `password`, `caja_id`, `rol_id`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(1, 'Sophie', 'Sophie Leone', '$2y$10$NdUlU4nt4L.FCdvbGw24beSdvcmIB2Ut13H3H2ktSy8yIZffdh2vy', 1, 2, 1, '2022-02-09 04:33:41', '2022-02-14 14:30:43'),
(2, 'Bond ', 'Savannah Bond', '$2y$10$IjQqeOnlFu1aiUl8b3RUb.cpQdnpr5aeOZr2nLBE6PmWqT7pQ2ZYm', 1, 1, 1, '2022-02-09 04:49:09', '2022-02-10 03:45:16'),
(3, 'Rios', 'Pamela Rios', '$2y$10$BUP8RdkGOAeujBgxpqyz3OVO01Uojocd4FlZDxoFAZhWS2JFXQ2SS', 2, 2, 1, '2022-02-10 03:41:15', '2022-02-14 14:31:12'),
(5, 'Anina', 'Anina Toth', '$2y$10$FZkd.vQY4g7WbpoZmjpzrOkbGGVr3IhTwibZFHMW/1XMEt.79emGK', 1, 2, 1, '2022-02-13 11:28:59', '2022-02-14 14:31:22'),
(7, 'usuariox', 'nombrex', '$2y$10$LR7BejljJJJ0bPKqfY9QmeExk.f2NEWA9gnI1z2A.A.8ZF9UzuGGK', 2, 2, 1, '2022-02-13 21:26:00', '2022-02-14 14:31:05');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_detalle`
--

DROP TABLE IF EXISTS `venta_detalle`;
CREATE TABLE IF NOT EXISTS `venta_detalle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `venta_id` int NOT NULL,
  `articulo_id` int NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_alta` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `venta_detalle`
--

INSERT INTO `venta_detalle` (`id`, `venta_id`, `articulo_id`, `nombre`, `cantidad`, `precio`, `fecha_alta`) VALUES
(1, 1, 2, 'Tenis verdes', 6, '450.00', '2022-02-22 05:48:10'),
(2, 1, 3, 'Tenis grises', 3, '350.00', '2022-02-22 05:48:11'),
(3, 3, 1, 'Tenis', 2, '150.00', '2022-02-22 19:47:31'),
(4, 3, 2, 'Tenis verdes', 2, '450.00', '2022-02-22 19:47:31'),
(5, 3, 3, 'Tenis grises', 3, '350.00', '2022-02-22 19:47:31'),
(6, 4, 2, 'Tenis verdes', 1, '450.00', '2022-02-22 23:11:36'),
(7, 4, 3, 'Tenis grises', 6, '350.00', '2022-02-22 23:11:36'),
(8, 4, 1, 'Tenis', 3, '150.00', '2022-02-22 23:11:36'),
(9, 5, 1, 'Tenis', 1, '150.00', '2022-02-23 02:18:03'),
(10, 5, 2, 'Tenis verdes', 3, '450.00', '2022-02-23 02:18:03'),
(11, 5, 3, 'Tenis grises', 1, '350.00', '2022-02-23 02:18:03'),
(12, 6, 1, 'Tenis', 3, '150.00', '2022-02-23 05:29:08'),
(13, 7, 2, 'Tenis verdes', 3, '450.00', '2022-03-06 23:45:03'),
(14, 7, 3, 'Tenis grises', 4, '350.00', '2022-03-06 23:45:03'),
(15, 8, 3, 'Tenis grises', 3, '350.00', '2022-03-06 23:56:42'),
(16, 9, 3, 'Tenis grises', 1, '350.00', '2022-03-08 03:41:08'),
(17, 9, 1, 'Tenis', 1, '150.00', '2022-03-08 03:41:08'),
(18, 10, 2, 'Tenis verdes', 1, '450.00', '2022-03-11 17:01:33'),
(19, 11, 3, 'Tenis grises', 1, '350.00', '2022-03-11 17:02:15'),
(20, 12, 1, 'Tenis', 3, '150.00', '2022-03-11 17:08:33'),
(21, 12, 3, 'Tenis grises', 1, '350.00', '2022-03-11 17:08:33'),
(22, 13, 4, 'fotos', 6, '25.00', '2022-03-11 17:10:44'),
(23, 14, 1, 'Tenis', 6, '150.00', '2022-03-11 17:11:47'),
(24, 14, 4, 'fotos', 5, '25.00', '2022-03-11 17:11:47'),
(25, 15, 1, 'Tenis', 2, '150.00', '2022-03-12 04:13:03'),
(26, 16, 1, 'Tenis', 6, '150.00', '2022-03-12 04:14:04'),
(27, 16, 3, 'Tenis grises', 1, '350.00', '2022-03-12 04:14:04'),
(28, 17, 3, 'Tenis grises', 1, '350.00', '2022-03-17 08:44:43'),
(29, 17, 2, 'Tenis verdes', 2, '450.00', '2022-03-17 08:44:43'),
(30, 17, 1, 'Tenis', 3, '150.00', '2022-03-17 08:44:43'),
(31, 18, 4, 'fotos', 1, '25.00', '2022-03-18 03:59:56'),
(32, 19, 4, 'fotos', 1, '25.00', '2022-03-18 04:00:56'),
(33, 19, 1, 'Tenis', 1, '150.00', '2022-03-18 04:00:57'),
(34, 19, 2, 'Tenis verdes', 2, '450.00', '2022-03-18 04:00:57'),
(35, 19, 3, 'Tenis grises', 1, '350.00', '2022-03-18 04:00:57');

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
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_compras_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `compras_detalle`
--
ALTER TABLE `compras_detalle`
  ADD CONSTRAINT `fk_detalle_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_detalle_compra` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_producto_unidad` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuario_caja` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
