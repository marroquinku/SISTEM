-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2019 a las 02:00:09
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `resolucion`
--
DROP DATABASE IF EXISTS resolucion;

CREATE DATABASE resolucion;

USE resolucion;



-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tipo_roles`
--

CREATE TABLE `tipo_roles` (
  `id_tipo_rol` int(11) NOT NULL,
  `tipo_rol` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `tipo_roles` (`id_tipo_rol`, `tipo_rol`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'MESA DE PARTES'),
(3, 'OFICINA');
--
-- Indices de la tabla `tipo_roles`
--
ALTER TABLE `tipo_roles`
  ADD PRIMARY KEY (`id_tipo_rol`);

ALTER TABLE `tipo_roles`
  MODIFY `id_tipo_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambientes`
--

CREATE TABLE `areas` (
  `id_area` int(11) NOT NULL,
  `nombre_area` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `areas`
  ADD PRIMARY KEY (`id_area`);

ALTER TABLE `areas`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

  INSERT INTO `areas` (`id_area`, `nombre_area`) VALUES
(1, 'AREA1'),
(2, 'AREA2'),
(3, 'AREA3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambientes`
--

CREATE TABLE `ambientes` (
  `id_ambiente` int(11) NOT NULL,
  `id_tipo_rol` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `nombre_ambiente` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `ambientes` (`id_ambiente`,`id_tipo_rol`,`id_area`, `nombre_ambiente`) VALUES
(1,3,3, 'ACCESO A LA INFORMACION PUBLICA'),
(2,3,3, 'ACTAS Y ARCHIVOS'),
(3,3,3, 'ADMINISTRACION'),
(4,3,3, 'AREA DE DIRECCION'),
(5,3,3, 'AREA DE GESTION INSTUTICIONAL'),
(6,3,3, 'AREA DE GESTION PEDAGOGICA'),
(7,3,3, 'BIENESTAR SOCIAL'),
(8,3,3, 'CONTRATACION TERCER TRAMO 2019'),
(9,3,3, 'GESTOR DE LA CALIDAD DE LA INFORMACION'),
(10,3,3, 'GESTOR LOCAL'),
(11,3,3, 'GESTOR MULTIGRADO'),
(12,3,3, 'INCIAL III'),
(13,2,3, 'MESA DE PARTES'),
(14,3,3, 'MODERNIZACION DE LA GESTION'),
(15,3,3, 'PLATAFORMA'),
(16,3,3, 'PREVAED'),
(17,3,3, 'SECRETARIA DE DIRECCION'),
(18,3,3, 'SECRETARIA DIRECCION II'),
(19,3,3, 'SECRETARIA FONAVI'),
(20,3,3, 'UNIDAD DE ABASTECIMIENTO'),
(21,3,3, 'UNIDAD DE ALMACEN'),
(22,3,3, 'UNIDAD DE ASESORIA JURIDICA'),
(23,3,3,'UNIDAD DE CAJA'),
(24,3,3, 'UNIDAD DE CONTABILIDAD'),
(25,3,3, 'UNIDAD DE COPROA'),
(26, 3,3,'UNIDAD DE ESCALAFON'),
(27, 3,3,'UNIDAD DE ESTADISTICA'),
(28, 3,3,'UNIDAD DE ETICA Y TRANSPARENCIA'),
(29, 3,3, 'UNIDAD DE FINANZAS'),
(30, 3,3,'UNIDAD DE INFRAESTRUCTURA'),
(31,3,3, 'UNIDAD DE MESA DE PARTES'),
(32, 3,3,'UNIDAD DE ORGANO DE CONTROL INTERNO'),
(33,3,3, 'UNIDAD DE PATRIMONIO'),
(34,3,3, 'UNIDAD DE PERSONAL'),
(35,3,3, 'UNIDAD DE PLANIFICACION'),
(36,3,3, 'UNIDAD DE PLANILLAS'),
(37,3,3, 'UNIDAD DE PROCESOS'),
(38, 3,3,'UNIDAD DE PROYECTOS'),
(39,3,3, 'UNIDAD DE RACIONALIZACION'),
(40,3,3, 'UNIDAD DE TESORERIA'),
(41,3,3, 'UNIDAD EBA EDUCACION BASICA ALTERNATIVA'),
(42,3,3, 'UNIDAD EBR EDUCACION INICIAL'),
(43,3,3, 'UNIDAD EBR EDUCACION INICIAL   3'),
(44,3,3, 'UNIDAD EBR EDUCACION INICIAL 2'),
(45,3,3, 'UNIDAD EBR EDUCACION PRIMARIA'),
(46,3,3, 'UNIDAD EBR EDUCACION PRIMARIA 3'),
(47,3,3, 'UNIDAD EBR EDUCACION PRIMARIA2'),
(48,3,3, 'UNIDAD EBR EDUCACION PRIMARIA4'),
(49,3,3, 'UNIDAD EBR EDUCACION SECUNDARIA'),
(50, 3,3,'UNIDAD EBR EDUCACION SECUNDARIA 2'),
(51,3,3, 'UNIDAD EBR EDUCACION SECUNDARIA 3'),
(52,3,3, 'UNIDAD EBR EDUCACION SECUNDARIA 4'),
(53,3,3, 'UNIDAD EBR EDUCACION SECUNDARIA 5'),
(54, 3,3,'UNIDAD EFD EDUCACION FISICA Y DEPORTE'),
(55, 3,3,'UNIDAD SEC SERVICIO EDUCATIVO Y CULTURA'),
(56, 1,3, 'ADMINISTRADOR');
--
-- Volcado de datos para la tabla `ambientes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `buzondeentrada`
--

CREATE TABLE `buzon_entradas` (
  `id_buzon` int(11) NOT NULL,
  `id_ambiente` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_resolucion` int(11) NOT NULL,
  `fecha_derivada` TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
  `fecha_recepcion` TIMESTAMP null
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE `conceptos` (
  `id_concepto` int(11) NOT NULL,
  `concepto` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `concepto`
--

INSERT INTO `conceptos` (`id_concepto`, `concepto`) VALUES
(1, 'Desginar'),
(2, 'Contratar'),
(3, 'Reubicar'),
(4, 'Cambio de escala'),
(5, 'Destacar'),
(6, 'Encargar'),
(7, 'Inscribir'),
(8, 'Cesar'),
(9, 'Reconocer'),
(10, 'Otorgar'),
(11, 'Conceder'),
(12, 'Constituir'),
(13, 'Declarar'),
(14, 'Modificar'),
(15, 'Felicitar'),
(16, 'Ampliar'),
(17, 'Separar'),
(18, 'Aprobar'),
(19, 'Desplazar temporalmemte'),
(20, 'Autorizar'),
(21, 'Dejar sin efecto'),
(22, 'Reasignar'),
(23, 'Declarar procedente'),
(24, 'Declarar Improcedente'),
(25, 'Reconocer'),
(26, 'Ascender'),
(27, 'Actualizar'),
(28, 'Establecer'),
(29, 'Afectese'),
(30, 'Disponer'),
(31, 'Archivar'),
(32, 'Instaurar Proceso Administrativo'),
(33, 'Permutar'),
(34, 'Transferir'),
(35, 'Declarar Infundado'),
(36, 'Declarar Nula'),
(37, 'Reestructurar'),
(38, 'Absolver'),
(39, 'Declarar inadmisible'),
(40, 'Declarar fundado'),
(41, 'Conformar'),
(42, 'Recesar temporalmente'),
(43, 'Reconocer y otorgar'),
(44, 'Reconocer y acumular'),
(45, 'Encargar funciones'),
(46, 'Acumular'),
(47, 'Expedir e inscribir'),
(48, 'Nombrar'),
(49, 'Ingresar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos`
--

CREATE TABLE `correos` (
  `id_correo` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `correo` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleresolucioninstitucion`
--

CREATE TABLE `detalle_resolucion_instituciones` (
  `id_detalle_res_i` int(11) NOT NULL,
  `id_institucion` int(11) NOT NULL,
  `id_resolucion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleresolucionpersona`
--

CREATE TABLE `detalle_resolucion_personas` (
  `id_detalle_res_p` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_resolucion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL,
  `tipo_estado` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `tipo_estado`) VALUES
(1, 'Cargado'),
(2, 'Despachado'),
(3, 'Pendiente de recepcion'),
(4, 'Recibido');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Nivel`
--

CREATE TABLE `niveles` (
  `id_nivel` int(11) NOT NULL,
  `nombre_nivel` varchar(90) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instituciones`
--

CREATE TABLE `instituciones` (
  `id_institucion` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `cod_modular` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `documento` varchar(12) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido_paterno` varchar(45) DEFAULT NULL,
  `apellido_materno` varchar(45) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `documento`, `nombre`, `apellido_paterno`, `apellido_materno`, `fecha_nacimiento`, `sexo`) VALUES
(1, '22101728', 'ROSARIO HIPOLITA', 'SEGOVIA', 'MALDONADO', '1959-02-03', 'F'),
(2, '21829597', 'ARISTEDES', 'GONZALES', 'ZAGACETA', '1955-09-01', 'M'),
(3, '21856533', 'OSCAR JAVIER', 'HERNANDEZ', 'APARCANA', '1967-04-08', 'M'),
(4, '21812049', 'CESAR ORLANDO', 'MATEO', 'PACHAS', '1967-12-06', 'M'),
(5, '21784358', 'MARIA BEATRIZ', 'PACHAS', 'ESPINOZA', '1965-02-20', 'F'),
(6, '21877438', 'WILBERT', 'TORRES', 'MATIAS', '1976-08-21', 'M'),
(7, '21814486', 'LUIS ENRIQUE', 'FELIX', 'TIPIAN', '1969-03-21', 'M'),
(8, '21845027', 'JHONY ANGEL', 'CANCHARI', 'QUISPE', '1972-01-17', 'M'),
(9, '21864017', 'JOSE JAIME', 'TORRES', 'LOYOLA', '1973-08-20', 'M'),
(10, '21480777', 'OBDULIO JAVIER', 'PINO', 'BARRIOS', '1970-09-22', 'M'),
(11, '09641776', 'ROCIO DEL CARMEN', 'ENCISO', 'GALVEZ', '1968-03-30', 'F'),
(12, '21851991', 'ALBERTO', 'SOLARI', 'QUISPE', '1969-08-26', 'M'),
(13, '40445863', 'SILVIA LISSET', 'PACHAS', 'MATTA', '1979-12-18', 'F'),
(14, '21492749', 'CARLOS ISIDRO', 'RAMOS', 'ESPINO', '1949-05-15', 'M'),
(15, '32819566', 'LUIS ENRIQUE', 'FLORES', 'VERGARAY', '1962-05-28', 'M'),
(16, '22186516', 'ADOLFO ARMANDO', 'LOBO', 'QUIJAITE', '1966-07-23', 'M'),
(17, '21801899', 'ALBERTO', 'PALMA', 'MORALES', '1950-10-05', 'M'),
(18, '21546174', 'LUIS GUILLERMO', 'OJEDA', 'ROJAS', '1960-06-25', 'M'),
(19, '21471963', 'CRISTOBAL FIDENCIO', 'MATOS', 'HUARCAYA', '1958-11-15', 'M'),
(20, '21471126', 'LEOCADIO CECILIO', 'JUNES', 'AVILA', '1957-12-09', 'M'),
(21, '43505120', 'EVELYN PAOLA', 'AYBAR', 'PARIONA', '1986-02-28', 'F'),
(22, '21785399', 'FERNANDO VICENTE', 'MAGALLANES', 'MENDOZA', '1952-07-19', 'M'),
(23, '21826121', 'LUCY JESUS', 'ZAMBRANO', 'FALCON', '1963-12-25', 'F'),
(24, '21833102', 'AGUSTIN', 'TASAYCO', 'VILLA', '1959-04-29', 'M'),
(25, '21877585', 'FREDDY RAUL', 'PACHAS', 'ALMEYDA', '1976-07-15', 'M'),
(26, '44556128', 'ANGEL MARTIN', 'RIOS', 'YATACO', '1987-09-25', 'M'),
(27, '21803369', 'OSCAR LEONIDAS', 'GUILLINTA', 'DOMINGUEZ', '1951-11-16', 'M'),
(28, '21863526', 'TOMAS ENRIQUE', 'PAUCAR', 'VELIZ', '1973-03-04', 'M'),
(29, '21472800', 'JAVIER MARTIN', 'RAMOS', 'HERNANDEZ', '1963-09-30', 'M'),
(30, '09240814', 'ALFONSO MIGUEL', 'AVALOS', 'NAPA', '1957-04-27', 'M'),
(31, '21404167', 'LILIA', 'MOREYRA', 'BELLIDO DE AVALOS', '1959-12-20', 'F'),
(32, '21430059', 'FANI LUZ', 'MANCHEGO', 'CACERES', '1960-09-20', 'F'),
(33, '21799468', 'RINA VALENTINA', 'DE LA CRUZ', 'DE DEL CARPIO', '1954-08-06', 'F'),
(34, '21791901', 'ELBA ELIZABETH', 'QUISPE', 'VILLA', '1963-01-02', 'F'),
(35, '21795732', 'MARLENE ANGELICA', 'MAGALLANES', 'RAMOS', '1965-04-18', 'F'),
(36, '21798382', 'ALEJANDRINA NORMA', 'POICON', 'PACORA', '1950-04-01', 'F'),
(37, '21799548', 'MARIA ELENA', 'MONDALGO', 'BERNAOLA', '1950-04-06', 'F'),
(38, '21831725', 'NELLY LORENA', 'ALMEYDA', 'TOULLIER', '1962-01-25', 'F'),
(39, '21857793', 'MERCEDES MARGARITA', 'YACHI', 'MENDOZA', '1969-02-07', 'F'),
(40, '21450152', 'JUAN ASUNCION', 'CANTORAL', 'ANTEZANA', '1958-05-30', 'M'),
(41, '21858450', 'CARLOS ADOLFO', 'FELIX', 'LENGUA', '1969-03-03', 'M'),
(42, '21795890', 'AURORA VERONICA', 'ALMEYDA', 'ALEJOS', '1954-01-13', 'F'),
(43, '25727759', 'CLAUDIO MARCELINO', 'MORENO', 'COTOS', '1955-03-02', 'M'),
(44, '21831868', 'JUAN PEDRO', 'TASAYCO', 'SARAVIA', '1955-04-04', 'M'),
(45, '40020750', 'MANUEL JESUS', 'AVALOS', 'SARAVIA', '1978-08-30', 'M'),
(46, '40688633', 'JESSICA BEATRIZ', 'MARTINEZ', 'CUETO', '1980-10-25', 'F'),
(47, '21823912', 'MARIBEL GABY', 'MATTA', 'LENGUA', '1968-04-20', 'F'),
(48, '80178294', 'CHRISTIAN', 'UBILLUS', 'YATACO', '1979-01-19', 'M'),
(49, '21856620', 'JUAN PABLO', 'TORRES', 'GALLARDO', '1964-11-07', 'M'),
(50, '21881916', 'JUANA', 'ALDAZABAL', 'FIERRO', '1968-06-12', 'F'),
(51, '21873188', 'MERCEDES', 'TASAYCO', 'OBANDO', '1974-09-24', 'F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resoluciones`
--

CREATE TABLE `resoluciones` (
  `id_resolucion` int(11) NOT NULL,
  `id_tipo_resolucion` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_usuario_ambiente` int(11) NOT NULL,
  `proyecto` varchar(45) DEFAULT NULL,
  `id_concepto` int(11) DEFAULT NULL,
  `numero` varchar(45) DEFAULT NULL,
  `anio` varchar(45) DEFAULT NULL,
  `archivo` longblob,
  `fecha_emision` date
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonos`
--

CREATE TABLE `telefonos` (
  `id_telefono` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `numero` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiporesolucion`
--

CREATE TABLE `tipo_resoluciones` (
  `id_tipo_resolucion` int(11) NOT NULL,
  `tipo_resolucion` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tiporesolucion`
--

INSERT INTO `tipo_resoluciones` (`id_tipo_resolucion`, `tipo_resolucion`) VALUES
(1, 'Directoral'),
(2, 'Regional'),
(3, 'Jefactural');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `usuario` varchar(90) DEFAULT NULL,
  `contrasenia` varchar(180) DEFAULT NULL,
  `estado` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `usuarios` (`id_usuario`, `id_persona`, `usuario`, `contrasenia`) VALUES
(1, 1, 'RSEGOVIA@ugelchincha.gob.pe', '123456789'),
(2, 2, 'AGONZALES@ugelchincha.gob.pe', '123456789'),
(3, 3, 'OHERNANDEZ@ugelchincha.gob.pe', '123456789'),
(4, 4, 'CMATEO@ugelchincha.gob.pe', '123456789'),
(5, 5, 'MPACHAS@ugelchincha.gob.pe', '123456789'),
(6, 6, 'WTORRES@ugelchincha.gob.pe', '123456789'),
(7, 7, 'LFELIX@ugelchincha.gob.pe', '123456789'),
(8, 8, 'JCANCHARI@ugelchincha.gob.pe', '123456789'),
(9, 9, 'JTORRES@ugelchincha.gob.pe', '123456789'),
(10, 10, 'OPINO@ugelchincha.gob.pe', '123456789'),
(11, 11, 'RENCISO@ugelchincha.gob.pe', '123456789'),
(12, 12, 'ASOLARI@ugelchincha.gob.pe', '123456789'),
(13, 13, 'SPACHAS@ugelchincha.gob.pe', '123456789'),
(14, 14, 'CRAMOS@ugelchincha.gob.pe', '123456789'),
(15, 15, 'LFLORES@ugelchincha.gob.pe', '123456789'),
(16, 16, 'ALOBO@ugelchincha.gob.pe', '123456789'),
(17, 17, 'APALMA@ugelchincha.gob.pe', '123456789'),
(18, 18, 'LOJEDA@ugelchincha.gob.pe', '123456789'),
(19, 19, 'CMATOS@ugelchincha.gob.pe', '123456789'),
(20, 20, 'LJUNES@ugelchincha.gob.pe', '123456789'),
(21, 21, 'EAYBAR@ugelchincha.gob.pe', '123456789'),
(22, 22, 'FMAGALLANES@ugelchincha.gob.pe', '123456789'),
(23, 23, 'LZAMBRANO@ugelchincha.gob.pe', '123456789'),
(24, 24, 'ATASAYCO@ugelchincha.gob.pe', '123456789'),
(25, 25, 'FPACHAS@ugelchincha.gob.pe', '123456789'),
(26, 26, 'ARIOS@ugelchincha.gob.pe', '123456789'),
(27, 27, 'OGUILLINTA@ugelchincha.gob.pe', '123456789'),
(28, 28, 'TPAUCAR@ugelchincha.gob.pe', '123456789'),
(29, 29, 'JRAMOS@ugelchincha.gob.pe', '123456789'),
(30, 30, 'AAVALOS@ugelchincha.gob.pe', '123456789'),
(31, 31, 'LMOREYRA@ugelchincha.gob.pe', '123456789'),
(32, 32, 'FMANCHEGO@ugelchincha.gob.pe', '123456789'),
(33, 33, 'RDE LA CRUZ@ugelchincha.gob.pe', '123456789'),
(34, 34, 'EQUISPE@ugelchincha.gob.pe', '123456789'),
(35, 35, 'MMAGALLANES@ugelchincha.gob.pe', '123456789'),
(36, 36, 'APOICON@ugelchincha.gob.pe', '123456789'),
(37, 37, 'MMONDALGO@ugelchincha.gob.pe', '123456789'),
(38, 38, 'NALMEYDA@ugelchincha.gob.pe', '123456789'),
(39, 39, 'MYACHI@ugelchincha.gob.pe', '123456789'),
(40, 40, 'JCANTORAL@ugelchincha.gob.pe', '123456789'),
(41, 41, 'CFELIX@ugelchincha.gob.pe', '123456789'),
(42, 42, 'AALMEYDA@ugelchincha.gob.pe', '123456789'),
(43, 43, 'CMORENO@ugelchincha.gob.pe', '123456789'),
(44, 44, 'JTASAYCO@ugelchincha.gob.pe', '123456789'),
(45, 45, 'MAVALOS@ugelchincha.gob.pe', '123456789'),
(46, 46, 'JMARTINEZ@ugelchincha.gob.pe', '123456789'),
(47, 47, 'MMATTA@ugelchincha.gob.pe', '123456789'),
(48, 48, 'CUBILLUS@ugelchincha.gob.pe', '123456789'),
(49, 49, 'JPTORRES@ugelchincha.gob.pe', '123456789'),
(50, 50, 'JALDAZABAL@ugelchincha.gob.pe', '123456789'),
(51, 51, 'MTASAYCO@ugelchincha.gob.pe', '123456789');

--
-- Volcado de datos para la tabla `usuarios`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosambientes`
--

CREATE TABLE `usuario_ambientes` (
  `id_usuario_ambiente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_ambiente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `usuario_ambientes` (`id_usuario_ambiente`, `id_usuario`, `id_ambiente`) VALUES ('2', '1', '56');
--
-- Indices de la tabla `ambientes`
--
ALTER TABLE `ambientes`
  ADD PRIMARY KEY (`id_ambiente`),
  ADD KEY `fk_ambientes_tipo_roles_idx` (`id_tipo_rol`),
  ADD KEY `fk_ambientes_area_idx` (`id_area`);
--
-- Indices de la tabla `buzondeentrada`
--
ALTER TABLE `buzon_entradas`
  ADD PRIMARY KEY (`id_buzon`,`id_ambiente`,`id_estado`,`id_resolucion`),
  ADD KEY `fk_buzonEntrada_ambientes_idx` (`id_ambiente`),
  ADD KEY `fk_buzonEntrada_estado_idx` (`id_estado`),
  ADD KEY `fk_buzonEntrada_idResolucion_idx` (`id_resolucion`);

--
-- Indices de la tabla `concepto`
--
ALTER TABLE `conceptos`
  ADD PRIMARY KEY (`id_concepto`);

--
-- Indices de la tabla `instituciones`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id_nivel`);
--
-- Indices de la tabla `correos`
--
ALTER TABLE `correos`
  ADD PRIMARY KEY (`id_correo`,`id_persona`),
  ADD UNIQUE KEY `constraint_correo` (`correo`),
  ADD KEY `fk_Correos_Personas_idx` (`id_persona`);

--
-- Indices de la tabla `detalleresolucioninstitucion`
--
ALTER TABLE `detalle_resolucion_instituciones`
  ADD PRIMARY KEY (`id_detalle_res_i`,`id_institucion`,`id_resolucion`),
  ADD KEY `fk_detalleResolucionInstitucion_instituciones1_idx` (`id_institucion`),
  ADD KEY `fk_detalleResolucionInstitucion_resoluciones1_idx` (`id_resolucion`);

--
-- Indices de la tabla `detalleresolucionpersona`
--
ALTER TABLE `detalle_resolucion_personas`
  ADD PRIMARY KEY (`id_detalle_res_p`,`id_persona`,`id_resolucion`),
  ADD KEY `fk_detalleResolucionPersona_personas1_idx` (`id_persona`),
  ADD KEY `fk_detalleResolucionPersona_resoluciones1_idx` (`id_resolucion`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  ADD PRIMARY KEY (`id_institucion`,`id_nivel`),
  ADD KEY `fk_instituciones_niveles_idx` (`id_nivel`),
  ADD UNIQUE KEY `constraint_codigo_modular` (`cod_modular`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD UNIQUE KEY `constraint_documento` (`documento`);

--
-- Indices de la tabla `resoluciones`
--
ALTER TABLE `resoluciones`
  ADD PRIMARY KEY (`id_resolucion`,`id_tipo_resolucion`,`id_estado`,`id_usuario_ambiente`),
  ADD KEY `fk_Resoluciones_Estados1_idx` (`id_estado`),
  ADD KEY `fk_Resoluciones_TipoResolucion1_idx` (`id_tipo_resolucion`),
  ADD KEY `fk_Resoluciones_UsuariosAmbientes1_idx` (`id_usuario_ambiente`),
  ADD KEY `fk_Resoluciones_Concepto` (`id_concepto`);

--
-- Indices de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD PRIMARY KEY (`id_telefono`),
  ADD UNIQUE KEY `constraint_numero` (`numero`),
  ADD KEY `fk_Telefonos_Personas1` (`id_persona`);

--
-- Indices de la tabla `tiporesolucion`
--
ALTER TABLE `tipo_resoluciones`
  ADD PRIMARY KEY (`id_tipo_resolucion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`,`id_persona`),
  ADD UNIQUE KEY `constraint_usuario` (`usuario`),
  ADD KEY `fk_Usuarios_Personas1_idx` (`id_persona`);

--
-- Indices de la tabla `usuariosambientes`
--
ALTER TABLE `usuario_ambientes`
  ADD PRIMARY KEY (`id_usuario_ambiente`,`id_usuario`,`id_ambiente`),
  ADD KEY `fk_UsuariosAmbientes_Usuarios1_idx` (`id_usuario`),
  ADD KEY `fk_UsuariosAmbientes_Ambientes1_idx` (`id_ambiente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ambientes`
--
ALTER TABLE `ambientes`
  MODIFY `id_ambiente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `ambientes`
--
ALTER TABLE `niveles`
  MODIFY `id_nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `buzondeentrada`
--
ALTER TABLE `buzon_entradas`
  MODIFY `id_buzon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `concepto`
--
ALTER TABLE `conceptos`
  MODIFY `id_concepto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `correos`
--
ALTER TABLE `correos`
  MODIFY `id_correo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalleresolucioninstitucion`
--
ALTER TABLE `detalle_resolucion_instituciones`
  MODIFY `id_detalle_res_i` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalleresolucionpersona`
--
ALTER TABLE `detalle_resolucion_personas`
  MODIFY `id_detalle_res_p` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  MODIFY `id_institucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `resoluciones`
--
ALTER TABLE `resoluciones`
  MODIFY `id_resolucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  MODIFY `id_telefono` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tiporesolucion`
--
ALTER TABLE `tipo_resoluciones`
  MODIFY `id_tipo_resolucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `usuariosambientes`
--
ALTER TABLE `usuario_ambientes`
  MODIFY `id_usuario_ambiente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `buzondeentrada`
--
ALTER TABLE `buzon_entradas`
  ADD CONSTRAINT `fk_buzonDeEntrada_ambientes` FOREIGN KEY (`id_ambiente`) REFERENCES `ambientes` (`id_ambiente`),
  ADD CONSTRAINT `fk_buzonDeEntrada_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `fk_buzonDeEntrada_resoluciones` FOREIGN KEY (`id_resolucion`) REFERENCES `resoluciones` (`id_resolucion`);

--
-- Filtros para la tabla `correos`
--
ALTER TABLE `correos`
  ADD CONSTRAINT `fk_Correos_Personas` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `detalleresolucioninstitucion`
--
ALTER TABLE `detalle_resolucion_instituciones`
  ADD CONSTRAINT `fk_detalleResolucionInstitucion_instituciones1` FOREIGN KEY (`id_institucion`) REFERENCES `instituciones` (`id_institucion`),
  ADD CONSTRAINT `fk_detalleResolucionInstitucion_resoluciones1` FOREIGN KEY (`id_resolucion`) REFERENCES `resoluciones` (`id_resolucion`);

--
-- Filtros para la tabla `detalleresolucionpersona`
--
ALTER TABLE `detalle_resolucion_personas`
  ADD CONSTRAINT `fk_detalleResolucionPersona_personas1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `fk_detalleResolucionPersona_resoluciones1` FOREIGN KEY (`id_resolucion`) REFERENCES `resoluciones` (`id_resolucion`);

--
-- Filtros para la tabla `resoluciones`
--
ALTER TABLE `resoluciones`
  ADD CONSTRAINT `fk_Resoluciones_Concepto` FOREIGN KEY (`id_concepto`) REFERENCES `conceptos` (`id_concepto`),
  ADD CONSTRAINT `fk_Resoluciones_Estados1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `fk_Resoluciones_TipoResolucion1` FOREIGN KEY (`id_tipo_resolucion`) REFERENCES `tipo_resoluciones` (`id_tipo_resolucion`),
  ADD CONSTRAINT `fk_Resoluciones_UsuariosAmbientes1` FOREIGN KEY (`id_usuario_ambiente`) REFERENCES `usuario_ambientes` (`id_usuario_ambiente`);

--
-- Filtros para la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD CONSTRAINT `fk_Telefonos_Personas1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_Usuarios_Personas1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `usuariosambientes`
--
ALTER TABLE `usuario_ambientes`
  ADD CONSTRAINT `fk_UsuariosAmbientes_Ambientes1` FOREIGN KEY (`id_ambiente`) REFERENCES `ambientes` (`id_ambiente`),
  ADD CONSTRAINT `fk_UsuariosAmbientes_Usuarios1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `ambientes`
  ADD CONSTRAINT `fk_ambientes_tipo_rol` FOREIGN KEY (`id_tipo_rol`) REFERENCES `tipo_roles` (`id_tipo_rol`),
  ADD CONSTRAINT `fk_ambientes_area` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id_area`);

ALTER TABLE `instituciones`
  ADD CONSTRAINT `fk_instituciones_nivel` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
