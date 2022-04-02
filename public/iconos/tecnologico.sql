-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-02-2022 a las 22:57:12
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tecnologico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areaasignada`
--

CREATE TABLE `areaasignada` (
  `id` bigint(20) NOT NULL,
  `idCurso` bigint(20) NOT NULL,
  `idArea` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id` bigint(20) NOT NULL,
  `claveCurso` varchar(20) NOT NULL,
  `fechaInicial` date NOT NULL,
  `fechaFinal` date NOT NULL,
  `horas` bigint(20) DEFAULT NULL,
  `cupo` int(11) DEFAULT NULL,
  `nombreCurso` varchar(50) DEFAULT NULL,
  `lugar` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impartio`
--

CREATE TABLE `impartio` (
  `id` bigint(20) NOT NULL,
  `idCurso` bigint(20) NOT NULL,
  `idInstructor` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructor`
--

CREATE TABLE `instructor` (
  `id` bigint(20) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `psw` varchar(30) DEFAULT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellidoPaterno` varchar(40) DEFAULT NULL,
  `apellidoMaterno` varchar(40) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `sexo` varchar(1) DEFAULT NULL,
  `correo` varchar(30) DEFAULT NULL,
  `domicilio` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `instructor`
--

INSERT INTO `instructor` (`id`, `rfc`, `psw`, `nombre`, `apellidoPaterno`, `apellidoMaterno`, `telefono`, `sexo`, `correo`, `domicilio`) VALUES
(64, 'ddd', 'dddd', 'raaa', '', '', '', '', '', ''),
(65, 'ddd', 'dddd', 'raaa', '', '', '', '', '', ''),
(66, 'fdfd', 'ddd', 'ddd', 'dd', 'dd', 'dd', 'd', 'dff', ''),
(67, 'ddd', 'ddd', 'dddd', 'ddd', 'ddd', 'ddd', 'd', 'dd', 'dd'),
(68, 'ddd', 'ddd', 'ddddrtrt', 'ddd', 'ddd', 'ddd', 'd', 'dd', 'dd'),
(69, 'df', 'a', 't', 't', 't', 't', 't', 't', 't'),
(70, 'df', 'a', 't', 't', 't', 't', 't', 't', 't'),
(71, 'df', 'a', 't', 't', 't', 't', 't', 't', 't'),
(72, 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u'),
(76, 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `areaasignada`
--
ALTER TABLE `areaasignada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCurso` (`idCurso`),
  ADD KEY `idArea` (`idArea`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `impartio`
--
ALTER TABLE `impartio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCurso` (`idCurso`),
  ADD KEY `idInstructor` (`idInstructor`);

--
-- Indices de la tabla `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `areaasignada`
--
ALTER TABLE `areaasignada`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `impartio`
--
ALTER TABLE `impartio`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `areaasignada`
--
ALTER TABLE `areaasignada`
  ADD CONSTRAINT `areaasignada_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `areaasignada_ibfk_2` FOREIGN KEY (`idArea`) REFERENCES `area` (`id`);

--
-- Filtros para la tabla `impartio`
--
ALTER TABLE `impartio`
  ADD CONSTRAINT `impartio_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `impartio_ibfk_2` FOREIGN KEY (`idInstructor`) REFERENCES `instructor` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
