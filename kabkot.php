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

        $per_page = 30;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $per_page;

        $search = $_GET['search'] ?? '';
        $filter_by = $_GET['filter_by'] ?? '';

        $allowed_columns = array_keys($headers);
        $sort = in_array($_GET['sort'] ?? '', $allowed_columns) ? $_GET['sort'] : 'nama';
        $order = ($_GET['order'] ?? 'asc') === 'desc' ? 'desc' : 'asc';
        $new_order = $order === 'asc' ? 'desc' : 'asc';

        function sort_arrow($column, $current, $order) {
            if ($column !== $current) return '';
            return $order === 'asc' ? ' ↑' : ' ↓';
        }

        $where_clause = '';
        if (!empty($search) && !empty($filter_by) && in_array($filter_by, $allowed_columns)) {
            $search_escaped = $conn->real_escape_string($search);
            $where_clause = "WHERE $filter_by LIKE '%$search_escaped%'";
        }

        $count_sql = "SELECT COUNT(*) as total FROM kabkot JOIN provinsi ON kabkot.id_provinsi = provinsi.id $where_clause";
        $count_result = $conn->query($count_sql);
        $total_data = $count_result->fetch_assoc()['total'];
        $total_pages = ceil($total_data / $per_page);

        $sql = "SELECT kabkot.*, provinsi.nama AS provinsi_nama 
                FROM kabkot 
                JOIN provinsi ON kabkot.id_provinsi = provinsi.id 
                $where_clause 
                ORDER BY $sort $order 
                LIMIT $per_page OFFSET $offset";

        $result = $conn->query("SELECT COUNT(*) AS total FROM kabkot");
        $total_row = $result->fetch_assoc();
        echo "<p><strong>Total Kabupaten/Kota:</strong> {$total_row['total']} data</p>";

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

        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari data..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="filter_by" class="form-select">
                    <option value="">Filter Kolom</option>
                    <?php foreach ($headers as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($_GET['filter_by'] ?? '') === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>No</th>
                    <?php foreach ($headers as $key => $label): ?>
                        <th><a href="?<?= http_build_query(array_merge($_GET, ['sort' => $key, 'order' => ($sort === $key ? $new_order : 'asc')])) ?>"><?= $label . sort_arrow($key, $sort, $order) ?></a></th>
                    <?php endforeach; ?>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $result = $conn->query($sql);
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

        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>

</body>
</html>
