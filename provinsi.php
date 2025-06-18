<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Provinsi</title>
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
        .sidebar .list-group-item:hover,
        .sidebar .list-group-item.active {
            background-color: #495057;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        th a {
            color: inherit;
            text-decoration: none;
        }
        th a:hover {
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
        <a href="provinsi.php" class="list-group-item active">Data Provinsi</a>
        <a href="kabkot.php" class="list-group-item">Data Kabupaten/Kota</a>
    </div>
</div>

<!-- Content -->
<div class="content">
    <h2>Data Provinsi</h2>

    <?php
    // Ambil total provinsi
    $total_result = $conn->query("SELECT COUNT(*) AS total FROM provinsi");
    $total_row = $total_result->fetch_assoc();
    echo "<p><strong>Total Provinsi:</strong> {$total_row['total']} data</p>";

    // Hitung jumlah berdasarkan status
    $status_list = ['Teregistrasi', 'Terbentuk', 'Proses'];
    $counts = [];

    foreach ($status_list as $s) {
        $res = $conn->query("SELECT COUNT(*) as total FROM provinsi WHERE status = '$s'");
        $row = $res->fetch_assoc();
        $counts[$s] = $row['total'];
    }

    $res = $conn->query("SELECT COUNT(*) as total FROM provinsi WHERE status IS NULL OR status = '' OR status = '-'");
    $row = $res->fetch_assoc();
    $counts['Belum Terbentuk'] = $row['total'];

    // Sorting logic
    $allowed_columns = ['nama', 'email', 'narahubung1', 'narahubung2', 'status', 'tahunSTR', 'tanggalSTR'];
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

    <a href="provinsi_tambah.php" class="btn btn-primary mb-3">Tambah Data</a>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>No</th>
            <?php
            foreach ([
                'nama' => 'Nama',
                'email' => 'Email',
                'narahubung1' => 'Narahubung 1',
                'narahubung2' => 'Narahubung 2',
                'status' => 'Status',
                'tahunSTR' => 'Tahun STR',
                'tanggalSTR' => 'Tanggal STR'
            ] as $key => $label) {
                echo "<th><a href='?sort={$key}&order=" . ($sort === $key ? $new_order : 'asc') . "'>$label" . sort_arrow($key, $sort, $order) . "</a></th>";
            }
            ?>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM provinsi ORDER BY $sort $order");
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            $status_display = trim($row['status']) ?: 'Belum Terbentuk';
            if ($status_display == '-') $status_display = 'Belum Terbentuk';

            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama']}</td>
                <td>{$row['email']}</td>
                <td>{$row['narahubung1']}</td>
                <td>{$row['narahubung2']}</td>
                <td>{$status_display}</td>
                <td>{$row['tahunSTR']}</td>
                <td>{$row['tanggalSTR']}</td>
                <td>
                    <a href='provinsi_edit.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                    <a href='provinsi_hapus.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
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
