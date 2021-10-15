--*********************** Triggers ***********************--

-- Créer un déclencheur update_stock_products sur la table products.
-- Celui-ci déduira du stock le produit commandé
DELIMITER |
CREATE TRIGGER update_stock_products
AFTER INSERT ON order_details
FOR EACH ROW
BEGIN
    UPDATE products
    SET stock = products.stock - NEW.quantity
    WHERE products.id = NEW.product_id 
END |
DELIMITER ;

