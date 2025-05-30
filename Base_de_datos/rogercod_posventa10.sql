-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 24-01-2024 a las 22:20:34
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rogercod_posventa10`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aperturacajas`
--

CREATE TABLE `aperturacajas` (
  `idapertura` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad_inicial` decimal(11,2) NOT NULL,
  `cantidad_final` decimal(11,2) NOT NULL,
  `estatus` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `fecha_hora_cierre` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capturarinventario`
--

CREATE TABLE `capturarinventario` (
  `idcaptura` bigint(20) UNSIGNED NOT NULL,
  `articulo_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` decimal(11,3) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_cotizacion_temp`
--

CREATE TABLE `carrito_cotizacion_temp` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cod` varchar(30) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `descipcion` varchar(250) DEFAULT NULL,
  `precio` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idcategoria` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  `descripcion` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idcliente` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(300) CHARACTER SET utf8mb4 NOT NULL,
  `direccion` varchar(300) CHARACTER SET utf8mb4 NOT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(300) CHARACTER SET utf8mb4 NOT NULL,
  `estatus` varchar(50) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `image` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `adress` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `name`, `image`, `adress`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Bodega Félix', 'descarga (1).png', 'barrero', 'barrero@gmail.com', '7937937957', '2023-02-18 21:19:32', '2024-01-02 09:11:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corte_cajero_dia`
--

CREATE TABLE `corte_cajero_dia` (
  `idcortecaja` bigint(20) UNSIGNED NOT NULL,
  `apertura_id` bigint(20) UNSIGNED NOT NULL,
  `total_acomulado` decimal(11,2) NOT NULL,
  `seriefolio` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `numfolio` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` bigint(20) UNSIGNED NOT NULL,
  `serie` varchar(255) NOT NULL,
  `factura` varchar(20) DEFAULT NULL,
  `tipo_pago` varchar(100) DEFAULT NULL,
  `validez` varchar(20) DEFAULT NULL,
  `total` decimal(11,2) NOT NULL,
  `abono` decimal(11,2) DEFAULT NULL,
  `servicio` text,
  `numero_cotizacion_manual` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cotizacion`
--

CREATE TABLE `detalle_cotizacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_cotizacion` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `item` decimal(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_devolucion_ventas`
--

CREATE TABLE `detalle_devolucion_ventas` (
  `iddetalledevolucion` bigint(20) UNSIGNED NOT NULL,
  `devolucion_id` bigint(20) UNSIGNED NOT NULL,
  `articulo_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `cantidad` decimal(11,3) NOT NULL,
  `pventa` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL,
  `subtotal` decimal(11,2) NOT NULL,
  `motivo` varchar(500) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Disparadores `detalle_devolucion_ventas`
--
DELIMITER $$
CREATE TRIGGER `trigger_deleteProductoOnDetalleVentas` AFTER INSERT ON `detalle_devolucion_ventas` FOR EACH ROW BEGIN
IF NEW.motivo = "Devolucion a stock" THEN
SET @idventa = (select dv.venta_id from devolucion_ventas as dv inner join detalle_devolucion_ventas as ddv
where dv.iddevolucion=NEW.devolucion_id AND ddv.devolucion_id=NEW.devolucion_id group by dv.venta_id);
DELETE FROM detalle_ventas WHERE detalle_ventas.venta_id=@idventa AND detalle_ventas.articulo_id=NEW.articulo_id;
UPDATE ventas AS vent SET vent.total_venta=vent.total_venta-NEW.subtotal WHERE vent.idventa=@idventa;
UPDATE productos AS p SET p.stock=p.stock+NEW.cantidad
WHERE p.idarticulo=NEW.articulo_id; 
ELSE
SET @idventa = (select dv.venta_id from devolucion_ventas as dv inner join detalle_devolucion_ventas as ddv
where dv.iddevolucion=NEW.devolucion_id AND ddv.devolucion_id=NEW.devolucion_id group by dv.venta_id);
DELETE FROM detalle_ventas WHERE detalle_ventas.venta_id=@idventa AND detalle_ventas.articulo_id=NEW.articulo_id;
UPDATE ventas AS vent SET vent.total_venta=vent.total_venta-NEW.subtotal WHERE vent.idventa=@idventa;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_entrada_temp`
--

CREATE TABLE `detalle_entrada_temp` (
  `identradatemp` bigint(20) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `codigo` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `nombre` varchar(1000) CHARACTER SET utf8mb4 NOT NULL,
  `cantidad` decimal(11,3) NOT NULL,
  `pcompra` decimal(11,2) NOT NULL,
  `pventa` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingresos`
--

CREATE TABLE `detalle_ingresos` (
  `iddetalle_ingreso` bigint(20) UNSIGNED NOT NULL,
  `ingreso_id` bigint(20) UNSIGNED NOT NULL,
  `articulo_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` decimal(11,3) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `subtotal` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Disparadores `detalle_ingresos`
--
DELIMITER $$
CREATE TRIGGER `trigger_updateStockProducto` AFTER INSERT ON `detalle_ingresos` FOR EACH ROW UPDATE productos SET stock=stock + NEW.cantidad, pcompra=NEW.precio_compra, pventa=NEW.precio_venta 
WHERE productos.idarticulo = NEW.articulo_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `iddetalle_venta` bigint(20) UNSIGNED NOT NULL,
  `venta_id` bigint(20) UNSIGNED NOT NULL,
  `articulo_id` bigint(20) UNSIGNED NOT NULL,
  `apertura_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` decimal(11,3) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL,
  `subtotal` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Disparadores `detalle_ventas`
--
DELIMITER $$
CREATE TRIGGER `trigger_updateStockVenta` AFTER INSERT ON `detalle_ventas` FOR EACH ROW BEGIN
UPDATE productos SET stock=stock-NEW.cantidad
WHERE productos.idarticulo=NEW.articulo_id;
UPDATE corte_cajero_dia SET total_acomulado=total_acomulado+NEW.subtotal WHERE corte_cajero_dia.apertura_id=NEW.apertura_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta_temp`
--

CREATE TABLE `detalle_venta_temp` (
  `iddetalletemp` bigint(20) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `codproducto` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `nombre` varchar(1000) CHARACTER SET utf8mb4 NOT NULL,
  `cantidad` decimal(11,3) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL,
  `iva` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion_ventas`
--

CREATE TABLE `devolucion_ventas` (
  `iddevolucion` bigint(20) UNSIGNED NOT NULL,
  `venta_id` bigint(20) UNSIGNED NOT NULL,
  `observacion` varchar(1000) CHARACTER SET utf8mb4 NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text CHARACTER SET utf8mb4 NOT NULL,
  `queue` text CHARACTER SET utf8mb4 NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `idingreso` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `proveedor_id` bigint(20) UNSIGNED NOT NULL,
  `folio_comprobante` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `total_ingreso` decimal(11,2) NOT NULL,
  `estado` varchar(20) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `idinventario` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estatus` varchar(20) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `numero_corte_por_cajero`
--

CREATE TABLE `numero_corte_por_cajero` (
  `idnumerocorte` bigint(20) UNSIGNED NOT NULL,
  `cortecaja_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Disparadores `numero_corte_por_cajero`
--
DELIMITER $$
CREATE TRIGGER `trigger_updatecantidadacomulado` AFTER INSERT ON `numero_corte_por_cajero` FOR EACH ROW BEGIN
	UPDATE corte_cajero_dia SET total_acomulado=total_acomulado-NEW.cantidad
	WHERE corte_cajero_dia.idcortecaja=NEW.cortecaja_id;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `token` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `description` text CHARACTER SET utf8mb4,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'listar el menu principal', 'admin.index', 'un administrador puede ver menu', '2020-10-18 03:47:42', '2020-10-18 03:47:42'),
(2, 'listar el menu de almacen', 'almacen.index', 'Un usuario puede ver menu de alamcen', '2020-10-18 03:47:42', '2020-10-18 03:47:42'),
(3, 'listar el menu de compras', 'compras.index', 'Un usuario puede ver menu de compras', '2020-10-18 03:47:42', '2020-10-18 03:47:42'),
(4, 'listar el menu de ventas', 'ventas.index', 'Un usuario puede ver menu de ventas', '2020-10-18 03:47:42', '2020-10-18 03:47:42'),
(5, 'listar el menu de caja', 'caja.index', 'Un usuario puede ver el menu de caja', NULL, NULL),
(6, 'listar el menu de devoluciones', 'devolucion.index', 'Un usuario puede ver el menu de devoluciones', NULL, NULL),
(7, 'listar el menu de inventario', 'inventario.index', 'Un usuario puede ver el menu de inventario', NULL, NULL),
(8, 'listar la seccion de roles', 'admin_role.index', 'Un usuario puede ver la seccion de roles', NULL, NULL),
(9, 'listarla seccion de usuarios', 'admin_user.index', 'Un usuario puede ver la seccion de usuarios', NULL, NULL),
(10, 'listar la seccion de apertura de caja', 'caja_apertura.index', 'Un usuario puede aperturar una caja para vender', NULL, NULL),
(11, 'listar la seccion de corte de caja', 'caja_corte.index', 'Un usuario puede realizar el corte de caja', NULL, NULL),
(12, 'listar la seccion de corte parcial de caja', 'caja_parcial.index', 'Un usuario puede realizar el corte de caja parcial', NULL, NULL),
(13, 'listar la seccion de articulos', 'almacen_articulo.index', 'Un usuario puede realizar la alta de productos', NULL, NULL),
(14, 'listar la seccion de categorias', 'almacen_categoria.index', 'Un usuario puede realizar la alta de categorias', NULL, NULL),
(15, 'listar la seccion de entrada de mercancia', 'compras_entrada.index', 'Un usuario puede realizar la entrada de productos', NULL, NULL),
(16, 'listar la seccion de proveedores', 'compras_proveedor.index', 'Un usuario puede realizar el registro de un proveedor', NULL, NULL),
(17, 'listar la seccion de ventas', 'ventas_venta.index', 'Un usuario puede realizar las ventas', NULL, NULL),
(18, 'listar la seccion de clientes', 'ventas_cliente.index', 'Un usuario puede realizar el registro de los clientes', NULL, NULL),
(19, 'listar la seccion de devoluciones', 'devolucion_producto.index', 'Un usuario puede realizar la devolucion de productos', NULL, NULL),
(20, 'listar el menu de reportes', 'reporte.index', 'Un usuario puede ver el menu de reportes', NULL, NULL),
(21, 'listar el menu de configuracion', 'configuracion.index', 'Un usuario puede ver el modulo de configuracion', NULL, NULL),
(22, 'Listar la seccion de inventario', 'almacen_inventario.index', 'Un usuario puede ver el módulo de inventario', NULL, NULL),
(23, 'listar la seccion de historico de cajas', 'caja_historicolist.index', 'Un usuario puede vel la seccion de historico de cajas', '2023-02-27 05:42:50', '2023-02-27 05:42:50'),
(24, 'Listar la seccion de cotizacion', 'cotizaciones.index', 'Un usuario puede ver el menu de cotizaciones', NULL, NULL),
(25, 'Crear una cotizacion', 'cotizaciones_cliente.index', 'Un usuario puede crear una cotizacion', NULL, NULL),
(26, 'Listar las cotizaciones', 'cotizaciones_cotizacion.index', 'Un usuario puede ver las cotizaciones', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idarticulo` bigint(20) UNSIGNED NOT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  `stock` double(11,3) NOT NULL,
  `pcompra` decimal(11,2) NOT NULL,
  `pventa` decimal(11,2) NOT NULL,
  `descripcion` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `imagen` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  `estado` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `descuento` decimal(11,2) NOT NULL,
  `iva` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idproveedor` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(300) CHARACTER SET utf8mb4 NOT NULL,
  `direccion` varchar(300) CHARACTER SET utf8mb4 NOT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(300) CHARACTER SET utf8mb4 NOT NULL,
  `estado` varchar(50) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `description` text CHARACTER SET utf8mb4,
  `full-access` enum('yes','no') CHARACTER SET utf8mb4 DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `full-access`, `estatus`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'Administrador', 'yes', 1, '2023-02-18 21:25:32', '2023-02-18 21:25:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-02-18 21:26:57', '2023-02-18 21:26:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `estatus`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$XF4As8Nz9lr3UCBjo3YxKOpe4dHSqK4DrwPPqjA5JJwrfZXRe.p0.', 1, 'HtRa4hsHB4zkmCi1LsdBS1CwetAA8aEf7Imr4HUpOqw35nxM5LqcTbLBf2rr', '2023-02-18 21:00:57', '2023-09-15 10:23:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idventa` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_comprobante` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `num_folio` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `efectivo` decimal(11,2) NOT NULL,
  `total_venta` decimal(11,2) NOT NULL,
  `estado` varchar(20) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aperturacajas`
--
ALTER TABLE `aperturacajas`
  ADD PRIMARY KEY (`idapertura`),
  ADD KEY `aperturacajas_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `capturarinventario`
--
ALTER TABLE `capturarinventario`
  ADD PRIMARY KEY (`idcaptura`),
  ADD KEY `capturarinventario_articulo_id_foreign` (`articulo_id`);

--
-- Indices de la tabla `carrito_cotizacion_temp`
--
ALTER TABLE `carrito_cotizacion_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `corte_cajero_dia`
--
ALTER TABLE `corte_cajero_dia`
  ADD PRIMARY KEY (`idcortecaja`),
  ADD KEY `corte_cajero_dia_apertura_id_foreign` (`apertura_id`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `detalle_cotizacion`
--
ALTER TABLE `detalle_cotizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cotizacion` (`id_cotizacion`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_devolucion_ventas`
--
ALTER TABLE `detalle_devolucion_ventas`
  ADD PRIMARY KEY (`iddetalledevolucion`),
  ADD KEY `detalle_devolucion_ventas_devolucion_id_foreign` (`devolucion_id`),
  ADD KEY `detalle_devolucion_ventas_articulo_id_foreign` (`articulo_id`);

--
-- Indices de la tabla `detalle_entrada_temp`
--
ALTER TABLE `detalle_entrada_temp`
  ADD PRIMARY KEY (`identradatemp`);

--
-- Indices de la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  ADD PRIMARY KEY (`iddetalle_ingreso`),
  ADD KEY `detalle_ingresos_ingreso_id_foreign` (`ingreso_id`),
  ADD KEY `detalle_ingresos_articulo_id_foreign` (`articulo_id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `detalle_ventas_venta_id_foreign` (`venta_id`),
  ADD KEY `detalle_ventas_articulo_id_foreign` (`articulo_id`),
  ADD KEY `detalle_ventas_apertura_id_foreign` (`apertura_id`);

--
-- Indices de la tabla `detalle_venta_temp`
--
ALTER TABLE `detalle_venta_temp`
  ADD PRIMARY KEY (`iddetalletemp`);

--
-- Indices de la tabla `devolucion_ventas`
--
ALTER TABLE `devolucion_ventas`
  ADD PRIMARY KEY (`iddevolucion`),
  ADD KEY `devolucion_ventas_venta_id_foreign` (`venta_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `ingresos_user_id_foreign` (`user_id`),
  ADD KEY `ingresos_proveedor_id_foreign` (`proveedor_id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`idinventario`),
  ADD KEY `inventario_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `numero_corte_por_cajero`
--
ALTER TABLE `numero_corte_por_cajero`
  ADD PRIMARY KEY (`idnumerocorte`),
  ADD KEY `numero_corte_por_cajero_cortecaja_id_foreign` (`cortecaja_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indices de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idarticulo`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idproveedor`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indices de la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `ventas_user_id_foreign` (`user_id`),
  ADD KEY `ventas_cliente_id_foreign` (`cliente_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aperturacajas`
--
ALTER TABLE `aperturacajas`
  MODIFY `idapertura` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `capturarinventario`
--
ALTER TABLE `capturarinventario`
  MODIFY `idcaptura` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carrito_cotizacion_temp`
--
ALTER TABLE `carrito_cotizacion_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idcategoria` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idcliente` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `corte_cajero_dia`
--
ALTER TABLE `corte_cajero_dia`
  MODIFY `idcortecaja` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_cotizacion`
--
ALTER TABLE `detalle_cotizacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_devolucion_ventas`
--
ALTER TABLE `detalle_devolucion_ventas`
  MODIFY `iddetalledevolucion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_entrada_temp`
--
ALTER TABLE `detalle_entrada_temp`
  MODIFY `identradatemp` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  MODIFY `iddetalle_ingreso` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `iddetalle_venta` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_venta_temp`
--
ALTER TABLE `detalle_venta_temp`
  MODIFY `iddetalletemp` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `devolucion_ventas`
--
ALTER TABLE `devolucion_ventas`
  MODIFY `iddevolucion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `idingreso` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `idinventario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `numero_corte_por_cajero`
--
ALTER TABLE `numero_corte_por_cajero`
  MODIFY `idnumerocorte` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idarticulo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idproveedor` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idventa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aperturacajas`
--
ALTER TABLE `aperturacajas`
  ADD CONSTRAINT `aperturacajas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `capturarinventario`
--
ALTER TABLE `capturarinventario`
  ADD CONSTRAINT `capturarinventario_articulo_id_foreign` FOREIGN KEY (`articulo_id`) REFERENCES `productos` (`idarticulo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `corte_cajero_dia`
--
ALTER TABLE `corte_cajero_dia`
  ADD CONSTRAINT `corte_cajero_dia_apertura_id_foreign` FOREIGN KEY (`apertura_id`) REFERENCES `aperturacajas` (`idapertura`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `cotizaciones_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotizaciones_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_cotizacion`
--
ALTER TABLE `detalle_cotizacion`
  ADD CONSTRAINT `detalles_cotizacion_ibfk_1` FOREIGN KEY (`id_cotizacion`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalles_cotizacion_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`idarticulo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_devolucion_ventas`
--
ALTER TABLE `detalle_devolucion_ventas`
  ADD CONSTRAINT `detalle_devolucion_ventas_articulo_id_foreign` FOREIGN KEY (`articulo_id`) REFERENCES `productos` (`idarticulo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_devolucion_ventas_devolucion_id_foreign` FOREIGN KEY (`devolucion_id`) REFERENCES `devolucion_ventas` (`iddevolucion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  ADD CONSTRAINT `detalle_ingresos_articulo_id_foreign` FOREIGN KEY (`articulo_id`) REFERENCES `productos` (`idarticulo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_ingresos_ingreso_id_foreign` FOREIGN KEY (`ingreso_id`) REFERENCES `ingresos` (`idingreso`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_apertura_id_foreign` FOREIGN KEY (`apertura_id`) REFERENCES `aperturacajas` (`idapertura`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_ventas_articulo_id_foreign` FOREIGN KEY (`articulo_id`) REFERENCES `productos` (`idarticulo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`idventa`) ON DELETE CASCADE;

--
-- Filtros para la tabla `devolucion_ventas`
--
ALTER TABLE `devolucion_ventas`
  ADD CONSTRAINT `devolucion_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`idventa`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD CONSTRAINT `ingresos_proveedor_id_foreign` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`idproveedor`) ON DELETE CASCADE,
  ADD CONSTRAINT `ingresos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `numero_corte_por_cajero`
--
ALTER TABLE `numero_corte_por_cajero`
  ADD CONSTRAINT `numero_corte_por_cajero_cortecaja_id_foreign` FOREIGN KEY (`cortecaja_id`) REFERENCES `corte_cajero_dia` (`idcortecaja`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`idcategoria`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
