----------- PROCEDURES --------

DELIMITER $$
CREATE PROCEDURE `add_detalle_entrada_tmp`(id_user_tmp INT, idarticulo_tmp INT,
 codigo_tmp VARCHAR(50), nombre_tmp VARCHAR(500), cantidad_tmp DECIMAL(11,3),
 pcompra_tmp DECIMAL(11,2), pventa_tmp DECIMAL(11,2))
BEGIN
INSERT INTO detalle_entrada_temp(id_user,idarticulo,codigo,nombre,
cantidad,pcompra,pventa)VALUES(id_user_tmp,idarticulo_tmp,codigo_tmp,
nombre_tmp,cantidad_tmp,pcompra_tmp,pventa_tmp);
SELECT *, SUM(tmp.cantidad) AS total_articulos FROM detalle_entrada_temp tmp WHERE tmp.id_user=id_user_tmp GROUP BY tmp.idarticulo ORDER BY tmp.identradatemp DESC;
END$$
DELIMITER ;

--
DELIMITER $$
CREATE PROCEDURE `add_detalle_venta_temp`(`id_user_tmp` INT, `idarticulo_tmp` INT, `codigo_tmp` VARCHAR(50), `nombre_tmp` VARCHAR(500), `cantidad_tmp` DECIMAL(11,3), `precio_tmp` DECIMAL(11,2), `descuento_tmp` DECIMAL(11,2), `iva_tmp` DECIMAL(11,2))
BEGIN
INSERT INTO detalle_venta_temp(id_user,idarticulo,codproducto,nombre,cantidad,precio,descuento,iva)VALUES(id_user_tmp,idarticulo_tmp,codigo_tmp,nombre_tmp,cantidad_tmp,precio_tmp,descuento_tmp,iva_tmp);
SELECT *, SUM(tmp.cantidad) AS total_articulos FROM detalle_venta_temp tmp WHERE tmp.id_user=id_user_tmp GROUP BY tmp.idarticulo ORDER BY tmp.iddetalletemp DESC;

END$$
DELIMITER ;

---

DELIMITER $$
CREATE PROCEDURE `delete_detalle_venta_temp`(`id_detalle_articulo_temp` INT,`id_user_temp` INT, `id_articulo` INT)
BEGIN
     	DELETE FROM detalle_venta_temp WHERE id_user=id_user_temp AND idarticulo=id_articulo;
        SELECT *, SUM(tmp.cantidad) AS total_articulos FROM detalle_venta_temp tmp WHERE tmp.id_user=id_user_temp GROUP BY tmp.idarticulo ORDER BY tmp.iddetalletemp DESC;
        
     END$$
DELIMITER ;

----
DELIMITER $$
CREATE PROCEDURE `delete_prod_entrada_tmp`(idart_tmp INT,id_user_tmp INT,id_articulo INT)
BEGIN
DELETE FROM detalle_entrada_temp temp WHERE temp.id_user=id_user_tmp AND temp.idarticulo=id_articulo;
SELECT tmp.*, SUM(tmp.cantidad) AS total_articulos FROM detalle_entrada_temp tmp WHERE tmp.id_user=id_user_tmp GROUP BY tmp.idarticulo ORDER BY tmp.identradatemp DESC;
END$$
DELIMITER ;