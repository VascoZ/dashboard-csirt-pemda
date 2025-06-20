<?php
include 'conn.php';

// Set header untuk file CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data_provinsi.csv');

// Buka output stream
$output = fopen('php://output', 'w');

// Header kolom
fputcsv($output, ['No', 'Nama', 'Email', 'Narahubung 1', 'Narahubung 2', 'Status', 'Tahun STR', 'Tanggal STR']);

// Ambil data dari database
$query = $conn->query("SELECT * FROM provinsi ORDER BY nama ASC");
$no = 1;

while ($row = $query->fetch_assoc()) {
    $status = trim($row['status']);
    if ($status === '' || $status === '-') {
        $status = 'Belum Terbentuk';
    }

    fputcsv($output, [
        $no++,
        $row['nama'],
        $row['email'],
        $row['narahubung1'],
        $row['narahubung2'],
        $status,
        $row['tahunSTR'],
        $row['tanggalSTR']
    ]);
}

fclose($output);
exit;
