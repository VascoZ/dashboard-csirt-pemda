<?php
include 'conn.php';

// Tangkap parameter pencarian jika ada
$search = trim($_GET['search'] ?? '');
$search_by = $_GET['search_by'] ?? 'nama';

$where_clause = '';
if ($search !== '') {
    if ($search_by === 'provinsi') {
        $search_safe = $conn->real_escape_string($search);
        $where_clause = "WHERE provinsi.nama = '$search_safe'";
    } else {
        $search_safe = $conn->real_escape_string($search);
        $where_clause = "WHERE kabkot.nama LIKE '%$search_safe%'";
    }
}

// Set header untuk file CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=kabkot_export.csv');

$output = fopen('php://output', 'w');

// Header kolom
fputcsv($output, ['No', 'Kab/Kota', 'Provinsi', 'Email', 'Narahubung 1', 'Narahubung 2', 'Status', 'Tahun STR', 'Tanggal STR']);

// Query data
$query = "SELECT kabkot.*, provinsi.nama AS provinsi_nama
          FROM kabkot
          JOIN provinsi ON kabkot.id_provinsi = provinsi.id
          $where_clause
          ORDER BY provinsi.nama ASC, kabkot.nama ASC";

$result = $conn->query($query);
$no = 1;

while ($row = $result->fetch_assoc()) {
    $status = trim($row['status']);
    if ($status === '' || $status === '-') $status = 'Belum Terbentuk';

    fputcsv($output, [
        $no++,
        $row['nama'],
        $row['provinsi_nama'],
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
?>
