<?php include 'conn.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $narahubung1 = $_POST['narahubung1'];
    $narahubung2 = $_POST['narahubung2'];
    $status = $_POST['status'];
    $tahunSTR = !empty($_POST['tahunSTR']) ? $_POST['tahunSTR'] : null;
    $tanggalSTR = !empty($_POST['tanggalSTR']) ? $_POST['tanggalSTR'] : null;


    $stmt = $conn->prepare("INSERT INTO provinsi (nama, email, narahubung1, narahubung2, status, tahunSTR, tanggalSTR) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nama, $email, $narahubung1, $narahubung2, $status, $tahunSTR, $tanggalSTR);
    $stmt->execute();

    header("Location: provinsi.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Provinsi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Tambah Provinsi</h2>
    <form method="POST">
        <input name="nama" type="text" class="form-control mb-2" placeholder="Nama Provinsi" required>
        <input name="email" type="email" class="form-control mb-2" placeholder="Email">
        <input name="narahubung1" type="text" class="form-control mb-2" placeholder="Narahubung 1">
        <input name="narahubung2" type="text" class="form-control mb-2" placeholder="Narahubung 2">

        <select name="status" class="form-control mb-2" required>
            <option value="">-- Pilih Status --</option>
            <option value="Teregistrasi">Teregistrasi</option>
            <option value="Terbentuk">Terbentuk</option>
            <option value="Proses">Proses</option>
            <option value="-">-</option>
        </select>

        <input name="tahunSTR" type="number" class="form-control mb-2" placeholder="Tahun STR">
        <input name="tanggalSTR" type="date" class="form-control mb-3">
        
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="provinsi.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
