<?php
include 'conn.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="kabkot_export.csv"');

$search = trim($_GET['search'] ?? '');
$search_by = $_GET['search_by'] ?? 'nama';
$filter_status = trim($_GET['filter_status'] ?? '');

$where_clauses = [];

if ($search !== '') {
    $search_safe = $conn->real_escape_string($search);
    if ($search_by === 'provinsi') {
        $where_clauses[] = "provinsi.nama = '$search_safe'";
    } else {
        $where_clauses[] = "kabkot.nama LIKE '%$search_safe%'";
    }
}

if ($filter_status !== '') {
    if ($filter_status === 'Belum Terbentuk') {
        $where_clauses[] = "(kabkot.status IS NULL OR kabkot.status = '' OR kabkot.status = '-')";
    } else {
        $filter_status_safe = $conn->real_escape_string($filter_status);
        $where_clauses[] = "kabkot.status = '$filter_status_safe'";
    }
}

$where_sql = '';
if (count($where_clauses)) {
    $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
}

$sql = "SELECT kabkot.*, provinsi.nama AS provinsi_nama 
        FROM kabkot 
        JOIN provinsi ON kabkot.id_provinsi = provinsi.id 
        $where_sql 
        ORDER BY provinsi.nama ASC, kabkot.nama ASC";

$result = $conn->query($sql);

$output = fopen('php://output', 'w');

// Header kolom CSV
fputcsv($output, ['Kab/Kota', 'Provinsi', 'Email', 'Narahubung 1', 'Narahubung 2', 'Status', 'Tahun STR', 'Tanggal STR']);

while ($row = $result->fetch_assoc()) {
    $status_display = trim($row['status']) ?: 'Belum Terbentuk';
    if ($status_display === '-') {
        $status_display = 'Belum Terbentuk';
    }

    fputcsv($output, [
        $row['nama'],
        $row['provinsi_nama'],
        $row['email'],
        $row['narahubung1'],
        $row['narahubung2'],
        $status_display,
        $row['tahunSTR'],
        $row['tanggalSTR']
    ]);
}

fclose($output);
exit;
