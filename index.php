<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard CSIRT</title>
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
    $total_prov = array_sum($counts_prov);

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
    $total_kabkot = array_sum($counts_kabkot);
    ?>

    <!-- Card: Total Gabungan -->
    <div class="card p-4">
        <h4>Total CSIRT Seluruh Indonesia</h4>
        <?php
        $total_all = $total_prov + $total_kabkot;

        // Gabungan status
        $total_teregistrasi = $counts_prov['Teregistrasi'] + $counts_kabkot['Teregistrasi'];
        $total_terbentuk = $counts_prov['Terbentuk'] + $counts_kabkot['Terbentuk'];
        $total_proses = $counts_prov['Proses'] + $counts_kabkot['Proses'];
        $total_belum = $counts_prov['Belum Terbentuk'] + $counts_kabkot['Belum Terbentuk'];
        ?>

        <p class="mb-2">
            <strong>Total Keseluruhan:</strong> <?= $total_all ?> 
        </p>
        <p class="mb-0">
            <strong>Total CSIRT Teregistrasi Administrasi Pemerintah:</strong> <?= $total_teregistrasi ?> <br>
            <strong>Total Belum Terbentuk:</strong> <?= $total_belum ?> 
        </p>
    </div>

        <!-- Card: Status Provinsi -->
        <div class="card p-4">
            <h4>CSIRT Provinsi</h4>
            <ul class="mb-0">
                <li>Teregistrasi: <?= $counts_prov['Teregistrasi'] ?></li>
                <li>Terbentuk: <?= $counts_prov['Terbentuk'] ?> </li>
                <li>Proses: <?= $counts_prov['Proses'] ?> </li>
                <li>Belum Terbentuk: <?= $counts_prov['Belum Terbentuk'] ?> </li>
            </ul>
        </div>

    <!-- Card: Status Kab/Kota -->
    <div class="card p-4">
        <h4>CSIRT Kab/Kota</h4>
        <ul class="mb-0">
            <li>Teregistrasi: <?= $counts_kabkot['Teregistrasi'] ?> </li>
            <li>Terbentuk: <?= $counts_kabkot['Terbentuk'] ?> </li>
            <li>Proses: <?= $counts_kabkot['Proses'] ?></li>
            <li>Belum Terbentuk: <?= $counts_kabkot['Belum Terbentuk'] ?> </li>
        </ul>
    </div>

    <!-- Gabungan Chart -->
    <div class="row">
        <div class="col-md-12">
            <div class="card p-4 text-center">
                <h4>TOTAL CSIRT</h4>
                <div class="chart-container">
                    <canvas id="combinedChart"></canvas>
                </div>
            </div>
        </div>
    </div>


    <!-- Chart Row -->
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
    window.statusChartLabelsProv = <?= json_encode(array_keys($counts_prov)) ?>;
    window.statusChartDataProv = <?= json_encode(array_values($counts_prov)) ?>;

    window.statusChartLabelsKabkot = <?= json_encode(array_keys($counts_kabkot)) ?>;
    window.statusChartDataKabkot = <?= json_encode(array_values($counts_kabkot)) ?>;
</script>

<!-- Chart.js -->
 <script>
    window.combinedChartLabels = ['Teregistrasi', 'Belum Terbentuk'];
    window.combinedChartData = [
        <?= $total_teregistrasi ?>,
        <?= $total_belum ?>
    ];
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
// Chart Gabungan Teregistrasi vs Belum Terbentuk
new Chart(document.getElementById('combinedChart'), {
    type: 'doughnut',
    data: {
        labels: window.combinedChartLabels,
        datasets: [{
            data: window.combinedChartData,
            backgroundColor: ['#4CAF50', '#F44336']
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

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
