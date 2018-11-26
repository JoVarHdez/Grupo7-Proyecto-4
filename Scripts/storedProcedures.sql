DROP PROCEDURE IF EXISTS `select_active_products_with_rate`;
delimiter ;;
CREATE PROCEDURE `select_active_products_with_rate` (IN pName VARCHAR(255), IN pDescription TEXT, IN pRate VARCHAR(1))
BEGIN
	SELECT p.*,
			IF(count(rate) > 0, SUM(rate)/count(rate), 0) AS globalRate
	FROM products p
	LEFT JOIN rates on rates.idProduct = p.idProduct
	WHERE (p.description LIKE CONCAT('%', pDescription, '%') OR 
			p.name LIKE CONCAT('%', pName, '%')) AND active = 1 
	GROUP BY p.idProduct
	HAVING globalRate LIKE CONCAT(pRate, '%')
	UNION ALL
	SELECT p.*,
			IF(count(rate) > 0, SUM(rate)/count(rate), 0) AS globalRate
	FROM products p
	LEFT JOIN rates on rates.idProduct = p.idProduct
	WHERE (p.description LIKE CONCAT('%', pDescription, '%') OR 
			p.name LIKE CONCAT('%', pName, '%')) AND active = 1

	GROUP BY p.idProduct
	HAVING globalRate NOT LIKE CONCAT(pRate, '%');
END
 ;;
delimiter ;

DROP PROCEDURE IF EXISTS `select_active_products_with_rate_by_category`;
delimiter ;;
CREATE PROCEDURE `select_active_products_with_rate_by_category` (IN pCategory INT(10), IN pName VARCHAR(255), IN pDescription TEXT, IN pRate VARCHAR(1))
BEGIN
	SELECT p.*,
			IF(count(rate) > 0, SUM(rate)/count(rate), 0) AS globalRate
    FROM products p
	LEFT JOIN rates on rates.idProduct = p.idProduct
    INNER JOIN productsPerCategory ON productsPerCategory.idProduct = p.idProduct
    INNER JOIN categories ON categories.idCategory = productsPerCategory.idCategory
	WHERE (p.description LIKE CONCAT('%', pDescription, '%') OR 
			p.name LIKE CONCAT('%', pName, '%')) AND active = 1 AND categories.idCategory = pCategory
    GROUP BY p.idProduct
	HAVING globalRate LIKE CONCAT(pRate, '%')
    UNION ALL
    	SELECT p.*,
			IF(count(rate) > 0, SUM(rate)/count(rate), 0) AS globalRate
    FROM products p
	LEFT JOIN rates on rates.idProduct = p.idProduct
    INNER JOIN productsPerCategory ON productsPerCategory.idProduct = p.idProduct
    INNER JOIN categories ON categories.idCategory = productsPerCategory.idCategory
	WHERE (p.description LIKE CONCAT('%', pDescription, '%') OR 
			p.name LIKE CONCAT('%', pName, '%')) AND active = 1 AND categories.idCategory = pCategory
    GROUP BY p.idProduct
	HAVING globalRate NOT LIKE CONCAT(pRate, '%');
END
 ;;
delimiter ;