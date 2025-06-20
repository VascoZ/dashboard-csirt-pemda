<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kabupaten/Kota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            width: 240px;
            background-color: #1e1e2f;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
        }
        .sidebar h4 {
            color: #ffffff;
            font-weight: bold;
        }
        .sidebar .list-group {
            width: 100%;
        }
        .sidebar .list-group-item {
            background: none;
            border: none;
            color: #b0b3c1;
            font-size: 16px;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: background 0.2s ease;
        }
        .sidebar .list-group-item:hover {
            background-color: #2c2c44;
            color: #ffffff;
        }
        .sidebar .list-group-item.active {
            background-color: #0d6efd;
            color: #ffffff;
            font-weight: bold;
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

        /* Responsive table column control */
        
        .table td, .table th {
            max-width: 180px;
            min-width: 120px;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;
            vertical-align: middle;
            font-size: clamp(0.7rem, 1vw, 0.95rem);
        }

        /* Khusus kolom No agar tidak ikut min-width dan max-width */
        .table td.no-col, .table th.no-col {
            width: 1%;
            white-space: nowrap;
            min-width: unset;
            max-width: unset;
            text-align: center;
            font-size: 0.85rem;
            padding: 6px 10px;
        }




        @media (max-width: 992px) {
            .table td, .table th {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center mb-4">CSIRT Menu</h4>
    <div class="list-group">
        <a href="index.php" class="list-group-item <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="provinsi.php" class="list-group-item <?= basename($_SERVER['PHP_SELF']) == 'provinsi.php' ? 'active' : '' ?>">
            <i class="bi bi-geo-alt"></i> Data Provinsi
        </a>
        <a href="kabkot.php" class="list-group-item <?= basename($_SERVER['PHP_SELF']) == 'kabkot.php' ? 'active' : '' ?>">
            <i class="bi bi-building"></i> Data Kab/Kota
        </a>
    </div>
</div>

<!-- Content -->
<div class="content">
    <div class="card">
        <h2 class="mb-3">Data Kabupaten/Kota</h2>
        <?php
        $total_result = $conn->query("SELECT COUNT(*) AS total FROM kabkot");
        $total_row = $total_result->fetch_assoc();
        echo "<p><strong>Total Kabupaten/Kota:</strong> {$total_row['total']} data</p>";
        ?>
        <?php
        $search = trim($_GET['search'] ?? '');
        $search_by = $_GET['search_by'] ?? 'nama';

        $where_clause = '';
        if ($search !== '') {
            if ($search_by === 'provinsi') {
                $search_safe = $conn->real_escape_string($search);
                $where_clause = "WHERE provinsi.nama = '$search_safe'";
            } else {
                $where_clause = "WHERE kabkot.nama LIKE '%$search%'";
            }
        }

        $status_list = ['Teregistrasi', 'Terbentuk', 'Proses'];
        $counts = [];

        foreach ($status_list as $s) {
            $status_condition = "kabkot.status = '$s'";
            $sql_count = "SELECT COUNT(*) as total FROM kabkot 
                          JOIN provinsi ON kabkot.id_provinsi = provinsi.id 
                          $where_clause " . ($where_clause ? "AND $status_condition" : "WHERE $status_condition");
            $res = $conn->query($sql_count);
            $row = $res->fetch_assoc();
            $counts[$s] = $row['total'];
        }

        $null_condition = "(kabkot.status IS NULL OR kabkot.status = '' OR kabkot.status = '-')";
        $sql_null = "SELECT COUNT(*) as total FROM kabkot 
                     JOIN provinsi ON kabkot.id_provinsi = provinsi.id 
                     $where_clause " . ($where_clause ? "AND $null_condition" : "WHERE $null_condition");
        $res = $conn->query($sql_null);
        $row = $res->fetch_assoc();
        $counts['Belum Terbentuk'] = $row['total'];
        ?>

        <?php if ($search && $search_by === 'provinsi'): ?>
            <div class="mb-2 text-muted">
                <em>Menampilkan status berdasarkan provinsi: <strong><?= htmlspecialchars($search) ?></strong></em>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <strong>Total per Status:</strong>
            <ul>
                <li>Teregistrasi: <?= $counts['Teregistrasi'] ?> data</li>
                <li>Terbentuk: <?= $counts['Terbentuk'] ?> data</li>
                <li>Proses: <?= $counts['Proses'] ?> data</li>
                <li>Belum Terbentuk: <?= $counts['Belum Terbentuk'] ?> data</li>
            </ul>
        </div>

        <form class="mb-3" method="get">
            <div class="row g-2 align-items-center">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari data..." value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-md-3">
                    <select name="search_by" class="form-select">
                        <option value="nama" <?= $search_by === 'nama' ? 'selected' : '' ?>>Berdasarkan Nama Kab/Kota</option>
                        <option value="provinsi" <?= $search_by === 'provinsi' ? 'selected' : '' ?>>Berdasarkan Nama Provinsi</option>
                    </select>
                </div>
                <div class="col-md-auto">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </div>
        </form>
        <a href="kabkot_export_csv.php?search=<?= urlencode($search) ?>&search_by=<?= $search_by ?>" class="btn btn-success mb-3"><i class="bi bi-file-earmark-excel"></i>Export Excel</a>
        <a href="kabkot_tambah.php" class="btn btn-primary mb-3">Tambah Data</a>

        <?php
        $allowed_columns = ['nama', 'provinsi_nama', 'email', 'narahubung1', 'narahubung2', 'status', 'tahunSTR', 'tanggalSTR'];
        $sort = in_array($_GET['sort'] ?? '', $allowed_columns) ? $_GET['sort'] : 'provinsi_nama';
        $order = ($_GET['order'] ?? 'asc') === 'desc' ? 'desc' : 'asc';
        $new_order = $order === 'asc' ? 'desc' : 'asc';

        function sort_arrow($column, $current, $order) {
            if ($column !== $current) return '';
            return $order === 'asc' ? ' ↑' : ' ↓';
        }

        $per_page = 30;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $per_page;

        $count_sql = "SELECT COUNT(*) as total FROM kabkot 
                      JOIN provinsi ON kabkot.id_provinsi = provinsi.id 
                      $where_clause";
        $count_result = $conn->query($count_sql);
        $filtered_total = $count_result->fetch_assoc()['total'];

        $sql = "SELECT kabkot.*, provinsi.nama AS provinsi_nama 
                FROM kabkot 
                JOIN provinsi ON kabkot.id_provinsi = provinsi.id 
                $where_clause
                ORDER BY $sort $order 
                LIMIT $per_page OFFSET $offset";
        $result = $conn->query($sql);
        ?>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="no-col">No</th>
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
                            echo "<th><a href='?page=$page&sort=$key&order=" . ($sort === $key ? $new_order : 'asc') . "&search=" . urlencode($search) . "&search_by=$search_by'>$label" . sort_arrow($key, $sort, $order) . "</a></th>";
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

                    $tanggalSTR = $row['tanggalSTR'];
                    $tanggalSTR_class = '';
                    if ($tanggalSTR && $tanggalSTR !== '0000-00-00') {
                        $tgl = new DateTime($tanggalSTR);
                        $now = new DateTime();
                        $interval = $tgl->diff($now);
                        if ($interval->y >= 3) {
                            $tanggalSTR_class = 'text-danger fw-bold';
                        }
                    }

                    echo "<tr>
                        <td class='no-col'>{$no}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['provinsi_nama']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['narahubung1']}</td>
                        <td>{$row['narahubung2']}</td>
                        <td>{$status_display}</td>
                        <td>{$row['tahunSTR']}</td>
                        <td class='{$tanggalSTR_class}'>" . htmlspecialchars($tanggalSTR) . "</td>
                        <td>
                            <a href='kabkot_edit.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='kabkot_hapus.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                        </td>
                    </tr>";
                    $no++;
                }

                if ($filtered_total === 0) {
                    echo "<tr><td colspan='10' class='text-center text-muted'>Data tidak ditemukan</td></tr>";
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
                        <a class="page-link" href="?page=<?= $i ?>&sort=<?= $sort ?>&order=<?= $order ?>&search=<?= urlencode($search) ?>&search_by=<?= $search_by ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
