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






--QUIZ
-- Create the database
CREATE DATABASE testing_mhs;

-- Use the newly created database
USE testing_mhs;

-- Create the mhs table
CREATE TABLE mhs (
    nim VARCHAR(10) PRIMARY KEY,
    nama VARCHAR(100),
    id_kota INT,
    alamat TEXT,
    FOREIGN KEY (id_kota) REFERENCES kota(id_kota)
);

-- Create the kuliah table
CREATE TABLE kuliah (
    nim VARCHAR(10),
    id_matakuliah INT,
    tahun YEAR,
    semester ENUM('Ganjil', 'Genap'),
    nilai CHAR(2),
    PRIMARY KEY (nim, id_matakuliah, tahun, semester),
    FOREIGN KEY (nim) REFERENCES mhs(nim),
    FOREIGN KEY (id_matakuliah) REFERENCES matakuliah(id_matakuliah)
);

-- Create the matakuliah table
CREATE TABLE matakuliah (
    id_matakuliah INT AUTO_INCREMENT PRIMARY KEY,
    matakuliah VARCHAR(100),
    sks INT,
    nip VARCHAR(10),
    FOREIGN KEY (nip) REFERENCES dosen(nip)
);

-- Create the kota table
CREATE TABLE kota (
    id_kota INT AUTO_INCREMENT PRIMARY KEY,
    kota VARCHAR(100)
);

-- Create the dosen table
CREATE TABLE dosen (
    nip VARCHAR(10) PRIMARY KEY,
    nama VARCHAR(100),
    id_kota INT,
    alamat TEXT,
    FOREIGN KEY (id_kota) REFERENCES kota(id_kota)
);

-- Create the bidangminat table
CREATE TABLE bidangminat (
    id_bidangminat INT AUTO_INCREMENT PRIMARY KEY,
    bidangminat VARCHAR(100)
);

-- Create the minatdosen table
CREATE TABLE minatdosen (
    nip VARCHAR(10),
    id_bidangminat INT,
    PRIMARY KEY (nip, id_bidangminat),
    FOREIGN KEY (nip) REFERENCES dosen(nip),
    FOREIGN KEY (id_bidangminat) REFERENCES bidangminat(id_bidangminat)
);

-- Insert data into the kota table
INSERT INTO kota (kota) VALUES
('Jakarta'),
('Bandung'),
('Surabaya'),
('Yogyakarta'),
('Medan'),
('Makassar'),
('Semarang'),
('Palembang'),
('Denpasar'),
('Balikpapan');

-- Insert data into the dosen table
INSERT INTO dosen (nip, nama, id_kota, alamat) VALUES
('D001', 'Dr. Budi Santoso', 1, 'Jl. Merdeka No. 1'),
('D002', 'Dr. Siti Aminah', 2, 'Jl. Dipatiukur No. 2'),
('D003', 'Prof. Irwan Nugraha', 3, 'Jl. Darmo No. 3'),
('D004', 'Dr. Rina Wijaya', 4, 'Jl. Malioboro No. 4'),
('D005', 'Prof. Agus Salim', 5, 'Jl. Sisingamangaraja No. 5'),
('D006', 'Dr. Rachmat Hidayat', 6, 'Jl. Pettarani No. 6'),
('D007', 'Dr. Nina Prasetya', 7, 'Jl. Pandanaran No. 7'),
('D008', 'Prof. Zulkifli Hasan', 8, 'Jl. Sudirman No. 8'),
('D009', 'Dr. Wayan Adnyana', 9, 'Jl. Sunset Road No. 9'),
('D010', 'Dr. Sri Rejeki', 10, 'Jl. Sudirman No. 10');

-- Insert data into the bidangminat table
INSERT INTO bidangminat (bidangminat) VALUES
('Artificial Intelligence'),
('Data Science'),
('Cyber Security'),
('Software Engineering'),
('Networks'),
('Database Systems'),
('Information Systems'),
('Human Computer Interaction'),
('Cloud Computing'),
('IoT');

-- Insert data into the minatdosen table
INSERT INTO minatdosen (nip, id_bidangminat) VALUES
('D001', 1),
('D002', 2),
('D003', 3),
('D004', 4),
('D005', 5),
('D006', 6),
('D007', 7),
('D008', 8),
('D009', 9),
('D010', 10);

-- Insert data into the mhs table
INSERT INTO mhs (nim, nama, id_kota, alamat) VALUES
('M001', 'Alice Johnson', 1, 'Jl. Merdeka Barat No. 1'),
('M002', 'Bob Smith', 2, 'Jl. Diponegoro No. 2'),
('M003', 'Charlie Brown', 3, 'Jl. Dr. Soetomo No. 3'),
('M004', 'David Wilson', 4, 'Jl. Mangkubumi No. 4'),
('M005', 'Eve Davis', 5, 'Jl. Iskandar Muda No. 5'),
('M006', 'Frank Miller', 6, 'Jl. Hertasning No. 6'),
('M007', 'Grace Lee', 7, 'Jl. Pemuda No. 7'),
('M008', 'Hannah Taylor', 8, 'Jl. Demang Lebar Daun No. 8'),
('M009', 'Ivy Clark', 9, 'Jl. Kuta No. 9'),
('M010', 'Jack White', 10, 'Jl. MT Haryono No. 10');

-- Insert data into the matakuliah table
INSERT INTO matakuliah (matakuliah, sks, nip) VALUES
('Introduction to AI', 3, 'D001'),
('Advanced Data Science', 4, 'D002'),
('Network Security', 3, 'D003'),
('Software Engineering Principles', 3, 'D004'),
('Computer Networks', 3, 'D005'),
('Database Management Systems', 4, 'D006'),
('Management Information Systems', 3, 'D007'),
('Human-Computer Interaction', 3, 'D008'),
('Cloud Infrastructure', 4, 'D009'),
('Internet of Things', 3, 'D010');

-- Insert data into the kuliah table
INSERT INTO kuliah (nim, id_matakuliah, tahun, semester, nilai) VALUES
('M011', 2, 2024, 'Ganjil', 'B'),
('M012', 3, 2024, 'Ganjil', 'A'),
('M013', 4, 2024, 'Ganjil', 'B'),
('M014', 5, 2024, 'Ganjil', 'C'),
('M015', 6, 2024, 'Ganjil', 'A'),
('M016', 7, 2024, 'Ganjil', 'B'),
('M017', 8, 2024, 'Ganjil', 'A'),
('M018', 9, 2024, 'Ganjil', 'C'),
('M019', 10, 2024, 'Ganjil', 'B'),
('M020', 1, 2024, 'Ganjil', 'C');

INSERT INTO mhs VALUES
('M011', 'John Smith', 1, 'Jl. Jalan Jalan No. 1'),
('M012', 'Jane Doe', 2, 'Jl. Jalan Jalan No. 2'),
('M013', 'Bob Johnson', 3, 'Jl. Jalan Jalan No. 3'),
('M014', 'Alice Lee', 4, 'Jl. Jalan Jalan No. 4'),
('M015', 'Mark Davis', 5, 'Jl. Jalan Jalan No. 5'),
('M016', 'Emily Chen', 6, 'Jl. Jalan Jalan No. 6'),
('M017', 'David Kim', 7, 'Jl. Jalan Jalan No. 7'),
('M018', 'Sarah Tan', 8, 'Jl. Jalan Jalan No. 8'),
('M019', 'Michael Chen', 9, 'Jl. Jalan Jalan No. 9'),
('M020', 'Olivia Lee', 10, 'Jl. Jalan Jalan No. 10');

INSERT INTO mhs VALUES
('M021', 'John Smith', 1, 'Jl. Jalan Jalan No. 1');
INSERT INTO kuliah (nim, id_matakuliah, tahun, semester, nilai) VALUES
('M021', 1, 2024, 'Ganjil', 'D');


SELECT m.nim, m.nama, k.nilai
FROM mhs m
JOIN kuliah k ON m.nim = k.nim
JOIN matakuliah mk ON k.id_matakuliah = mk.id_matakuliah
WHERE mk.matakuliah = 'ALPRO' AND k.nilai = 'C';

SELECT m.nim, m.nama, k.nilai
FROM mhs m
JOIN kuliah k ON m.nim = k.nim
JOIN matakuliah mk ON k.id_matakuliah = mk.id_matakuliah
WHERE mk.matakuliah = 'ALPRO' AND k.nilai = (
    SELECT MAX(nilai)
    FROM kuliah k JOIN matakuliah mk ON k.id_matakuliah = mk.id_matakuliah
    WHERE k.id_matakuliah = mk.id_matakuliah
);

--π m.nim, m.nama, k.nilai (σ mk.matakuliah = 'ALPRO' ^ k.nilai = MAX(σ id_matakuliah = mk.id_matakuliah (kuliah)))


 SELECT nilai
    FROM kuliah
    WHERE id_matakuliah = 6
    GROUP BY nilai;


SELECT m.nim, m.nama, k.nilai
FROM mhs m
JOIN kuliah k ON m.nim = k.nim
JOIN matakuliah mk ON k.id_matakuliah = mk.id_matakuliah
WHERE mk.matakuliah = 'ALPRO' AND k.nilai = (
    SELECT nilai
    FROM kuliah k
    JOIN matakuliah mk ON k.id_matakuliah = mk.id_matakuliah
    WHERE k.id_matakuliah = mk.id_matakuliah
    GROUP BY nilai DESC LIMIT 1
);
