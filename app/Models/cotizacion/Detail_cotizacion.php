<?php

namespace App\Models\cotizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_cotizacion extends Model
{
    use HasFactory;

    protected $table = 'detalle_cotizacion';
    protected $fillable = [ 
        'id_cotizacion', // not null
        'id_producto', //not null
        'precio_venta',// not null
        'cantidad', //not null
        'descuento', //not null
        'total', //not null
        'item',//not null
    ];
}
/*
CREATE TABLE `detalle_cotizacion` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cotizacion` BIGINT(20) UNSIGNED NOT NULL,
  `id_producto` BIGINT(20) UNSIGNED NOT NULL,
  `precio_venta` INT(11) NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `descuento` INT(11) NOT NULL,
  `total` INT(11) NOT NULL,
  `item` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cotizacion` (`id_cotizacion`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `detalles_cotizacion_ibfk_1` FOREIGN KEY (`id_cotizacion`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detalles_cotizacion_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`idarticulo`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;
*/