-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-12-2022 a las 06:59:22
-- Versión del servidor: 8.0.31-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `database`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `NoCuenta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fena` date NOT NULL,
  `curp` varchar(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `imgClient` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `domicilio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `codPostal` int NOT NULL,
  `estado` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `municipio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `status` enum('activo','inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `NoCuenta`, `name`, `fena`, `curp`, `imgClient`, `domicilio`, `codPostal`, `estado`, `municipio`, `email`, `pass`, `role`, `status`) VALUES
(1, 'A-202212104320', 'Fatima Naomi Marin Meza', '2002-09-15', 'HETJ030815HDFRRSA3', 'UsuarioM_1.jpg', 'Calle valle de las granadas #279', 28865, 'Colima', 'Manzanillo', 'jesus43.gts@gmail.com', '$2y$10$cGs7znRmwKCjWohFGmT10Olt8nosB1ig5N2uOSHpL/qPy0xZL82tS', 'user', 'activo'),
(9, 'A-202212100307', 'Jairo Preaciado Ayala', '2003-03-01', 'AMGJ030920HDFRRSA2', 'UsuarioH_2.jpg', 'Fraccionamiento Valle Pariso calle valle de las granadas #279', 28865, 'Colima', 'Manzanillo', 'jhernandez117@ucol.mx', '$2y$10$Y3g3Y4.yBfnXDa2FST8hre7C9sbOa9Te0vUEXlPKXYvMnKx1KiU9i', 'user', 'activo'),
(10, 'A-202212100639', 'Marin Meza Fatima Naomi', '2003-05-08', 'MAMF030508MJCRZTA6', 'UsuarioM_1.jpg', 'Fraccionamiento Valle Pariso calle valle de las granadas #279', 28865, 'Colima', 'Manzanillo', 'jesus43.gts@gmail.com', '$2y$10$q5iaeF4SwiV6kZuL00cjTehntVDY5eJ1R2X3DWlL4I2O9yp.6h9li', 'user', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `NoCuenta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`NoCuenta`, `saldo`) VALUES
('A-202212100307', 1000),
('A-202212100639', 0),
('A-202212104320', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int NOT NULL,
  `NoCuenta` varchar(255) NOT NULL,
  `accion` enum('pago','retiro','prestamo','deposito') NOT NULL,
  `cantidad` double NOT NULL,
  `fecha` date NOT NULL,
  `saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `NoCuenta`, `accion`, `cantidad`, `fecha`, `saldo`) VALUES
(1, 'A-202212100307', 'prestamo', 1000, '2022-12-12', 1000),
(2, 'A-202212104320', 'prestamo', 100, '2022-12-12', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `NoPrestamo` int NOT NULL,
  `NoCuenta` varchar(255) NOT NULL,
  `monto` double NOT NULL,
  `interes` double NOT NULL,
  `plazo` int NOT NULL,
  `feAsignado` date NOT NULL,
  `interesAcumulado` double NOT NULL,
  `pagado` double NOT NULL,
  `status` enum('pendiente','pagado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`NoPrestamo`, `NoCuenta`, `monto`, `interes`, `plazo`, `feAsignado`, `interesAcumulado`, `pagado`, `status`) VALUES
(1, 'A-202212100307', 1000, 0.075, 2, '2022-12-12', 0, 0, 'pendiente'),
(2, 'A-202212104320', 100, 0.075, 2, '2022-12-12', 0, 0, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fena` date NOT NULL,
  `curp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_client` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `domicilio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codPostal` int NOT NULL,
  `estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pais` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` bigint NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_client` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `fena`, `curp`, `img_client`, `domicilio`, `codPostal`, `estado`, `municipio`, `pais`, `tel`, `email`, `pass`, `num_client`, `role`, `status`) VALUES
(26, 'Fatima', '2003-05-08', 'MAMF', 'pardo.jpg', 'FRENTE AL PARQUE ', 28865, 'Michoacan', 'Apatzingan', 'Mexico', 31445735, 'bankfie@gmail.com', '$2y$10$8C20iU8q.HHxxMrOaUHyReV3HbgUoKroFzfxHrjejGB3Q59wqQ/bW', 'A-20220026', 'admin', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`NoCuenta`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`NoPrestamo`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `NoPrestamo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
