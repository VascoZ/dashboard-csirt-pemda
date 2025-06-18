<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kab/Kota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Data Kabupaten / Kota</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kab/Kota</th>
                <th>Email</th>
                <th>Narahubung 1</th>
                <th>Narahubung 2</th>
                <th>Tahun STR</th>
                <th>Tanggal STR</th>
                <th>Provinsi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT kabkot.*, provinsi.nama AS nama_provinsi 
                      FROM kabkot 
                      JOIN provinsi ON kabkot.id_provinsi = provinsi.id";
            $result = $conn->query($query);
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['nama_provinsi']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['narahubung1']}</td>
                    <td>{$row['narahubung2']}</td>
                    <td>{$row['tahunSTR']}</td>
                    <td>{$row['tanggalSTR']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
