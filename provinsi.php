<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Provinsi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Data Provinsi</h2>
    <a href="tambah_provinsi.php" class="btn btn-primary mb-3">+ Tambah Provinsi</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
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
        $result = $conn->query("SELECT * FROM provinsi");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['email']}</td>
                <td>{$row['narahubung1']}</td>
                <td>{$row['narahubung2']}</td>
                <td>{$row['tahunSTR']}</td>
                <td>{$row['tanggalSTR']}</td>
                <td>
                    <a href='edit_provinsi.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                    <a href='hapus_provinsi.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                </td>
            </tr>";
        }
        ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
