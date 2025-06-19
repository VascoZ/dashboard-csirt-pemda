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
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
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
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 25px;
            background-color: #ffffff;
        }
        th a {
            color: inherit;
            text-decoration: none;
        }
        th a:hover {
            text-decoration: underline;
        }
        .table thead {
            background-color: #f1f1f1;
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

<!-- Content -->
<div class="content">
    <div class="card">
        <h2 class="mb-3">Data Kabupaten/Kota</h2>

        <?php
        // Hitung total data
        $total_result = $conn->query("SELECT COUNT(*) AS total FROM kabkot");
        $total_row = $total_result->fetch_assoc();
        echo "<p><strong>Total Kabupaten/Kota:</strong> {$total_row['total']} data</p>";

        // Hitung per status
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

        // Sort
        $allowed_columns = ['nama', 'provinsi_nama', 'email', 'narahubung1', 'narahubung2', 'status', 'tahunSTR', 'tanggalSTR'];
        $sort = in_array($_GET['sort'] ?? '', $allowed_columns) ? $_GET['sort'] : 'nama';
        $order = ($_GET['order'] ?? 'asc') === 'desc' ? 'desc' : 'asc';
        $new_order = $order === 'asc' ? 'desc' : 'asc';

        function sort_arrow($column, $current, $order) {
            if ($column !== $current) return '';
            return $order === 'asc' ? ' ↑' : ' ↓';
        }

        // Pagination
        $per_page = 30;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $per_page;

        // Search default by 'nama'
        $search = trim($_GET['search'] ?? '');
        $where_clause = $search ? "WHERE kabkot.nama LIKE '%$search%'" : '';

        // Count filtered total
        $count_sql = "SELECT COUNT(*) as total FROM kabkot JOIN provinsi ON kabkot.id_provinsi = provinsi.id $where_clause";
        $count_result = $conn->query($count_sql);
        $filtered_total = $count_result->fetch_assoc()['total'];

        // Data query
        $sql = "SELECT kabkot.*, provinsi.nama AS provinsi_nama 
                FROM kabkot 
                JOIN provinsi ON kabkot.id_provinsi = provinsi.id
                $where_clause
                ORDER BY $sort $order 
                LIMIT $per_page OFFSET $offset";

        $result = $conn->query($sql);
        ?>

        <!-- Status Summary -->
        <div class="mb-3">
            <strong>Total per Status:</strong>
            <ul>
                <li>Teregistrasi: <?= $counts['Teregistrasi'] ?> data</li>
                <li>Terbentuk: <?= $counts['Terbentuk'] ?> data</li>
                <li>Proses: <?= $counts['Proses'] ?> data</li>
                <li>Belum Terbentuk: <?= $counts['Belum Terbentuk'] ?> data</li>
            </ul>
        </div>

        <!-- Search Form -->
        <form class="mb-3" method="get">
            <div class="input-group" style="max-width: 400px;">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Nama" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <a href="kabkot_tambah.php" class="btn btn-primary mb-3">Tambah Data</a>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
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
                        echo "<th><a href='?sort={$key}&order=" . ($sort === $key ? $new_order : 'asc') . "&search=" . urlencode($search) . "'>$label" . sort_arrow($key, $sort, $order) . "</a></th>";
                    }
                    ?>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = $offset + 1;
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

        <!-- Pagination -->
        <?php
        $total_pages = ceil($filtered_total / $per_page);
        if ($total_pages > 1):
        ?>
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&sort=<?= $sort ?>&order=<?= $order ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
