<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kabupaten/Kota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar .list-group-item {
            background-color: transparent;
            border: none;
            color: white;
        }
        .sidebar .list-group-item:hover {
            background-color: #495057;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
    <h4 class="text-center mb-4">CSIRT Menu</h4>
    <div class="list-group">
        <a href="dashboard.php" class="list-group-item">Dashboard</a>
        <a href="provinsi.php" class="list-group-item">Data Provinsi</a>
        <a href="kabkot.php" class="list-group-item active">Data Kabupaten/Kota</a>
    </div>
</div>

<!-- Content -->
<div class="content">
    <h2>Data Kabupaten/Kota</h2>
    <a href="kabkot_tambah.php" class="btn btn-primary mb-3">Tambah Data</a>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>No</th>
            <th>Kab/Kota</th>
            <th>Provinsi</th>
            <th>Email</th>
            <th>Narahubung 1</th>
            <th>Narahubung 2</th>
            <th>Tahun STR</th>
            <th>Tanggal STR</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT kabkot.*, provinsi.nama AS provinsi_nama FROM kabkot 
                JOIN provinsi ON kabkot.id_provinsi = provinsi.id";
        $result = $conn->query($sql);
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama']}</td>
                <td>{$row['provinsi_nama']}</td>
                <td>{$row['email']}</td>
                <td>{$row['narahubung_1']}</td>
                <td>{$row['narahubung_2']}</td>
                <td>{$row['tahunSTR']}</td>
                <td>{$row['tanggalSTR']}</td>
                <td>
                    <a href='kabkot_edit.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                    <a href='kabkot_hapus.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                </td>
            </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
