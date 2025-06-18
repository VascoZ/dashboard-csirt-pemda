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

INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Aceh', '', '', '', 'Teregistrasi', '2022', '2022-04-14');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Sumatera Utara', '', '', '', 'Teregistrasi', '2022', '2022-03-28');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Sumatera Selatan', '', '', '', 'Teregistrasi', '2021', '2021-06-16');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Sumatera Barat', '', '', '', 'Teregistrasi', '2020', '2020-07-21');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Bengkulu', '', '', '', 'Teregistrasi', '2021', '2021-05-19');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Riau', '', '', '', 'Teregistrasi', '2021', '2021-08-25');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Kepulauan Riau', '', '', '', 'Teregistrasi', '2020', '2020-09-29');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Jambi', '', '', '', 'Teregistrasi', '2021', '2021-05-25');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Lampung', '', '', '', 'Teregistrasi', '2022', '2022-05-27');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Kepulauan Bangka Belitung', '', '', '', 'Teregistrasi', '2021', '2021-06-08');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Banten', '', '', '', 'Teregistrasi', '2021', '2021-08-04');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('DKI Jakarta', '', '', '', 'Teregistrasi', '2020', '2020-12-23');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Jawa Barat', '', '', '', 'Teregistrasi', '2024', '2024-12-19');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Jawa Tengah', '', '', '', 'Teregistrasi', '2020', '2020-10-07');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('DI Yogyakarta', '', '', '', 'Teregistrasi', '2020', '2020-10-14');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Jawa Timur', '', '', '', 'Teregistrasi', '2020', '2020-02-28');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Kalimantan Barat', '', '', '', 'Teregistrasi', '2023', '2023-07-07');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Kalimantan Tengah', '', '', '', 'Teregistrasi', '2021', '2021-10-19');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Kalimantan Timur', '', '', '', 'Teregistrasi', '2021', '2021-11-16');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Kalimantan Selatan', '', '', '', 'Teregistrasi', '2020', '2020-11-11');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Kalimantan Utara', '', '', '', 'Teregistrasi', '2022', '2022-05-19');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Bali', '', '', '', 'Teregistrasi', '2021', '2021-05-05');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Nusa Tenggara Timur', '', '', '', 'Teregistrasi', '2022', '2022-04-14');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Nusa Tenggara Barat', '', '', '', 'Teregistrasi', '2020', '2020-11-04');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Gorontalo', '', '', '', 'Teregistrasi', '2020', '2020-08-11');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Sulawesi Barat', '', '', '', 'Teregistrasi', '2021', '2021-06-22');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Sulawesi Tengah', '', '', '', 'Teregistrasi', '2023', '2023-03-27');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Sulawesi Utara', '', '', '', 'Teregistrasi', '2022', '2022-04-07');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Sulawesi Tenggara', '', '', '', 'Teregistrasi', '2022', '2022-05-24');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Sulawesi Selatan', '', '', '', 'Teregistrasi', '2021', '2021-06-29');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Maluku Utara', '', '', '', 'Teregistrasi', '2023', '2023-05-17');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Maluku', '', '', '', 'Teregistrasi', '2021', '2021-08-05');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Papua Barat', '', '', '', 'Teregistrasi', '2021', '2021-05-27');
INSERT INTO `provinsi` (`nama`, `email`, `narahubung1`, `narahubung2`, `status`, `tahunSTR`, `tanggalSTR`) VALUES ('Papua', '', '', '', 'Teregistrasi', '2021', '2021-07-14');
