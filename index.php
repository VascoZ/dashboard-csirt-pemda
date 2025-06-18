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
    // Data Provinsi
    $status_list = ['Teregistrasi', 'Terbentuk', 'Proses'];
    $counts_prov = [];

    foreach ($status_list as $s) {
        $res = $conn->query("SELECT COUNT(*) as total FROM provinsi WHERE status = '$s'");
        $row = $res->fetch_assoc();
        $counts_prov[$s] = (int)$row['total'];
    }

    $res = $conn->query("SELECT COUNT(*) as total FROM provinsi WHERE status IS NULL OR status = '' OR status = '-'");
    $row = $res->fetch_assoc();
    $counts_prov['Belum Terbentuk'] = (int)$row['total'];

    // Data Kab/Kot
    $counts_kabkot = [];
    foreach ($status_list as $s) {
        $res = $conn->query("SELECT COUNT(*) as total FROM kabkot WHERE status = '$s'");
        $row = $res->fetch_assoc();
        $counts_kabkot[$s] = (int)$row['total'];
    }

    $res = $conn->query("SELECT COUNT(*) as total FROM kabkot WHERE status IS NULL OR status = '' OR status = '-'");
    $row = $res->fetch_assoc();
    $counts_kabkot['Belum Terbentuk'] = (int)$row['total'];
    ?>

    <!-- Card 1: Status Provinsi -->
    <div class="card p-4">
        <h4>Status CSIRT Provinsi</h4>
        <ul class="mb-0">
            <li>Teregistrasi: <?= $counts_prov['Teregistrasi'] ?> data</li>
            <li>Terbentuk: <?= $counts_prov['Terbentuk'] ?> data</li>
            <li>Proses: <?= $counts_prov['Proses'] ?> data</li>
            <li>Belum Terbentuk: <?= $counts_prov['Belum Terbentuk'] ?> data</li>
        </ul>
    </div>

    <!-- Chart Row: Provinsi dan Kabkot -->
    <div class="row">
        <div class="col-md-6">
            <div class="card p-4 text-center">
                <h4>Data CSIRT Provinsi</h4>
                <div class="chart-container">
                    <canvas id="statusPieChartProvinsi"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 text-center">
                <h4>Data CSIRT Kab/Kota</h4>
                <div class="chart-container">
                    <canvas id="statusPieChartKabkot"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inject Data to Chart -->
<script>
    // Provinsi
    window.statusChartLabelsProv = <?= json_encode(array_keys($counts_prov)) ?>;
    window.statusChartDataProv = <?= json_encode(array_values($counts_prov)) ?>;

    // Kabkot
    window.statusChartLabelsKabkot = <?= json_encode(array_keys($counts_kabkot)) ?>;
    window.statusChartDataKabkot = <?= json_encode(array_values($counts_kabkot)) ?>;
</script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Provinsi
    new Chart(document.getElementById('statusPieChartProvinsi'), {
        type: 'pie',
        data: {
            labels: window.statusChartLabelsProv,
            datasets: [{
                data: window.statusChartDataProv,
                backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#F44336']
            }]
        }
    });

    // Chart Kabkot
    new Chart(document.getElementById('statusPieChartKabkot'), {
        type: 'pie',
        data: {
            labels: window.statusChartLabelsKabkot,
            datasets: [{
                data: window.statusChartDataKabkot,
                backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#F44336']
            }]
        }
    });
</script>

</body>
</html>
