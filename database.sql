-- =======================================================
-- Base de Datos: suministrossa
-- Sistema de Gestión: Suministros S.A.
-- Compatible con: XAMPP (MySQL / MariaDB en puerto 3306 / 3307)
-- =======================================================

CREATE DATABASE IF NOT EXISTS `suministrossa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `suministrossa`;

-- --------------------------------------------------------
-- 1. Tabla: usuarios
-- --------------------------------------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `rol`) VALUES
(1, 'admin', 'admin', 'admin'),
(2, 'vendedor', '1234', 'usuario');

-- --------------------------------------------------------
-- 2. Tabla: categorias
-- --------------------------------------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Tecnología y Electrónica'),
(2, 'Papelería y Oficina'),
(3, 'Ferretería y Herramientas'),
(4, 'Seguridad Industrial'),
(5, 'Limpieza y Desinfección');

-- --------------------------------------------------------
-- 3. Tabla: unidades_medida
-- --------------------------------------------------------
DROP TABLE IF EXISTS `unidades_medida`;
CREATE TABLE `unidades_medida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `unidad` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `unidades_medida` (`id`, `nombre`, `unidad`) VALUES
(1, 'Unidad', 'UND'),
(2, 'Caja', 'CJ'),
(3, 'Paquete', 'PAQ'),
(4, 'Docena', 'DOC'),
(5, 'Galón', 'GAL'),
(6, 'Metro', 'M');

-- --------------------------------------------------------
-- 4. Tabla: clientes
-- --------------------------------------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rnc` varchar(50) DEFAULT NULL,
  `direccion_facturacion` text DEFAULT NULL,
  `direccion_envio` text DEFAULT NULL,
  `tipo_cliente` varchar(50) NOT NULL DEFAULT 'Minorista',
  `condiciones_pago` varchar(50) DEFAULT 'Contado',
  `estado` varchar(20) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `contacto`, `telefono`, `email`, `rnc`, `direccion_facturacion`, `direccion_envio`, `tipo_cliente`, `condiciones_pago`, `estado`) VALUES
(1, 'Juan', 'Pérez', 'Juan Pérez', '809-555-0101', 'juan.perez@email.com', '101-23456-7', 'Av. 27 de Febrero #45, Sto Dgo', 'Av. 27 de Febrero #45, Sto Dgo', 'Minorista', 'Contado', 'Activo'),
(2, 'Constructora', 'Nacional S.R.L.', 'Ing. Carlos Gómez', '809-555-0202', 'compras@construnacional.com', '130-98765-4', 'Av. Winston Churchill #102, Piantini', 'Parque Industrial Duarte Nave 4', 'Corporativo', 'Crédito', 'Activo'),
(3, 'Comercial', 'La Gran Manzana', 'Lic. María Santos', '809-555-0303', 'gerencia@lagranmanzana.do', '102-34567-8', 'Calle El Conde #501, Zona Colonial', 'Calle El Conde #501, Zona Colonial', 'Mayorista', 'Pagos Parciales', 'Activo');

-- --------------------------------------------------------
-- 5. Tabla: proveedores
-- --------------------------------------------------------
DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(150) NOT NULL,
  `contacto` varchar(100) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `tiempo_entrega` int(11) NOT NULL DEFAULT 3,
  `condiciones_pago` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `proveedores` (`id`, `nombre_empresa`, `contacto`, `telefono`, `correo`, `direccion`, `tiempo_entrega`, `condiciones_pago`, `estado`) VALUES
(1, 'Distribuidora Global S.A.', 'Marcos Peña', '809-555-1111', 'ventas@distribuidoraglobal.com', 'Av. San Martín #88, Sto Dgo', 2, 'Contado', 'Activo'),
(2, 'Importaciones y Suministros Quisqueya', 'Laura Fernández', '809-555-2222', 'contacto@suministrosquisqueya.com', 'Autopista Duarte Km 9, Sto Dgo', 5, '30 días crédito', 'Activo'),
(3, 'Equipos & Soluciones Industriales', 'Roberto Díaz', '809-555-3333', 'roberto@equiposindustriales.do', 'Av. Luperón #300, Herrera', 3, '15 días crédito', 'Activo');

-- --------------------------------------------------------
-- 6. Tabla: productos
-- --------------------------------------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `costo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock_actual` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `unidad_medida` varchar(50) DEFAULT 'Unidad',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `categoria`, `sku`, `precio`, `costo`, `stock_actual`, `stock_minimo`, `unidad_medida`) VALUES
(1, 'Laptop HP ProBook 450 G9', 'Intel Core i5, 16GB RAM, 512GB SSD 15.6 pulgadas', 'Tecnología y Electrónica', 'TECH-HP-450', 54500.00, 42000.00, 12, 3, 'Unidad'),
(2, 'Mouse Inalámbrico Logitech M170', 'Conectividad inalámbrica 2.4GHz, color negro', 'Tecnología y Electrónica', 'TECH-LOG-M170', 850.00, 450.00, 45, 10, 'Unidad'),
(3, 'Resma de Papel Bond Carta 20lb', 'Caja de 10 resmas de papel bond 500 hojas c/u', 'Papelería y Oficina', 'PAP-BOND-LTR', 2450.00, 1800.00, 20, 5, 'Caja'),
(4, 'Casco de Seguridad Industrial Tipo 1', 'Casco con suspensión de 4 puntos color blanco norma ANSI', 'Seguridad Industrial', 'SEG-CASCO-BL', 450.00, 260.00, 3, 10, 'Unidad'),
(5, 'Guantes de Nitrilo Antideslizantes', 'Par de guantes de trabajo resistente a químicos y abrasión', 'Seguridad Industrial', 'SEG-GUANT-NIT', 150.00, 75.00, 120, 25, 'Docena'),
(6, 'Taladro Percutor 1/2 pulg 650W', 'Taladro profesional con velocidad variable y reversa', 'Ferretería y Herramientas', 'FERR-TAL-650', 3800.00, 2600.00, 8, 4, 'Unidad'),
(7, 'Desinfectante Multiusos Galón', 'Desinfectante con fragancia a lavanda concentrado 1 galón', 'Limpieza y Desinfección', 'LIMP-DES-GAL', 350.00, 180.00, 2, 8, 'Galón');

-- --------------------------------------------------------
-- 7. Tabla: inventario
-- --------------------------------------------------------
DROP TABLE IF EXISTS `inventario`;
CREATE TABLE `inventario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `stock_maximo` int(11) NOT NULL DEFAULT 100,
  `unidad_medida` varchar(50) DEFAULT '1',
  `costo_unitario` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estado` varchar(50) NOT NULL DEFAULT 'disponible',
  `lote` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_inv_producto` (`id_producto`),
  CONSTRAINT `fk_inv_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `inventario` (`id`, `id_producto`, `ubicacion`, `cantidad`, `stock_minimo`, `stock_maximo`, `unidad_medida`, `costo_unitario`, `estado`, `lote`) VALUES
(1, 1, 'Almacén Principal - Estante A1', 12, 3, 30, '1', 42000.00, 'disponible', 'LOT-HP-2026-01'),
(2, 2, 'Almacén Principal - Estante A2', 45, 10, 100, '1', 450.00, 'disponible', 'LOT-LOG-2026-02'),
(3, 3, 'Almacén Papelería - Pasillo 1', 20, 5, 50, '2', 1800.00, 'disponible', 'LOT-PAP-2026-01'),
(4, 4, 'Almacén Seguridad - Estante S3', 3, 10, 60, '1', 260.00, 'disponible', 'LOT-CAS-2025-09'),
(5, 5, 'Almacén Seguridad - Estante S4', 120, 25, 200, '4', 75.00, 'disponible', 'LOT-GUA-2026-03'),
(6, 6, 'Almacén Ferretería - Gaveta F1', 8, 4, 25, '1', 2600.00, 'disponible', 'LOT-FER-2026-01'),
(7, 7, 'Almacén Limpieza - Pasillo L', 2, 8, 40, '5', 180.00, 'disponible', 'LOT-DES-2026-02');

-- --------------------------------------------------------
-- 8. Tabla: ProductosProveedor
-- --------------------------------------------------------
DROP TABLE IF EXISTS `ProductosProveedor`;
CREATE TABLE `ProductosProveedor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad_disponible` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_pp_prov` (`proveedor_id`),
  KEY `fk_pp_prod` (`producto_id`),
  CONSTRAINT `fk_pp_prov` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pp_prod` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ProductosProveedor` (`id`, `proveedor_id`, `producto_id`, `cantidad_disponible`) VALUES
(1, 1, 1, 50),
(2, 1, 2, 200),
(3, 2, 3, 150),
(4, 2, 7, 80),
(5, 3, 4, 100),
(6, 3, 5, 500),
(7, 3, 6, 40);

-- --------------------------------------------------------
-- 9. Tabla: metodos_pago
-- --------------------------------------------------------
DROP TABLE IF EXISTS `metodos_pago`;
CREATE TABLE `metodos_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metodo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `metodos_pago` (`id`, `metodo`) VALUES
(1, 'Efectivo'),
(2, 'Transferencia Bancaria'),
(3, 'Tarjeta de Crédito'),
(4, 'Cheque');

-- --------------------------------------------------------
-- 10. Tabla: compras
-- --------------------------------------------------------
DROP TABLE IF EXISTS `compras`;
CREATE TABLE `compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) NOT NULL,
  `fecha_compra` date NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `monto_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `metodo_pago` varchar(50) NOT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'Pendiente',
  `estado_compra` varchar(50) NOT NULL DEFAULT 'Pendiente',
  PRIMARY KEY (`id`),
  KEY `fk_compras_prov` (`id_proveedor`),
  CONSTRAINT `fk_compras_prov` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `compras` (`id`, `id_proveedor`, `fecha_compra`, `numero_factura`, `monto_total`, `metodo_pago`, `fecha_entrega`, `estado`, `estado_compra`) VALUES
(1, 1, '2026-08-10', 'FACT-GLOB-1049', 84000.00, 'Transferencia', '2026-08-12', 'Aprobado', 'Entregada'),
(2, 2, '2026-08-15', 'FAC-QUIS-8821', 18000.00, 'Crédito', '2026-08-20', 'Aprobado', 'En Transito'),
(3, 3, '2026-08-17', 'FACT-IND-3392', 15600.00, 'Efectivo', '2026-08-22', 'Pendiente', 'Pendiente');

-- --------------------------------------------------------
-- 11. Tabla: detalles_compras
-- --------------------------------------------------------
DROP TABLE IF EXISTS `detalles_compras`;
CREATE TABLE `detalles_compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_det_compra` (`id_compra`),
  KEY `fk_det_prod` (`id_producto`),
  CONSTRAINT `fk_det_compra` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_det_prod` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `detalles_compras` (`id`, `id_compra`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 1, 2, 42000.00),
(2, 2, 3, 10, 1800.00),
(3, 3, 6, 6, 2600.00);

-- --------------------------------------------------------
-- 12. Tabla: ventas
-- --------------------------------------------------------
DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `fecha` datetime NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'completada',
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `descuento` decimal(12,2) NOT NULL DEFAULT 0.00,
  `impuesto` decimal(12,2) NOT NULL DEFAULT 0.00,
  `pago_recibido` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cambio` decimal(12,2) NOT NULL DEFAULT 0.00,
  `id_metodo_pago` int(11) NOT NULL DEFAULT 1,
  `observacion` text DEFAULT NULL,
  `id_usuario` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `fk_ventas_cli` (`id_cliente`),
  KEY `fk_ventas_usr` (`id_usuario`),
  KEY `fk_ventas_mp` (`id_metodo_pago`),
  CONSTRAINT `fk_ventas_cli` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  CONSTRAINT `fk_ventas_usr` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `fk_ventas_mp` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodos_pago` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ventas` (`id`, `id_cliente`, `total`, `fecha`, `estado`, `subtotal`, `descuento`, `impuesto`, `pago_recibido`, `cambio`, `id_metodo_pago`, `observacion`, `id_usuario`) VALUES
(1, 1, 952.85, '2026-08-16 10:30:00', 'completada', 850.00, 42.50, 145.35, 1000.00, 47.15, 1, 'Cliente frecuente - Venta mostrador', 1),
(2, 2, 61094.50, '2026-08-17 14:15:00', 'completada', 54500.00, 2725.00, 9319.50, 61094.50, 0.00, 2, 'Orden de compra #CONSTR-991', 1);

-- --------------------------------------------------------
-- 13. Tabla: ventas_detalles
-- --------------------------------------------------------
DROP TABLE IF EXISTS `ventas_detalles`;
CREATE TABLE `ventas_detalles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vd_venta` (`id_venta`),
  KEY `fk_vd_prod` (`id_producto`),
  CONSTRAINT `fk_vd_venta` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_vd_prod` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ventas_detalles` (`id`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(1, 1, 2, 1, 850.00, 850.00),
(2, 2, 1, 1, 54500.00, 54500.00);
