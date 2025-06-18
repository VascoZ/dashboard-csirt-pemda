<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kabupaten/Kota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background-color: #f1f3f5;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding-top: 60px;
        }
        .sidebar .list-group-item {
            background-color: transparent;
            border: none;
            color: white;
        }
        .sidebar .list-group-item.active,
        .sidebar .list-group-item:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        .table thead th a {
            color: inherit;
            text-decoration: none;
        }
        .table thead th a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
    <h4 class="text-center mb-4">CSIRT Menu</h4>
    <div class="list-group">
        <a href="index.php" class="list-group-item">Dashboard</a>
        <a href="provinsi.php" class="list-group-item">Data Provinsi</a>
        <a href="kabkot.php" class="list-group-item active">Data Kabupaten/Kota</a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <h2 class="mb-4">Data Kabupaten/Kota</h2>

    <?php
    $total_result = $conn->query("SELECT COUNT(*) AS total FROM kabkot");
    $total_row = $total_result->fetch_assoc();
    echo "<p><strong>Total Kabupaten/Kota:</strong> {$total_row['total']} data</p>";

    // Status counts
    $status_list = ['Teregistrasi', 'Terbentuk', 'Proses'];
    $counts = [];
    foreach ($status_list as $s) {
        $res = $conn->query("SELECT COUNT(*) as total FROM kabkot WHERE status = '$s'");
        $row = $res->fetch_assoc();
        $counts[$s] = $row['total'];
    }
    $res = $conn->query("SELECT COUNT(*) as total FROM kabkot WHERE status IS NULL OR status = '' OR status = '-'");
    $row = $res->fetch_assoc();
    $counts['Belum Terbentuk'] = $row['total'];

    $allowed_columns = ['nama', 'provinsi_nama', 'email', 'narahubung1', 'narahubung2', 'status', 'tahunSTR', 'tanggalSTR'];
    $sort = in_array($_GET['sort'] ?? '', $allowed_columns) ? $_GET['sort'] : 'nama';
    $order = ($_GET['order'] ?? 'asc') === 'desc' ? 'desc' : 'asc';
    $new_order = $order === 'asc' ? 'desc' : 'asc';

    function sort_arrow($column, $current, $order) {
        if ($column !== $current) return '';
        return $order === 'asc' ? ' ↑' : ' ↓';
    }
    ?>

    <div class="mb-3">
        <strong>Total per Status:</strong>
        <ul>
            <li>Teregistrasi: <?= $counts['Teregistrasi'] ?> data</li>
            <li>Terbentuk: <?= $counts['Terbentuk'] ?> data</li>
            <li>Proses: <?= $counts['Proses'] ?> data</li>
            <li>Belum Terbentuk: <?= $counts['Belum Terbentuk'] ?> data</li>
        </ul>
    </div>

    <a href="kabkot_tambah.php" class="btn btn-primary mb-3">Tambah Data</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <?php
                    $headers = [
                        'nama' => 'Kab/Kota',
                        'provinsi_nama' => 'Provinsi',
                        'email' => 'Email',
                        'narahubung1' => 'Narahubung 1',
                        'narahubung2' => 'Narahubung 2',
                        'status' => 'Status',
                        'tahunSTR' => 'Tahun STR',
                        'tanggalSTR' => 'Tanggal STR',
                    ];
                    foreach ($headers as $key => $label) {
                        echo "<th><a href='?sort={$key}&order=" . ($sort === $key ? $new_order : 'asc') . "'>$label" . sort_arrow($key, $sort, $order) . "</a></th>";
                    }
                    ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT kabkot.*, provinsi.nama AS provinsi_nama 
                        FROM kabkot 
                        JOIN provinsi ON kabkot.id_provinsi = provinsi.id 
                        ORDER BY $sort $order";
                $result = $conn->query($sql);
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    $status_display = trim($row['status']) ?: 'Belum Terbentuk';
                    if ($status_display == '-') $status_display = 'Belum Terbentuk';

                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['provinsi_nama']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['narahubung1']}</td>
                        <td>{$row['narahubung2']}</td>
                        <td>{$status_display}</td>
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
</div>

</body>
</html>
