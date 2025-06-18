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
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .card h4 {
            margin-bottom: 15px;
        }

        .chart-container {
            width: 300px;
            height: 300px;
            margin: auto;
        }
        canvas {
            width: 100% !important;
            height: 100% !important;
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
    <h2 class="mb-4">Dashboard CSIRT Pemda</h2>

    <?php
    $status_list = ['Teregistrasi', 'Terbentuk', 'Proses'];
    $counts = [];

    foreach ($status_list as $s) {
        $res = $conn->query("SELECT COUNT(*) as total FROM provinsi WHERE status = '$s'");
        $row = $res->fetch_assoc();
        $counts[$s] = (int)$row['total'];
    }

    $res = $conn->query("SELECT COUNT(*) as total FROM provinsi WHERE status IS NULL OR status = '' OR status = '-'");
    $row = $res->fetch_assoc();
    $counts['Belum Terbentuk'] = (int)$row['total'];
    ?>

    <!-- Card 1: Status Summary -->
    <div class="card p-4">
        <h4>Status CSIRT Provinsi</h4>
        <ul class="mb-0">
            <li>Teregistrasi: <?= $counts['Teregistrasi'] ?> data</li>
            <li>Terbentuk: <?= $counts['Terbentuk'] ?> data</li>
            <li>Proses: <?= $counts['Proses'] ?> data</li>
            <li>Belum Terbentuk: <?= $counts['Belum Terbentuk'] ?> data</li>
        </ul>
    </div>

    <!-- Card 2: Pie Chart -->
    <div class="card p-4 text-center">
        <h4>Distribusi Status (Pie Chart)</h4>
        <div class="chart-container">
            <canvas id="statusPieChart"></canvas>
        </div>
    </div>
</div>

<!-- Inject Data to Chart -->
<script>
    window.statusChartLabels = <?= json_encode(array_keys($counts)) ?>;
    window.statusChartData = <?= json_encode(array_values($counts)) ?>;
</script>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="chart-status-provinsi.js"></script>

</body>
</html>
