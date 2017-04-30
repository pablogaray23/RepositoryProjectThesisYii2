-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-08-2016 a las 21:25:37
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 7.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clinica1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atn_gen`
--

CREATE TABLE `atn_gen` (
  `id_atencion` int(2) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `atn_gen`
--

INSERT INTO `atn_gen` (`id_atencion`, `nombre`) VALUES
(1, 'Atencion General'),
(2, 'Ecografias'),
(4, 'Odontologia'),
(3, 'Vacunatorio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `user_id` int(11) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `auth_assignment`
--

INSERT INTO `auth_assignment` (`user_id`, `item_name`, `created_at`) VALUES
(1, 'Administrador Sistema', NULL),
(26, 'Funcionario', NULL),
(27, 'Profesional', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Administrador Sistema', 1, NULL, NULL, NULL, NULL, NULL),
('Funcionario', 1, NULL, NULL, NULL, NULL, NULL),
('Profesional', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `box_atencion`
--

CREATE TABLE `box_atencion` (
  `id_boxAtencion` int(4) NOT NULL,
  `id_boxGeneral` int(4) NOT NULL,
  `id_atn` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `box_atencion`
--

INSERT INTO `box_atencion` (`id_boxAtencion`, `id_boxGeneral`, `id_atn`) VALUES
(1, 1, 1),
(2, 2, 2),
(7, 3, 1),
(8, 4, 1),
(5, 6, 1),
(9, 7, 1),
(6, 7, 4),
(10, 8, 1),
(11, 9, 1),
(12, 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `box_general`
--

CREATE TABLE `box_general` (
  `id_box` int(4) NOT NULL,
  `nombre_box` varchar(20) NOT NULL,
  `id_sector` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `box_general`
--

INSERT INTO `box_general` (`id_box`, `nombre_box`, `id_sector`) VALUES
(1, 'Box 202', 1),
(2, 'Box 201', 1),
(3, 'Box 204', 1),
(4, 'Box 205', 1),
(6, 'Box 101', 3),
(7, 'Box 102', 3),
(8, 'Box301', 3),
(9, 'Box302', 3),
(10, 'Box303', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edificio_inst`
--

CREATE TABLE `edificio_inst` (
  `id_edificio` int(2) NOT NULL,
  `nombre_edificio` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `edificio_inst`
--

INSERT INTO `edificio_inst` (`id_edificio`, `nombre_edificio`) VALUES
(1, 'Edificio Nuevo'),
(2, 'Edificio Viejo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esp_atn`
--

CREATE TABLE `esp_atn` (
  `id` int(3) NOT NULL,
  `id_esp_gen` int(3) NOT NULL,
  `id_atn_gen` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `esp_atn`
--

INSERT INTO `esp_atn` (`id`, `id_esp_gen`, `id_atn_gen`) VALUES
(1, 4, 2),
(3, 2, 2),
(4, 9, 1),
(5, 11, 1),
(6, 3, 1),
(8, 5, 1),
(10, 2, 1),
(11, 1, 1),
(12, 1, 3),
(13, 12, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esp_gen`
--

CREATE TABLE `esp_gen` (
  `codigoEspecialidad` int(3) NOT NULL,
  `nombreEspecialidad` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `esp_gen`
--

INSERT INTO `esp_gen` (`codigoEspecialidad`, `nombreEspecialidad`) VALUES
(1, 'Pediatra'),
(2, 'Dermatología'),
(3, 'Cardiología'),
(4, 'Traumatología'),
(5, 'Hematología'),
(6, 'Psiquiatría'),
(9, 'Fonoaudiología'),
(11, 'Neurología'),
(12, 'Medicina General');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event`
--

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL,
  `rut_profesional` varchar(11) NOT NULL,
  `id_box` int(4) NOT NULL,
  `title` varchar(30) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `event`
--

INSERT INTO `event` (`id_event`, `rut_profesional`, `id_box`, `title`, `description`, `date`, `start_time`, `end_time`, `estado`) VALUES
(49, '103943523', 6, 'Atencion Extraordinaria', 'Atencion de Paciente', '2016-08-16', '12:00:00', '13:30:00', 'Pendiente'),
(50, '103943523', 6, 'Atencion Extraordinaria', 'Atencion de Paciente', '2016-08-18', '12:00:00', '13:30:00', 'Pendiente'),
(51, '166332664', 6, 'Atencion General', 'Atencion de pacientes general', '2016-08-17', '12:00:00', '13:00:00', 'Pendiente'),
(52, '166332664', 6, 'Atencion General', 'Atencion de pacientes general', '2016-08-19', '12:00:00', '13:00:00', 'Pendiente'),
(53, '166332664', 6, 'Atencion General', 'Atencion de pacientes general', '2016-08-24', '12:00:00', '13:00:00', 'Pendiente'),
(54, '166332664', 6, 'Atencion General', 'Atencion de pacientes general', '2016-08-26', '12:00:00', '13:00:00', 'Pendiente'),
(55, '166332664', 6, 'Atencion General', 'Atencion de pacientes general', '2016-08-31', '12:00:00', '13:00:00', 'Pendiente'),
(56, '166332664', 6, 'Atencion General', 'Atencion de pacientes general', '2016-09-02', '12:00:00', '13:00:00', 'Pendiente'),
(57, '84382094', 2, 'Pedro Burgos', 'test', '2016-08-17', '13:30:00', '14:00:00', 'Pendiente'),
(58, '182064009', 1, 'Marcelo Gonzales', 'test', '2016-08-25', '15:00:00', '16:00:00', 'Pendiente'),
(60, '84382094', 2, 'Pedro Burgos', 'test', '2016-08-24', '13:30:00', '14:00:00', 'Pendiente'),
(61, '182064009', 1, 'Marcelo Gonzales', 'test', '2016-09-01', '15:00:00', '16:00:00', 'Pendiente'),
(63, '103943523', 1, 'Viviana Martinez', 'test', '2016-08-19', '08:30:00', '10:00:00', 'Pendiente'),
(64, '103943523', 1, 'Viviana Martinez', 'test', '2016-08-22', '08:30:00', '10:00:00', 'Pendiente'),
(65, '103943523', 1, 'Viviana Martinez', 'test', '2016-08-26', '08:30:00', '10:00:00', 'Pendiente'),
(66, '103943523', 1, 'Viviana Martinez', 'test', '2016-08-29', '08:30:00', '10:00:00', 'Pendiente'),
(67, '103943523', 1, 'Viviana Martinez', 'test', '2016-09-02', '08:30:00', '10:00:00', 'Pendiente'),
(68, '182064009', 7, 'Atencion General', 'Atencion General', '2016-08-17', '10:00:00', '12:00:00', 'Pendiente'),
(69, '182064009', 7, 'Atencion General', 'Atencion General', '2016-08-18', '10:00:00', '12:00:00', 'Pendiente'),
(70, '182064009', 7, 'Atencion General', 'Atencion General', '2016-08-20', '10:00:00', '12:00:00', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1463427371),
('m130524_201442_init', 1463427375);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piso_inst`
--

CREATE TABLE `piso_inst` (
  `id_piso` int(2) NOT NULL,
  `nombre_piso` varchar(20) NOT NULL,
  `id_edificio` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `piso_inst`
--

INSERT INTO `piso_inst` (`id_piso`, `nombre_piso`, `id_edificio`) VALUES
(1, 'Piso 1', 1),
(2, 'Piso 2', 1),
(5, 'Piso 3', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pr_antecedente`
--

CREATE TABLE `pr_antecedente` (
  `id` int(5) NOT NULL,
  `rut_med` varchar(10) NOT NULL,
  `nombreArchivo` varchar(60) NOT NULL,
  `tipoAntecedente` int(2) NOT NULL,
  `fechaSubida` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pr_antecedente`
--

INSERT INTO `pr_antecedente` (`id`, `rut_med`, `nombreArchivo`, `tipoAntecedente`, `fechaSubida`) VALUES
(4, '182064009', '189894076Boleta 26 Diciembre 2014.pdf', 3, '2016-06-26'),
(17, '182064009', '26-06-2016 convenio 21759  189894076.pdf', 5, '0000-00-00'),
(19, '179894076', '26-06-2016 convenio 79800  189894076.pdf', 5, '0000-00-00'),
(21, '179894076', '26-06-2016 convenio 94961  189894076.pdf', 5, '0000-00-00'),
(22, '182064009', '26-06-2016 convenio 67712  189894076.pdf', 5, '0000-00-00'),
(23, '179894076', '26-06-2016 convenio 44025  189894076.pdf', 5, '0000-00-00'),
(26, '179894076', '189894076BoletaCristobalDreau04-05-15.pdf', 1, '2016-07-21'),
(28, ' 179894076', '28-07-2016 convenio 62893  179894076.pdf', 5, '0000-00-00'),
(30, ' 84382094', '31-07-2016 convenio 68093  84382094.pdf', 5, '2016-07-31'),
(31, ' 103943523', '16-08-2016 convenio 33747  103943523.pdf', 5, '2016-08-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pr_antecedente_tipo`
--

CREATE TABLE `pr_antecedente_tipo` (
  `id_antecedente_tipo` int(2) NOT NULL,
  `nombre_antecedente_tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pr_antecedente_tipo`
--

INSERT INTO `pr_antecedente_tipo` (`id_antecedente_tipo`, `nombre_antecedente_tipo`) VALUES
(4, 'Carnet de Vacunacion'),
(3, 'Cedula de Identidad'),
(5, 'Convenio'),
(1, 'Curriculum'),
(2, 'Titulo Profesional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pr_esp`
--

CREATE TABLE `pr_esp` (
  `id_pr_esp` int(3) NOT NULL,
  `rut` varchar(10) NOT NULL,
  `codigoEspecialidad` int(3) NOT NULL,
  `institucion` varchar(40) NOT NULL,
  `anio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pr_esp`
--

INSERT INTO `pr_esp` (`id_pr_esp`, `rut`, `codigoEspecialidad`, `institucion`, `anio`) VALUES
(1, '182064009', 1, '', 0),
(3, '182064009', 3, '', 0),
(4, '166332664', 4, 'UBB', 1995),
(5, '166332664', 5, '', 0),
(6, '182064009', 2, '', 0),
(14, '179894076', 3, 'por ahi', 2010),
(15, '84382094', 2, '1', 1),
(16, '84382094', 4, '1', 1),
(17, '84382094', 4, '1', 1),
(18, '84382094', 3, '1', 1),
(19, '126963645', 4, 'Universidad de Concepcion', 1982),
(20, '103943523', 12, 'Universidad de Chile', 1986);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pr_hor`
--

CREATE TABLE `pr_hor` (
  `id_pr_horario` int(4) NOT NULL,
  `rut_profesional` varchar(10) NOT NULL,
  `dia_semana` int(1) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pr_hor`
--

INSERT INTO `pr_hor` (`id_pr_horario`, `rut_profesional`, `dia_semana`, `hora_inicio`, `hora_fin`) VALUES
(1, '179894076', 0, '08:30:00', '09:30:00'),
(2, '179894076', 4, '13:00:00', '14:30:00'),
(3, '182064009', 3, '15:00:00', '16:00:00'),
(4, '84382094', 2, '13:30:00', '14:00:00'),
(5, '84382094', 0, '13:00:00', '15:00:00'),
(6, '16633266-4', 0, '18:00:00', '19:00:00'),
(9, '103943523', 0, '08:30:00', '10:00:00'),
(10, '103943523', 4, '17:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pr_med`
--

CREATE TABLE `pr_med` (
  `rut` varchar(10) NOT NULL,
  `nombre_usuario` varchar(255) DEFAULT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellidoPaterno` varchar(30) NOT NULL,
  `apellidoMaterno` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `telefono` int(10) NOT NULL,
  `direccion` varchar(60) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pr_med`
--

INSERT INTO `pr_med` (`rut`, `nombre_usuario`, `nombre`, `apellidoPaterno`, `apellidoMaterno`, `email`, `telefono`, `direccion`, `estado`) VALUES
('103943523', NULL, 'Viviana', 'Martinez', 'Campos', 'viviana@gmail.com', 422, 'Avenida Ecuador 246', 0),
('126963645', NULL, 'Luis', 'Huanquilef', 'Melo', 'luis@gmail.com', 422, 'Argentina 234', 0),
('166332664', NULL, 'Francisco', 'Gomez', 'Ojeda', 'fgomez@correo.cl', 978462356, 'El Roble 76', 0),
('179894076', 'pgaray', 'Pablo', 'Garay', 'Cofré', 'pablo@ubb.cl', 112356, 'calle', 0),
('182064009', 'mgonzales', 'Marcelo', 'Gonzales', 'Jara', 'mgonzales@correo.cl', 998745621, 'Argentina 142', 0),
('84382094', NULL, 'Pedro', 'Burgos', 'Pereira', 'pburgos@correo.cl', 946135688, 'Gamero 234', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sector_inst`
--

CREATE TABLE `sector_inst` (
  `id_sector` int(2) NOT NULL,
  `nombre_sector` varchar(20) NOT NULL,
  `id_piso` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sector_inst`
--

INSERT INTO `sector_inst` (`id_sector`, `nombre_sector`, `id_piso`) VALUES
(1, 'Ala 1', 2),
(2, 'Ala 2', 2),
(3, 'Sector uno', 1),
(4, 'Sector dos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'cdreau', '7s2AY-Mo7heXCd_aYhud_PMjD11wsFlC', '$2y$13$Afk72VPZFoVryj2tH55GNu9bcpZl3NWXB5vwUudCSuEYQ8Bwo8YnS', '', 'cdreau@alumnos.ubiobio.cl', 10, 1463427563, 1463427563),
(26, 'pgaray', 'n6cps80381M6dJGKR84Z8smJWeT8nJBf', '$2y$13$5C9nTZaKZLOLLQ.CjywZE.R8XpKpsnQCC5vzqNoBUoD.DVWVEebsu', NULL, 'pgaray@alumnos.ubiobio.cl', 10, 1466554015, 1466554015),
(27, 'mgonzales', '-5l61MqxYLrraOxZrVKwn4sxocd9a2P2', '$2y$13$mWqreo1BuI/Ebnq4D2dH0uf0WZ1ssWZDkc9xjwFlymR7ONQwnWH3C', NULL, 'mgonzales@clinica.cl', 10, 1466554114, 1466554114);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `atn_gen`
--
ALTER TABLE `atn_gen`
  ADD PRIMARY KEY (`id_atencion`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indices de la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indices de la tabla `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `box_atencion`
--
ALTER TABLE `box_atencion`
  ADD PRIMARY KEY (`id_boxAtencion`),
  ADD UNIQUE KEY `id_box` (`id_boxGeneral`,`id_atn`);

--
-- Indices de la tabla `box_general`
--
ALTER TABLE `box_general`
  ADD PRIMARY KEY (`id_box`),
  ADD UNIQUE KEY `nombre_box` (`nombre_box`);

--
-- Indices de la tabla `edificio_inst`
--
ALTER TABLE `edificio_inst`
  ADD PRIMARY KEY (`id_edificio`);

--
-- Indices de la tabla `esp_atn`
--
ALTER TABLE `esp_atn`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `esp_gen`
--
ALTER TABLE `esp_gen`
  ADD PRIMARY KEY (`codigoEspecialidad`);

--
-- Indices de la tabla `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`),
  ADD UNIQUE KEY `rut_profesional` (`rut_profesional`,`title`,`description`,`date`,`start_time`,`end_time`);

--
-- Indices de la tabla `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `piso_inst`
--
ALTER TABLE `piso_inst`
  ADD PRIMARY KEY (`id_piso`);

--
-- Indices de la tabla `pr_antecedente`
--
ALTER TABLE `pr_antecedente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pr_antecedente_tipo`
--
ALTER TABLE `pr_antecedente_tipo`
  ADD PRIMARY KEY (`id_antecedente_tipo`),
  ADD UNIQUE KEY `nombre_antecedente_tipo` (`nombre_antecedente_tipo`);

--
-- Indices de la tabla `pr_esp`
--
ALTER TABLE `pr_esp`
  ADD PRIMARY KEY (`id_pr_esp`);

--
-- Indices de la tabla `pr_hor`
--
ALTER TABLE `pr_hor`
  ADD PRIMARY KEY (`id_pr_horario`);

--
-- Indices de la tabla `pr_med`
--
ALTER TABLE `pr_med`
  ADD PRIMARY KEY (`rut`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- Indices de la tabla `sector_inst`
--
ALTER TABLE `sector_inst`
  ADD PRIMARY KEY (`id_sector`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `atn_gen`
--
ALTER TABLE `atn_gen`
  MODIFY `id_atencion` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `box_atencion`
--
ALTER TABLE `box_atencion`
  MODIFY `id_boxAtencion` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `box_general`
--
ALTER TABLE `box_general`
  MODIFY `id_box` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `edificio_inst`
--
ALTER TABLE `edificio_inst`
  MODIFY `id_edificio` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `esp_atn`
--
ALTER TABLE `esp_atn`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `esp_gen`
--
ALTER TABLE `esp_gen`
  MODIFY `codigoEspecialidad` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT de la tabla `piso_inst`
--
ALTER TABLE `piso_inst`
  MODIFY `id_piso` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `pr_antecedente`
--
ALTER TABLE `pr_antecedente`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT de la tabla `pr_antecedente_tipo`
--
ALTER TABLE `pr_antecedente_tipo`
  MODIFY `id_antecedente_tipo` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `pr_esp`
--
ALTER TABLE `pr_esp`
  MODIFY `id_pr_esp` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `pr_hor`
--
ALTER TABLE `pr_hor`
  MODIFY `id_pr_horario` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `sector_inst`
--
ALTER TABLE `sector_inst`
  MODIFY `id_sector` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
