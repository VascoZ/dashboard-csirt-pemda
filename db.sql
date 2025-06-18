-- Membuat database
CREATE DATABASE csirt;

-- Gunakan database
USE csirt;

-- Ubah tabel provinsi agar nama unik
CREATE TABLE provinsi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100),
    narahubung1 VARCHAR(100),
    narahubung2 VARCHAR(100),
    tahunSTR YEAR,
    tanggalSTR DATE
);

-- Tabel kabkot dengan relasi ke nama provinsi
CREATE TABLE kabkot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    narahubung1 VARCHAR(100),
    narahubung2 VARCHAR(100),
    tahunSTR YEAR,
    tanggalSTR DATE,
    id_provinsi INT,
    FOREIGN KEY (id_provinsi) REFERENCES provinsi(id)
);
