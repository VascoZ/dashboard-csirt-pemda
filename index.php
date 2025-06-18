<?php include 'conn.php'; ?> 
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard CSIRT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
            display: block;
        }
        .sidebar .list-group-item {
            background: none;
            border: none;
            color: white;
        }
        .content {
            flex: 1;
            padding: 20px;
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
        <a href="kabkot.php" class="list-group-item">Data Kabupaten/Kota</a>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <h1 class="mb-4">Dashboard CSIRT</h1>
    <p>Selamat datang di sistem monitoring CSIRT Provinsi dan Kabupaten/Kota.</p>

    <!-- Di sini nanti kamu bisa menampilkan grafik, tabel, dsb -->
</div>

</body>
</html>
