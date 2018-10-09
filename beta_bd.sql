-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2018 a las 16:55:05
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `beta_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bases_datos`
--

CREATE TABLE `bases_datos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `base` int(15) NOT NULL,
  `local` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bases_denominaciones`
--

CREATE TABLE `bases_denominaciones` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `base_id` int(15) NOT NULL,
  `denominacion_id` int(15) NOT NULL,
  `denominacion` varchar(15) NOT NULL,
  `cantidad` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierres_datos`
--

CREATE TABLE `cierres_datos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `cierre` int(15) NOT NULL,
  `local` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierres_denominaciones`
--

CREATE TABLE `cierres_denominaciones` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `cierre_id` int(15) NOT NULL,
  `denominacion_id` int(15) NOT NULL,
  `denominacion` varchar(15) NOT NULL,
  `cantidad` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `documento_tipo` varchar(15) NOT NULL,
  `documento` varchar(15) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `fecha`, `usuario`, `nombre`, `documento_tipo`, `documento`, `correo`, `telefono`, `direccion`) VALUES
(1, '2018-06-17 18:48:49', 1, 'danny estrada', 'CC', '8359856', 'dannyws@gmail.com', '3124450363', 'calle 23 55 - 77'),
(2, '2018-07-16 15:42:41', 1, 'javi fajardo', 'CC', '9999', '', '5676767', 'calle de la ostia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componentes`
--

CREATE TABLE `componentes` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `unidad_compra` varchar(50) NOT NULL,
  `componente` varchar(255) NOT NULL,
  `costo_unidad` varchar(15) NOT NULL,
  `costo_unidad_compra` varchar(15) NOT NULL,
  `proveedor` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `componentes`
--

INSERT INTO `componentes` (`id`, `fecha`, `usuario`, `unidad`, `unidad_compra`, `componente`, `costo_unidad`, `costo_unidad_compra`, `proveedor`) VALUES
(1, '2018-07-31 18:17:27', 1, 'unid', 'unid', 'cerveza', '', '', 1),
(2, '2018-07-31 17:10:53', 1, 'ml', 'l', 'aceite', '1.3', '1300', 2),
(3, '2018-07-31 16:57:57', 1, 'unid', 'treintena', 'huevo', '266.66666666667', '8000', 2),
(4, '2018-07-31 16:58:08', 1, 'g', 'k', 'sal', '1.3', '1300', 2),
(5, '2018-07-31 16:58:19', 1, 'g', 'k', 'limon', '2.3', '2300', 2),
(6, '2018-07-31 17:12:04', 1, 'g', 'k', 'harina', '2.5', '2500', 2),
(7, '2018-07-31 17:21:06', 1, 'unid', 'unid', 'agua', '900', '900', 0),
(8, '2018-08-28 21:07:59', 1, 'g', 'g', 'zanahoria', '10.5', '10.5', 2),
(9, '2018-09-10 15:54:44', 1, 'g', 'k', 'tomate', '1', '1000', 2),
(10, '2018-09-10 15:54:49', 1, 'g', 'k', 'tomate', '1', '1000', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componentes_producidos`
--

CREATE TABLE `componentes_producidos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `unidad_produccion` varchar(50) NOT NULL,
  `componente` varchar(255) NOT NULL,
  `costo_unidad` varchar(15) NOT NULL,
  `costo_unidad_produccion` varchar(15) NOT NULL,
  `productor` int(15) NOT NULL,
  `preparacion` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `componentes_producidos`
--

INSERT INTO `componentes_producidos` (`id`, `fecha`, `usuario`, `unidad`, `unidad_produccion`, `componente`, `costo_unidad`, `costo_unidad_produccion`, `productor`, `preparacion`) VALUES
(1, '2018-07-31 18:01:45', 1, 'unid', 'unid', 'mayonesa casera', '0', '0', 1, 'Separamos las yemas de las claras de huevo.\r\nColocamos las yemas con 1 cucharadita de mostaza y 1 cucharadita de jugo de limÃ³n en un recipiente para batir. Con la ayuda de una batidora elÃ©ctrica, batimos estos ingredientes hasta que tengan una consistencia homogÃ©nea.\r\nCuando estÃ© bien mezclado, aÃ±adimos poco a poco el aceite de oliva en un hilo continuo. AÃ±adimos un poco, batimos, aÃ±adimos un poco mÃ¡s, batimos, y asÃ­ sucesivamente hasta incorporar todo el aceite. Al final nuestra mezcla serÃ¡ mÃ¡s amarillita y mÃ¡s espesa.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `composiciones_componentes_producidos`
--

CREATE TABLE `composiciones_componentes_producidos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `componente_producido` int(15) NOT NULL,
  `componente` int(15) NOT NULL,
  `cantidad` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes_ingreso`
--

CREATE TABLE `comprobantes_ingreso` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario_id` int(15) NOT NULL,
  `venta_id` int(15) NOT NULL,
  `valor` varchar(15) NOT NULL,
  `tipo_pago_id` int(15) NOT NULL,
  `tipo_pago` varchar(50) NOT NULL,
  `concepto` text NOT NULL,
  `observaciones` text NOT NULL,
  `consecutivo` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comprobantes_ingreso`
--

INSERT INTO `comprobantes_ingreso` (`id`, `fecha`, `usuario_id`, `venta_id`, `valor`, `tipo_pago_id`, `tipo_pago`, `concepto`, `observaciones`, `consecutivo`) VALUES
(1, '2018-07-24 11:39:31', 1, 1, '1000', 1, 'efectivo', 'unico pago', 'sin observaciones', 1),
(2, '2018-07-24 11:40:27', 1, 2, '1500', 1, 'efectivo', 'primer pago', 'sin observaciones', 1),
(3, '2018-07-24 11:53:04', 1, 3, '2000', 0, '2', 'abono', 'se paga en la cuenta bancolombia', 0),
(4, '2018-07-24 11:56:13', 1, 3, '2000', 2, 'Tarjeta', 'abono', 'se paga en la cuenta bancolombia', 0),
(5, '2018-07-24 11:56:59', 1, 3, '2000', 2, 'Tarjeta', 'abono', 'se paga en la cuenta bancolombia', 0),
(6, '2018-07-27 16:59:41', 1, 4, '1000', 1, 'efectivo', 'primer pago', 'sin observaciones', 1),
(7, '2018-07-27 17:03:04', 1, 4, '2000', 1, 'Efectivo', 'abono', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `denominaciones`
--

CREATE TABLE `denominaciones` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `denominacion` int(15) NOT NULL,
  `tipo` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `denominaciones`
--

INSERT INTO `denominaciones` (`id`, `fecha`, `usuario`, `denominacion`, `tipo`) VALUES
(1, '2017-11-04 18:46:35', 1, 50000, 'billete'),
(2, '2017-11-04 18:46:35', 1, 20000, 'billete'),
(3, '2017-11-04 18:46:35', 1, 10000, 'billete'),
(4, '2017-11-04 18:46:35', 1, 5000, 'billete'),
(5, '2017-11-04 18:46:35', 1, 2000, 'billete'),
(6, '2017-11-04 18:46:35', 1, 1000, 'billete'),
(7, '2017-11-04 18:46:35', 1, 500, 'billete'),
(8, '2017-11-04 18:46:35', 1, 200, 'billete'),
(9, '2017-11-04 18:46:35', 1, 100, 'billete'),
(10, '2017-11-04 18:46:35', 1, 50, 'billete');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id` int(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `descuento` varchar(150) NOT NULL,
  `porcentaje` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`id`, `fecha`, `usuario`, `descuento`, `porcentaje`) VALUES
(1, '2018-06-17 17:29:27', 1, 'cortesia', 100),
(2, '2018-06-17 17:29:40', 1, 'socios y amigos', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despachos`
--

CREATE TABLE `despachos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `fecha_envio` datetime NOT NULL,
  `fecha_recibe` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `origen` int(15) NOT NULL,
  `destino` int(15) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `usuario_recibe` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `despachos`
--

INSERT INTO `despachos` (`id`, `fecha`, `fecha_envio`, `fecha_recibe`, `usuario`, `origen`, `destino`, `estado`, `usuario_recibe`) VALUES
(1, '2018-07-21 18:34:31', '2018-07-21 18:41:40', '0000-00-00 00:00:00', 1, 0, 1, 'enviado', 0),
(2, '2018-07-21 18:41:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 1, 'creado', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despachos_componentes`
--

CREATE TABLE `despachos_componentes` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `despacho_id` int(15) NOT NULL,
  `componente_id` int(15) NOT NULL,
  `cantidad` int(15) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `despachos_componentes`
--

INSERT INTO `despachos_componentes` (`id`, `fecha`, `usuario`, `despacho_id`, `componente_id`, `cantidad`, `estado`) VALUES
(1, '2018-07-21 18:41:38', 1, 1, 2, 30, 'enviado'),
(2, '2018-07-21 18:41:56', 1, 2, 4, 1000, 'creado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_plantillas`
--

CREATE TABLE `facturas_plantillas` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `regimen` varchar(50) NOT NULL,
  `texto_superior` text NOT NULL,
  `resolucion_numero` varchar(20) NOT NULL,
  `resolucion_fecha` datetime NOT NULL,
  `resolucion_prefijo` varchar(15) NOT NULL,
  `resolucion_desde` int(20) NOT NULL,
  `resolucion_hasta` int(20) NOT NULL,
  `texto_inferior` text NOT NULL,
  `local` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los datos de las mesas, barras, puntos de venta...';

--
-- Volcado de datos para la tabla `facturas_plantillas`
--

INSERT INTO `facturas_plantillas` (`id`, `fecha`, `usuario`, `nombre`, `titulo`, `regimen`, `texto_superior`, `resolucion_numero`, `resolucion_fecha`, `resolucion_prefijo`, `resolucion_desde`, `resolucion_hasta`, `texto_inferior`, `local`) VALUES
(1, '2018-06-17 22:05:20', 1, 'plantilla 1', 'factura de venta', 'comÃºn', 'Restaurante todo rico SAS\r\nNIT 9453627', '9785645342312', '2018-06-01 00:00:00', 'A', 1, 100, 'Gracias por su compra', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `concepto` varchar(150) NOT NULL,
  `valor` int(15) NOT NULL,
  `local` int(15) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `fecha_pago` datetime NOT NULL,
  `periodicidad` int(3) NOT NULL,
  `imagen` varchar(2) NOT NULL,
  `imagen_nombre` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los distintos tipos de impuestos';

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id`, `fecha`, `usuario`, `tipo`, `concepto`, `valor`, `local`, `estado`, `fecha_pago`, `periodicidad`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-07-27 16:00:30', 1, 'operativo', 'pago nomina', 200000, 1, 'pagado', '2018-07-27 00:00:00', 0, 'si', '20180727160030');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuestos`
--

CREATE TABLE `impuestos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `impuesto` varchar(50) NOT NULL,
  `porcentaje` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los distintos tipos de impuestos';

--
-- Volcado de datos para la tabla `impuestos`
--

INSERT INTO `impuestos` (`id`, `fecha`, `usuario`, `impuesto`, `porcentaje`) VALUES
(1, '2018-06-17 17:28:39', 1, 'iva', 19),
(2, '2018-06-17 17:28:49', 1, 'sin impuesto', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `componente_id` int(15) NOT NULL,
  `componente` varchar(150) NOT NULL,
  `cantidad` varchar(15) NOT NULL,
  `unidad` varchar(150) NOT NULL,
  `minimo` varchar(15) NOT NULL,
  `maximo` varchar(15) NOT NULL,
  `local_id` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_novedades`
--

CREATE TABLE `inventario_novedades` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `inventario_id` int(15) NOT NULL,
  `cantidad_anterior` int(15) NOT NULL,
  `operacion` varchar(15) NOT NULL,
  `cantidad_modificada` int(15) NOT NULL,
  `cantidad_nueva` int(15) NOT NULL,
  `motivo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los datos de las mesas, barras, puntos de venta...';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locales`
--

CREATE TABLE `locales` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `local` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `apertura` time NOT NULL,
  `cierre` time NOT NULL,
  `propina` int(3) NOT NULL,
  `imagen` varchar(2) NOT NULL,
  `imagen_nombre` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los locales y puntos de venta';

--
-- Volcado de datos para la tabla `locales`
--

INSERT INTO `locales` (`id`, `fecha`, `usuario`, `local`, `direccion`, `telefono`, `tipo`, `apertura`, `cierre`, `propina`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-06-18 00:00:06', 1, 'poblado', 'calle 10 no 42 - 28', '6028639', 'punto de venta', '10:00:00', '23:00:00', 0, 'si', '20180617231628'),
(2, '2018-06-15 18:12:32', 1, 'laureles', 'calle 33 No 18 - 20', '3457689', 'punto de venta', '10:00:00', '23:00:00', 10, 'si', '20180615181232'),
(3, '2018-06-15 18:14:37', 1, 'envigado', 'calle 34 No 76 - 12', '3871122', 'punto de venta', '11:00:00', '22:00:00', 10, 'si', '20180615181437');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producciones`
--

CREATE TABLE `producciones` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `fecha_envio` datetime NOT NULL,
  `fecha_recibe` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `origen` int(15) NOT NULL,
  `destino` int(15) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `usuario_recibe` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producciones`
--

INSERT INTO `producciones` (`id`, `fecha`, `fecha_envio`, `fecha_recibe`, `usuario`, `origen`, `destino`, `estado`, `usuario_recibe`) VALUES
(1, '2018-07-23 18:03:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 1, 'creado', 0),
(2, '2018-09-11 14:23:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 3, 'creado', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producciones_componentes`
--

CREATE TABLE `producciones_componentes` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `produccion_id` int(15) NOT NULL,
  `componente_id` int(15) NOT NULL,
  `cantidad` int(15) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producciones_componentes`
--

INSERT INTO `producciones_componentes` (`id`, `fecha`, `usuario`, `produccion_id`, `componente_id`, `cantidad`, `estado`) VALUES
(3, '2018-07-23 18:25:20', 1, 1, 5, 2, 'creado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `categoria` int(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `local` int(255) NOT NULL,
  `zona` int(15) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `precio` int(255) NOT NULL,
  `impuesto_id` int(15) NOT NULL,
  `impuesto_incluido` varchar(15) NOT NULL,
  `descripcion` text,
  `codigo_barras` varchar(100) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `imagen_nombre` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `fecha`, `usuario`, `categoria`, `tipo`, `local`, `zona`, `producto`, `precio`, `impuesto_id`, `impuesto_incluido`, `descripcion`, `codigo_barras`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-07-31 16:41:34', 1, 1, 'simple', 0, 2, 'cerveza', 3000, 1, 'si', 'rica cerveza', '', 'no', '20180731164134'),
(2, '2018-07-31 17:33:15', 1, 1, 'simple', 0, 2, 'agua', 2000, 1, 'si', 'refrescante agua', '', 'no', '20180731172106');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_categorias`
--

CREATE TABLE `productos_categorias` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `adicion` varchar(5) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `imagen` varchar(2) NOT NULL,
  `imagen_nombre` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena las categorías en las que están divididas los produ';

--
-- Volcado de datos para la tabla `productos_categorias`
--

INSERT INTO `productos_categorias` (`id`, `fecha`, `usuario`, `categoria`, `tipo`, `adicion`, `estado`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-07-31 14:38:33', 1, 'bebidas', 'productos', 'no', 'activo', 'no', '20180731143833'),
(2, '2018-07-31 14:39:10', 1, 'platos fuertes', 'productos', 'no', 'activo', 'no', '20180731143910');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_composiciones`
--

CREATE TABLE `productos_composiciones` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `producto` int(15) NOT NULL,
  `componente` int(15) NOT NULL,
  `cantidad` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos_composiciones`
--

INSERT INTO `productos_composiciones` (`id`, `fecha`, `usuario`, `producto`, `componente`, `cantidad`) VALUES
(2, '2018-07-31 16:45:59', 1, 1, 1, '1'),
(3, '2018-07-31 17:21:06', 1, 2, 7, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `proveedor` varchar(255) NOT NULL,
  `documento_tipo` varchar(30) NOT NULL,
  `documento` varchar(30) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `imagen` varchar(2) NOT NULL,
  `imagen_nombre` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `fecha`, `usuario`, `proveedor`, `documento_tipo`, `documento`, `correo`, `telefono`, `direccion`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-07-21 17:14:42', 1, 'la careta', 'NIT', '90909090', 'ventas@lacareta.com', '345454545', 'carrera 45 No 56 - 89', 'si', '20180721165206'),
(2, '2018-07-21 17:22:54', 1, 'carulla', 'NIT', '83598787', 'ventas@carulla.comx', '23445566666', 'calle falsa 123xx', 'no', '20180721170415');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_pagos`
--

CREATE TABLE `tipos_pagos` (
  `id` int(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `tipo_pago` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los diferentes tipos de pagos ';

--
-- Volcado de datos para la tabla `tipos_pagos`
--

INSERT INTO `tipos_pagos` (`id`, `fecha`, `usuario`, `tipo_pago`, `tipo`) VALUES
(1, '2018-06-17 17:29:05', 1, 'efectivo', 'efectivo'),
(2, '2018-06-17 17:29:15', 1, 'tarjeta', 'tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `ubicacion` varchar(50) NOT NULL,
  `ubicada` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `local` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los datos de las mesas, barras, puntos de venta...';

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`id`, `fecha`, `usuario`, `ubicacion`, `ubicada`, `estado`, `tipo`, `local`) VALUES
(1, '2018-06-15 17:53:55', 1, 'mesa 1', 'terraza', 'ocupado', 'mesa', 1),
(2, '2018-06-15 17:53:58', 1, 'mesa 2', 'terraza', 'ocupado', 'mesa', 1),
(3, '2018-06-15 17:54:00', 1, 'mesa 3', 'terraza', 'ocupado', 'mesa', 1),
(4, '2018-06-15 17:54:15', 1, 'domicilio', 'terraza', 'libre', 'domicilio', 1),
(5, '2018-06-17 21:30:09', 1, 'mesa 1', 'terraza', 'libre', 'mesa', 2),
(6, '2018-06-17 21:30:13', 1, 'mesa 2', 'terraza', 'libre', 'mesa', 2),
(7, '2018-06-17 21:30:15', 1, 'mesa 3', 'terraza', 'libre', 'mesa', 2),
(8, '2018-06-25 11:25:33', 1, 'mesa 1', 'patio', 'libre', 'mesa', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `local` int(15) NOT NULL,
  `imagen` varchar(2) NOT NULL,
  `imagen_nombre` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los usuarios y personas que tienen acceso';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `fecha`, `usuario`, `correo`, `contrasena`, `nombres`, `apellidos`, `tipo`, `local`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-06-25 14:13:49', 1, 'demo@demo.com', 'demo', 'pepito', 'perez', 'socio', 1, 'si', '20180615171909'),
(2, '2018-06-17 21:30:31', 1, 'juanito@demo.com', 'juanito', 'juanito', 'roa', 'mesero', 2, 'si', '20180615181739'),
(3, '2018-06-15 18:20:10', 1, 'maria@demo.com', 'maria', 'maria', 'mesa', 'administrador', 1, 'si', '20180615182010');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_permisos`
--

CREATE TABLE `usuarios_permisos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `id_usuario` int(15) NOT NULL,
  `ajustes` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ventas` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `zonas_entregas` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `base` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cierre` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `compras` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producciones` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inventario` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `gastos` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `clientes` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `reportes` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios_permisos`
--

INSERT INTO `usuarios_permisos` (`id`, `fecha`, `usuario`, `id_usuario`, `ajustes`, `ventas`, `zonas_entregas`, `base`, `cierre`, `compras`, `producciones`, `inventario`, `gastos`, `clientes`, `reportes`) VALUES
(1, '2018-08-18 13:15:06', 1, 1, 'si', 'si', 'si', 'si', 'si', 'si', 'si', 'si', 'si', 'si', 'si'),
(2, '2018-06-15 17:13:04', 1, 0, 'no', 'si', 'si', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no'),
(3, '2018-06-15 18:17:54', 1, 2, 'no', 'si', 'si', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no'),
(4, '2018-06-25 14:13:54', 1, 3, 'si', 'si', 'si', 'si', 'si', 'si', 'si', 'si', 'si', 'si', 'si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_datos`
--

CREATE TABLE `ventas_datos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `fecha_cierre` datetime NOT NULL,
  `usuario_id` int(15) NOT NULL,
  `local_id` int(15) NOT NULL,
  `ubicacion_id` int(15) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `cliente_id` int(15) NOT NULL,
  `tipo_pago_id` int(15) NOT NULL,
  `tipo_pago` varchar(255) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `total_bruto` varchar(15) NOT NULL,
  `descuento_id` int(15) NOT NULL,
  `descuento_porcentaje` varchar(15) NOT NULL,
  `descuento_valor` varchar(15) NOT NULL,
  `propina` int(15) NOT NULL,
  `total_neto` varchar(15) NOT NULL,
  `observaciones` text NOT NULL,
  `eliminar_motivo` text NOT NULL,
  `pago` varchar(15) NOT NULL,
  `fecha_pago` datetime NOT NULL,
  `saldo_pendiente` varchar(15) NOT NULL,
  `consecutivo` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ventas_datos`
--

INSERT INTO `ventas_datos` (`id`, `fecha`, `fecha_cierre`, `usuario_id`, `local_id`, `ubicacion_id`, `ubicacion`, `cliente_id`, `tipo_pago_id`, `tipo_pago`, `estado`, `total_bruto`, `descuento_id`, `descuento_porcentaje`, `descuento_valor`, `propina`, `total_neto`, `observaciones`, `eliminar_motivo`, `pago`, `fecha_pago`, `saldo_pendiente`, `consecutivo`) VALUES
(1, '2018-08-03 17:57:25', '0000-00-00 00:00:00', 1, 1, 1, 'mesa 1', 0, 1, 'efectivo', 'ocupado', '0', 0, '0', '0', 0, '0', '', '', 'contado', '2018-08-03 17:57:25', '0', 1),
(2, '2018-08-18 13:16:27', '0000-00-00 00:00:00', 1, 1, 2, 'mesa 2', 0, 1, 'efectivo', 'ocupado', '0', 0, '0', '0', 0, '0', '', '', 'contado', '2018-08-18 13:16:27', '0', 2),
(3, '2018-09-03 15:15:30', '0000-00-00 00:00:00', 1, 1, 3, 'mesa 3', 0, 1, 'efectivo', 'ocupado', '0', 99, '48.9', '0', 0, '0', '', '', 'contado', '2018-09-03 15:15:30', '0', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_productos`
--

CREATE TABLE `ventas_productos` (
  `id` int(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `venta_id` int(15) NOT NULL,
  `ubicacion_id` int(15) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `categoria_id` int(15) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `local` int(15) NOT NULL,
  `zona` int(15) NOT NULL,
  `producto_id` int(15) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `precio_final` int(15) NOT NULL,
  `porcentaje_impuesto` int(3) NOT NULL,
  `estado` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ventas_productos`
--

INSERT INTO `ventas_productos` (`id`, `fecha`, `usuario`, `venta_id`, `ubicacion_id`, `ubicacion`, `categoria_id`, `categoria`, `local`, `zona`, `producto_id`, `producto`, `precio_final`, `porcentaje_impuesto`, `estado`) VALUES
(1, '2018-08-03 17:57:28', 1, 1, 1, 'mesa 1', 1, 'bebidas', 1, 2, 2, 'agua', 2000, 19, 'pedido'),
(2, '2018-08-03 17:57:28', 1, 1, 1, 'mesa 1', 1, 'bebidas', 1, 2, 1, 'cerveza', 3000, 19, 'pedido'),
(3, '2018-08-18 13:16:40', 1, 2, 2, 'mesa 2', 1, 'bebidas', 1, 2, 2, 'agua', 2000, 19, 'confirmado'),
(4, '2018-08-18 13:16:40', 1, 2, 2, 'mesa 2', 1, 'bebidas', 1, 2, 1, 'cerveza', 3000, 19, 'confirmado'),
(5, '2018-08-18 13:16:40', 1, 2, 2, 'mesa 2', 1, 'bebidas', 1, 2, 2, 'agua', 2000, 19, 'confirmado'),
(6, '2018-08-18 13:16:40', 1, 2, 2, 'mesa 2', 1, 'bebidas', 1, 2, 1, 'cerveza', 3000, 19, 'confirmado'),
(7, '2018-08-18 13:16:40', 1, 2, 2, 'mesa 2', 1, 'bebidas', 1, 2, 2, 'agua', 2000, 19, 'confirmado'),
(8, '2018-08-18 13:16:40', 1, 2, 2, 'mesa 2', 1, 'bebidas', 1, 2, 1, 'cerveza', 3000, 19, 'confirmado'),
(9, '2018-09-03 15:15:33', 1, 3, 3, 'mesa 3', 1, 'bebidas', 1, 2, 2, 'agua', 2000, 19, 'pedido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas_entregas`
--

CREATE TABLE `zonas_entregas` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `zona` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los datos de las mesas, barras, puntos de venta...';

--
-- Volcado de datos para la tabla `zonas_entregas`
--

INSERT INTO `zonas_entregas` (`id`, `fecha`, `usuario`, `zona`) VALUES
(1, '2018-06-15 18:22:58', 1, 'cocina'),
(2, '2018-06-15 18:23:01', 1, 'bar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bases_datos`
--
ALTER TABLE `bases_datos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bases_denominaciones`
--
ALTER TABLE `bases_denominaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cierres_datos`
--
ALTER TABLE `cierres_datos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cierres_denominaciones`
--
ALTER TABLE `cierres_denominaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `componentes_producidos`
--
ALTER TABLE `componentes_producidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `composiciones_componentes_producidos`
--
ALTER TABLE `composiciones_componentes_producidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comprobantes_ingreso`
--
ALTER TABLE `comprobantes_ingreso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `denominaciones`
--
ALTER TABLE `denominaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `despachos`
--
ALTER TABLE `despachos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `despachos_componentes`
--
ALTER TABLE `despachos_componentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturas_plantillas`
--
ALTER TABLE `facturas_plantillas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario_novedades`
--
ALTER TABLE `inventario_novedades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producciones`
--
ALTER TABLE `producciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producciones_componentes`
--
ALTER TABLE `producciones_componentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos_categorias`
--
ALTER TABLE `productos_categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos_composiciones`
--
ALTER TABLE `productos_composiciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_pagos`
--
ALTER TABLE `tipos_pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_permisos`
--
ALTER TABLE `usuarios_permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas_datos`
--
ALTER TABLE `ventas_datos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas_productos`
--
ALTER TABLE `ventas_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zonas_entregas`
--
ALTER TABLE `zonas_entregas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bases_datos`
--
ALTER TABLE `bases_datos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bases_denominaciones`
--
ALTER TABLE `bases_denominaciones`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cierres_datos`
--
ALTER TABLE `cierres_datos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cierres_denominaciones`
--
ALTER TABLE `cierres_denominaciones`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `componentes`
--
ALTER TABLE `componentes`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `componentes_producidos`
--
ALTER TABLE `componentes_producidos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `composiciones_componentes_producidos`
--
ALTER TABLE `composiciones_componentes_producidos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comprobantes_ingreso`
--
ALTER TABLE `comprobantes_ingreso`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `denominaciones`
--
ALTER TABLE `denominaciones`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `despachos`
--
ALTER TABLE `despachos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `despachos_componentes`
--
ALTER TABLE `despachos_componentes`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `facturas_plantillas`
--
ALTER TABLE `facturas_plantillas`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario_novedades`
--
ALTER TABLE `inventario_novedades`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `locales`
--
ALTER TABLE `locales`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `producciones`
--
ALTER TABLE `producciones`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producciones_componentes`
--
ALTER TABLE `producciones_componentes`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos_categorias`
--
ALTER TABLE `productos_categorias`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos_composiciones`
--
ALTER TABLE `productos_composiciones`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipos_pagos`
--
ALTER TABLE `tipos_pagos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios_permisos`
--
ALTER TABLE `usuarios_permisos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas_datos`
--
ALTER TABLE `ventas_datos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas_productos`
--
ALTER TABLE `ventas_productos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `zonas_entregas`
--
ALTER TABLE `zonas_entregas`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
