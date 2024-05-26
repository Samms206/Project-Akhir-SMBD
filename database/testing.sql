use db_projectakhirsmbd;

--History Pembelian
SELECT t.id, c.name as customer, u.name as staff, t.total, t.discount, t.paid, (t.change + t.discount) as changed, t.created_at as tanggal FROM customers c
JOIN transactions t ON t.cust_id = c.id
JOIN users u ON t.staff_id = u.id;

--Detail Hsitory Pembelian
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

--Produk terjual
SELECT p.name as product, SUM(td.qty) as qty, p.stock FROM products p
JOIN detail_transactions td ON td.product_id = p.id
JOIN transactions t ON t.id = td.trans_id
WHERE DATE(t.created_at) = CURDATE()
GROUP BY p.name
ORDER BY qty DESC


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



