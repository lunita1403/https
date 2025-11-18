-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2025 a las 21:56:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_fuzzion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `numero_pedido` varchar(20) NOT NULL,
  `cliente` varchar(150) NOT NULL,
  `productos` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `numero_pedido`, `cliente`, `productos`, `total`, `fecha`) VALUES
(1, 'FZ-9400', 'jhoana', '🥤 Coca Cola ($3200)', 3200.00, '2025-11-17 14:48:17'),
(2, 'FZ-5598', 'Gloria Admin', '🥤 Coca Cola ($3200)', 3200.00, '2025-11-17 15:04:25'),
(4, 'FZ-5349', 'jhoana', '', 3200.00, '2025-11-17 15:21:59'),
(5, 'FZ-6383', 'jhoana', '', 3200.00, '2025-11-17 15:27:05'),
(6, 'FZ-3462', 'jhoana', '', 2000.00, '2025-11-17 15:32:22'),
(7, 'FZ-5115', 'jhoana', '', 1000.00, '2025-11-17 15:50:34'),
(8, 'FZ-5840', 'jhoana', '', 3200.00, '2025-11-17 15:53:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `grado` varchar(20) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('estudiante','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `grado`, `correo`, `contrasena`, `rol`) VALUES
(1, 'Gloria', 'Admin', 'N/A', 'gloriafuzzion@gmail.com', '$2y$10$CdcGRFs2U5fSgiziE3msOupF8oHcwsMDfJhCsZjEtfktms9Badb8S', 'admin'),
(2, 'jhoana', '', '', 'ieca.jhoanasuarez@gmail.com', '$2y$10$ZHCHsmstBi8TuJagmB/qDeoMGbjpRN709vlytrQvmPeAnmNv9UzY.', 'estudiante');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_pedidos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_pedidos` (
`id_pedido` int(11)
,`numero_pedido` varchar(20)
,`cliente` varchar(150)
,`productos` text
,`total` decimal(10,2)
,`fecha` datetime
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_pedidos`
--
DROP TABLE IF EXISTS `vista_pedidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_pedidos`  AS SELECT `pedidos`.`id_pedido` AS `id_pedido`, `pedidos`.`numero_pedido` AS `numero_pedido`, `pedidos`.`cliente` AS `cliente`, `pedidos`.`productos` AS `productos`, `pedidos`.`total` AS `total`, `pedidos`.`fecha` AS `fecha` FROM `pedidos` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
