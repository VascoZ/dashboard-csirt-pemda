<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard CSIRT</title>
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
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
    <h4 class="text-center mb-4">CSIRT Menu</h4>
    <div class="list-group">
        <a href="index.php" class="list-group-item active">Dashboard</a>
        <a href="provinsi.php" class="list-group-item">Data Provinsi</a>
        <a href="kabkot.php" class="list-group-item">Data Kabupaten/Kota</a>
    </div>
</div>

<!-- Content -->
<div class="content">
    <h2>Dashboard CSIRT Pemda</h2>

    <?php
    // Hitung status CSIRT provinsi
    $status_list = ['Teregistrasi', 'Terbentuk', 'Proses'];
    $counts = [];

    foreach ($status_list as $s) {
        $res = $conn->query("SELECT COUNT(*) as total FROM provinsi WHERE status = '$s'");
        $row = $res->fetch_assoc();
        $counts[$s] = (int)$row['total'];
    }

    // Tambah status kosong/null/strip jadi "Belum Terbentuk"
    $res = $conn->query("SELECT COUNT(*) as total FROM provinsi WHERE status IS NULL OR status = '' OR status = '-'");
    $row = $res->fetch_assoc();
    $counts['Belum Terbentuk'] = (int)$row['total'];
    ?>

    <div class="mb-4">
        <h4>Status CSIRT Provinsi</h4>
        <ul>
            <li>Teregistrasi: <?= $counts['Teregistrasi'] ?> data</li>
            <li>Terbentuk: <?= $counts['Terbentuk'] ?> data</li>
            <li>Proses: <?= $counts['Proses'] ?> data</li>
            <li>Belum Terbentuk: <?= $counts['Belum Terbentuk'] ?> data</li>
        </ul>
    </div>

    <div class="mb-4">
        <h4>Distribusi Status dalam Pie Chart</h4>
        <canvas id="statusPieChart" width="400" height="400"></canvas>
    </div>

</div>

<!-- Chart.js data injection & import -->
<script>
    window.statusChartLabels = <?= json_encode(array_keys($counts)) ?>;
    window.statusChartData = <?= json_encode(array_values($counts)) ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="chart-status-provinsi.js"></script>

</body>
</html>
