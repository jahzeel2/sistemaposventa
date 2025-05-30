<?php

namespace App\Models\cotizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    protected $table = 'cotizaciones';
    protected $fillable = [ 
        'id_user', // not null
        'id_cliente', // not null
        'serie', // not null
        'factura', // default null
        'tipo_pago', // default null
        'validez', // default null
        'total', // not null
        'abono', // default null
        'servicio', // default null
        'numero_cotizacion_manual', //is null
        'estado', //not null
    ];
    public $timestamps = true;
    protected $guarded = ['id'];
}
/*
  CREATE TABLE `cotizaciones` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` BIGINT(20) UNSIGNED NOT NULL,
  `id_cliente` BIGINT(20) UNSIGNED NOT NULL,
  `serie` INT(11) NOT NULL,
  `factura` VARCHAR(20) DEFAULT NULL,
  `tipo_pago` VARCHAR(100) DEFAULT NULL,
  `validez` VARCHAR(20) DEFAULT NULL,
  `total` INT(11) NOT NULL,
  `abono` DECIMAL(11,2) DEFAULT NULL,
  `servicio` TEXT DEFAULT NULL,
  `numero_cotizacion_manual` VARCHAR(255) DEFAULT NULL,
  `estado` TINYINT(1) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `cotizaciones_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cotizaciones_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;
*/

/******************************************* */
/*
CREATE TABLE `detalles_cotizacion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_cotizacion` bigint(20) unsigned NOT NULL,
  `id_producto` bigint(20) unsigned NOT NULL,
  `precio_venta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descuento` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cotizacion` (`id_cotizacion`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `detalles_cotizacion_ibfk_1` FOREIGN KEY (`id_cotizacion`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detalles_cotizacion_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4*/