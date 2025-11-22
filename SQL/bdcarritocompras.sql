-- Active: 1717116899462@@127.0.0.1@3306@bdcarritocompras
-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 15-10-2018 a las 23:12:45
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Base de datos: `bdcarritocompras`
CREATE DATABASE `bdcarritocompras`;
-- --------------------------------------------------------

-- Selecciona la base de datos a usar:
USE `bdcarritocompras`;
-- --------------------------------------------------------

-- Estructura de tabla para la tabla `usuario`
CREATE TABLE `usuario` (
  `idusuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `usnombre` varchar(50) NOT NULL,
  `uspass` varchar(255) NOT NULL,
  `usmail` varchar(50) NOT NULL,
  `usdeshabilitado` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

-- Estructura de tabla para la tabla `producto`
CREATE TABLE `producto` (
  `idproducto` int(100) NOT NULL,
  `pronombre` varchar(500) NOT NULL,
  `prodesarrollador` varchar(100) NOT NULL,
  `proprecio` int(100) NOT NULL,
  `prodescripcion` varchar(1000) NOT NULL,
  `prostock` int(100) NOT NULL,
  `progenero` varchar(20) NOT NULL,
  `plataforma` varchar(30) NOT NULL, 
  `prodeshabilitado` timestamp(6) NULL DEFAULT NULL,
  `proimg` varchar(50) NOT NULL,
  PRIMARY KEY (`idproducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

-- Estructura de tabla para la tabla `rol`
CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `rodescripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

-- Estructura de tabla para la tabla `compraestadotipo`
CREATE TABLE `compraestadotipo` (
  `idcompraestadotipo` int(11) NOT NULL AUTO_INCREMENT,
  `cetdescripcion` varchar(50) NOT NULL,
  `cetdetalle` varchar(256) NOT NULL,
  PRIMARY KEY (`idcompraestadotipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

-- Estructura de tabla para la tabla `compra`
CREATE TABLE `compra` (
  `idcompra` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cofecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idusuario` bigint NOT NULL,
  PRIMARY KEY(`idcompra`),
  FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

-- Estructura de tabla para la tabla `compraestado`
CREATE TABLE `compraestado` (
  `idcompraestado` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `idcompra` bigint UNSIGNED NOT NULL,
  `idcompraestadotipo` int(11) NOT NULL,
  `cefechaini` timestamp NOT NULL DEFAULT current_timestamp(),
  `cefechafin` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idcompraestado`),
  FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`idcompraestadotipo`) REFERENCES `compraestadotipo` (`idcompraestadotipo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

-- Estructura de tabla para la tabla `compraitem`
CREATE TABLE `compraitem` (
  `idcompraitem` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idproducto` int(20) NOT NULL,
  `idcompra` bigint UNSIGNED NOT NULL,
  `cicantidad` int(11) NOT NULL,
  PRIMARY KEY (`idcompraitem`),
  FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

-- Estructura de tabla para la tabla `menu`
CREATE TABLE `menu` (
  `idmenu` bigint(20) NOT NULL,
  `menombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
  `medescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  `idpadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  `medeshabilitado` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez',
  PRIMARY KEY (`idmenu`),
  FOREIGN KEY (`idpadre`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

-- Estructura de tabla para la tabla `menurol`
CREATE TABLE `menurol` (
  `idmenu` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL,
  PRIMARY KEY (`idmenu`,`idrol`),
  FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

-- Estructura de tabla para la tabla `usuariorol`
CREATE TABLE `usuariorol` (
  `idusuario` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL,
  PRIMARY KEY (`idusuario`,`idrol`),
  FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE,
  FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

-- Volcado de datos para la tabla `menu`
INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`) VALUES
(1, 'Administrador', '#', NULL , NULL),
(2, 'Deposito', '#', NULL, NULL),
(3, 'Cliente', '#', NULL, NULL),
(4, 'Administrar Usuarios', 'AdministrarUsuarios', 1, NULL),
(5, 'Administrar Productos', 'AdministrarProductos', 2, NULL),
(6, 'Administrar Compras', 'AdministrarCompras', 2, NULL),
(7, 'Carrito', 'Carrito', 3, NULL),
(8, 'Mis Compras', 'MisCompras', 3, NULL);
-- --------------------------------------------------------

-- Volcado de datos para la tabla `usuario`
INSERT INTO `usuario` (`idusuario`, `usnombre`, `uspass`, `usmail`, `usdeshabilitado`) VALUES
(1, 'admin', MD5('password'), 'admin@example.com', NULL),
(2, 'deposito', MD5('password'), 'deposito1@example.com', NULL),
(3, 'cliente', MD5('password'), 'cliente1@example.com', NULL);
-- --------------------------------------------------------

-- Volcado de datos para la tabla `rol`
INSERT INTO `rol` (`idrol`, `rodescripcion`) VALUES
(1, 'Administrador'),
(2, 'Depósito'),
(3, 'Cliente');
-- --------------------------------------------------------

-- Volcado de datos para la tabla `usuariorol`
INSERT INTO `usuariorol` (`idusuario`, `idrol`) VALUES
(1, 1), -- Admin
(2, 2), -- Deposito
(3, 3); -- Cliente
-- --------------------------------------------------------

-- Volcado de datos para la tabla `menurol`
INSERT INTO `menurol` (`idmenu`, `idrol`) VALUES
(1, 1), -- Administrador
(2, 2), -- Depósito
(3, 3); -- Cliente
-- --------------------------------------------------------

-- Volcado de datos para la tabla `compraestadotipo`
INSERT INTO `compraestadotipo` (`idcompraestadotipo`, `cetdescripcion`, `cetdetalle`) VALUES
(1, 'Iniciada', 'Cliente inicia la compra de uno o mas productos del carrito'),
(2, 'Aceptada', 'Deposito da ingreso a una de las compras en estado = 1'),
(3, 'Enviada', 'Deposito envia a uno de las compras en estado = 2'),
(4, 'Cancelada', 'Deposito podra cancelar una compra en cualquier estado y un usuario cliente solo en estado = 1');
-- --------------------------------------------------------







