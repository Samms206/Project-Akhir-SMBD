use db_projectakhirsmbd;

--History Transaksi
SELECT t.id, c.name as customer, u.name as staff, t.total, t.discount, t.paid, (t.change + t.discount) as changed, t.created_at as tanggal FROM customers c
JOIN transactions t ON t.cust_id = c.id
JOIN users u ON t.staff_id = u.id;

--Detail History Transaksi
SELECT td.id, p.name as product, p.hrg_jual as harga, td.qty, (p.hrg_jual*td.qty) as sub_total FROM customers c
JOIN transactions t ON t.cust_id = c.id
JOIN detail_transactions td ON td.trans_id = t.id
JOIN products p ON td.product_id = p.id WHERE t.id = 2;

--Pendapatan hari ini
SELECT SUM(total-discount) as pendapatanHariIni FROM transactions WHERE DATE(created_at) = CURDATE();

--Pendapatan Minggu ini
SELECT SUM(total-discount) as pendapatanMingguIni FROM transactions WHERE DATE(created_at) >= CURDATE() - INTERVAL 7 DAY;

--Pendapatan Bulan ini
SELECT SUM(total-discount) as pendapatanBulanIni FROM transactions WHERE DATE(created_at) >= CURDATE() - INTERVAL 30 DAY;

--Total penjualan bulan ini
SELECT COUNT(*) as sales FROM transactions WHERE DATE(created_at) >= CURDATE() - INTERVAL 30 DAY;

--Total penjualan tahun ini
SELECT COUNT(*) as sales FROM transactions WHERE DATE(created_at) >= CURDATE() - INTERVAL 365 DAY;

--Total Produk
SELECT COUNT(*) as totalProduct FROM products;

--Produk terjual
SELECT p.name as product, SUM(td.qty) as sold, p.stock FROM products p
JOIN detail_transactions td ON td.product_id = p.id
JOIN transactions t ON t.id = td.trans_id
GROUP BY p.name
ORDER BY qty DESC;

--All produk terjual
SELECT SUM(td.qty) as sold FROM products p
JOIN detail_transactions td ON td.product_id = p.id
JOIN transactions t ON t.id = td.trans_id

--Total stock product
SELECT SUM(stock) as totalStock FROM products;
--total tiap bulannya (january - juni)
SELECT
    SUM(CASE WHEN MONTH(created_at) = 1 THEN total-discount ELSE 0 END) AS januari,
    SUM(CASE WHEN MONTH(created_at) = 2 THEN total-discount ELSE 0 END) AS februari,
    SUM(CASE WHEN MONTH(created_at) = 3 THEN total-discount ELSE 0 END) AS maret,
    SUM(CASE WHEN MONTH(created_at) = 4 THEN total-discount ELSE 0 END) AS april,
    SUM(CASE WHEN MONTH(created_at) = 5 THEN total-discount ELSE 0 END) AS mei,
    SUM(CASE WHEN MONTH(created_at) = 6 THEN total-discount ELSE 0 END) AS juni
FROM
    transactions
WHERE
    YEAR(created_at) = YEAR(CURDATE()) AND
    MONTH(created_at) BETWEEN 1 AND 6;


-- procedure insert Product
CREATE PROCEDURE insertProduct(IN vname VARCHAR(255), IN vhrg_beli INT, IN vhrg_jual INT, IN vstock INT)
BEGIN
    INSERT INTO products (name, hrg_beli, hrg_jual, stock, created_at, updated_at) VALUES (vname, vhrg_beli, vhrg_jual, vstock, NOW(), NOW());
END
CALL insertProduct('test', 10000, 20000, 10);
DROP PROCEDURE insertProduct;

-- procedure update Product
CREATE PROCEDURE updateProduct(IN vid INT, IN vname VARCHAR(255), IN vhrg_beli INT, IN vhrg_jual INT, IN vstock INT)
BEGIN
    UPDATE products SET name = vname, hrg_beli = vhrg_beli, hrg_jual = vhrg_jual, stock = vstock, updated_at = NOW() WHERE id = vid;
END
CALL updateProduct(11, 'Yupi', 500, 1000, 100);
DROP PROCEDURE updateProduct;

-- procedure delete Product
CREATE PROCEDURE deleteProduct(IN vid INT)
BEGIN
    DELETE FROM products WHERE id = vid;
END
CALL deleteProduct(11);
DROP PROCEDURE deleteProduct;


-- procedure insert Customer
CREATE PROCEDURE insertCustomer(IN vname VARCHAR(255), IN vaddress VARCHAR(255), IN vphone VARCHAR(255))
BEGIN
    INSERT INTO customers (name, address, phone, created_at, updated_at) VALUES (vname, vaddress, vphone, NOW(), NOW());
END
CALL insertCustomer('test', 'test', 'test');
DROP PROCEDURE insertCustomer;

-- procedure update Customer
CREATE PROCEDURE updateCustomer(IN vid INT, IN vname VARCHAR(255), IN vaddress VARCHAR(255), IN vphone VARCHAR(255))
BEGIN
    UPDATE customers SET name = vname, address = vaddress, phone = vphone, updated_at = NOW() WHERE id = vid;
END
CALL updateCustomer(11, 'Yupi', 'Yupi', 'Yupi');
DROP PROCEDURE updateCustomer;

-- procedure delete Customer
CREATE PROCEDURE deleteCustomer(IN vid INT)
BEGIN
    DELETE FROM customers WHERE id = vid;
END
CALL deleteCustomer(11);
DROP PROCEDURE deleteCustomer;


SELECT*FROM vdetail_history_transaction;


--TRRIGGER DELETE PRODUCT VALIDATION
DELIMITER //
CREATE PROCEDURE delete_product(IN pid INT, OUT hasil VARCHAR(255))
BEGIN
    DECLARE baris INT;
    SELECT COUNT(*) INTO baris FROM detail_transactions WHERE product_id = pid;

    IF baris > 0 THEN
        SET hasil = 'Produk tidak dapat dihapus karena terkait dengan transaksi.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Produk tidak dapat dihapus karena terkait dengan transaksi.';
    ELSE
        SET hasil = 'Produk dihapus';
        DELETE FROM products WHERE id = pid;
    END IF;
END //
DELIMITER ;
DROP PROCEDURE delete_product;

INSERT INTO products(name, hrg_beli, hrg_jual, stock, created_at, updated_at)VALUES('test', 10000, 20000, 10, NOW(), NOW());
SELECT *FROM products;
START TRANSACTION;
ROLLBACK;
CALL delete_product(17, @baris);
SELECT @baris;



SELECT*from products;
SELECT*from detail_transactions;


SELECT SUM(total-discount) as pendapatanBulanIni FROM transactions;


--codeium
--tolong buatkan fungsi untuk menghitung total produk yang sudah terjual
