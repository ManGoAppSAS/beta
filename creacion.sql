-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 21, 2016 at 03:11 PM
-- Server version: 5.5.48-37.8
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mangoapp_cliente_minegocioexitoso`
--

-- --------------------------------------------------------

--
-- Table structure for table `componentes`
--

CREATE TABLE IF NOT EXISTS `componentes` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `componente` varchar(255) NOT NULL,
  `precio_unidad` int(15) NOT NULL,
  `proveedor` int(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `composiciones`
--

CREATE TABLE IF NOT EXISTS `composiciones` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `producto` int(15) NOT NULL,
  `componente` int(15) NOT NULL,
  `cantidad` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `descuentos`
--

CREATE TABLE IF NOT EXISTS `descuentos` (
  `id` int(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `descuento` varchar(150) NOT NULL,
  `porcentaje` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `despachos`
--

CREATE TABLE IF NOT EXISTS `despachos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `origen` int(15) NOT NULL,
  `destino` int(15) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `despachos_componentes`
--

CREATE TABLE IF NOT EXISTS `despachos_componentes` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `despacho_id` int(15) NOT NULL,
  `componente_id` int(15) NOT NULL,
  `cantidad` int(15) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `facturas_plantillas`
--

CREATE TABLE IF NOT EXISTS `facturas_plantillas` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `texto_superior` text NOT NULL,
  `texto_inferior` text NOT NULL,
  `local` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los datos de las mesas, barras, puntos de venta...';

-- --------------------------------------------------------

--
-- Table structure for table `impuestos`
--

CREATE TABLE IF NOT EXISTS `impuestos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `impuesto` varchar(50) NOT NULL,
  `porcentaje` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los distintos tipos de impuestos';

-- --------------------------------------------------------

--
-- Table structure for table `inventario`
--

CREATE TABLE IF NOT EXISTS `inventario` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `componente_id` int(15) NOT NULL,
  `cantidad` varchar(15) NOT NULL,
  `local_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventario_novedades`
--

CREATE TABLE IF NOT EXISTS `inventario_novedades` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `componente` int(15) NOT NULL,
  `cantidad_anterior` int(15) NOT NULL,
  `cantidad_descontada` int(15) NOT NULL,
  `cantidad_nueva` int(15) NOT NULL,
  `motivo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los datos de las mesas, barras, puntos de venta...';

-- --------------------------------------------------------

--
-- Table structure for table `locales`
--

CREATE TABLE IF NOT EXISTS `locales` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `local` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `imagen` varchar(2) NOT NULL,
  `imagen_nombre` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Almacena los locales y puntos de venta';

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `categoria` int(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `local` int(255) NOT NULL,
  `zona` int(15) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `precio` int(255) NOT NULL,
  `impuesto` int(15) NOT NULL,
  `descripcion` text,
  `codigo_barras` varchar(100) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `imagen_nombre` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productos_categorias`
--

CREATE TABLE IF NOT EXISTS `productos_categorias` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `imagen` varchar(2) NOT NULL,
  `imagen_nombre` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Almacena las categorías en las que están divididas los produ';

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `proveedor` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `imagen` varchar(2) NOT NULL,
  `imagen_nombre` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipos_pagos`
--

CREATE TABLE IF NOT EXISTS `tipos_pagos` (
  `id` int(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `tipo_pago` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los diferentes tipos de pagos ';

-- --------------------------------------------------------

--
-- Table structure for table `ubicaciones`
--

CREATE TABLE IF NOT EXISTS `ubicaciones` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `ubicacion` varchar(50) NOT NULL,
  `ubicada` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `local` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los datos de las mesas, barras, puntos de venta...';

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Almacena los usuarios y personas que tienen acceso';

-- --------------------------------------------------------

--
-- Table structure for table `ventas_datos`
--

CREATE TABLE IF NOT EXISTS `ventas_datos` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario_id` int(15) NOT NULL,
  `local_id` int(15) NOT NULL,
  `ubicacion_id` int(15) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `tipo_pago` varchar(255) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `total_bruto` int(15) NOT NULL,
  `descuento_porcentaje` int(3) NOT NULL,
  `descuento_valor` int(15) NOT NULL,
  `total_neto` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ventas_productos`
--

CREATE TABLE IF NOT EXISTS `ventas_productos` (
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

-- --------------------------------------------------------

--
-- Table structure for table `zonas_entregas`
--

CREATE TABLE IF NOT EXISTS `zonas_entregas` (
  `id` int(15) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(15) NOT NULL,
  `zona` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Almacena los datos de las mesas, barras, puntos de venta...';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `componentes`
--
ALTER TABLE `componentes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `composiciones`
--
ALTER TABLE `composiciones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `despachos`
--
ALTER TABLE `despachos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `despachos_componentes`
--
ALTER TABLE `despachos_componentes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facturas_plantillas`
--
ALTER TABLE `facturas_plantillas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `impuestos`
--
ALTER TABLE `impuestos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventario_novedades`
--
ALTER TABLE `inventario_novedades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productos_categorias`
--
ALTER TABLE `productos_categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipos_pagos`
--
ALTER TABLE `tipos_pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ventas_datos`
--
ALTER TABLE `ventas_datos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ventas_productos`
--
ALTER TABLE `ventas_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zonas_entregas`
--
ALTER TABLE `zonas_entregas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `componentes`
--
ALTER TABLE `componentes`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `composiciones`
--
ALTER TABLE `composiciones`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `despachos`
--
ALTER TABLE `despachos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `despachos_componentes`
--
ALTER TABLE `despachos_componentes`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `facturas_plantillas`
--
ALTER TABLE `facturas_plantillas`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `impuestos`
--
ALTER TABLE `impuestos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inventario_novedades`
--
ALTER TABLE `inventario_novedades`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `locales`
--
ALTER TABLE `locales`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `productos_categorias`
--
ALTER TABLE `productos_categorias`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tipos_pagos`
--
ALTER TABLE `tipos_pagos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ventas_datos`
--
ALTER TABLE `ventas_datos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ventas_productos`
--
ALTER TABLE `ventas_productos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `zonas_entregas`
--
ALTER TABLE `zonas_entregas`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

TRUNCATE `componentes`;
TRUNCATE `composiciones`;
TRUNCATE `descuentos`;
TRUNCATE `despachos`;
TRUNCATE `despachos_componentes`;
TRUNCATE `facturas_plantillas`;
TRUNCATE `impuestos`;
TRUNCATE `inventario`;
TRUNCATE `inventario_novedades`;
TRUNCATE `locales`;
TRUNCATE `productos`;
TRUNCATE `productos_categorias`;
TRUNCATE `proveedores`;
TRUNCATE `tipos_pagos`;
TRUNCATE `ubicaciones`;
TRUNCATE `usuarios`;
TRUNCATE `ventas_datos`;
TRUNCATE `ventas_productos`;
TRUNCATE `zonas_entregas`;