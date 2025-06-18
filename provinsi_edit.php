<?php include 'conn.php'; ?>
<?php
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM provinsi WHERE id = $id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $narahubung1 = $_POST['narahubung1'];
    $narahubung2 = $_POST['narahubung2'];
    $status = $_POST['status'];
    $tahunSTR = $_POST['tahunSTR'];
    $tanggalSTR = $_POST['tanggalSTR'];

    $conn->query("UPDATE provinsi SET 
                    nama = '$nama',
                    email = '$email',
                    narahubung1 = '$narahubung1',
                    narahubung2 = '$narahubung2',
                    status = '$status',
                    tahunSTR = '$tahunSTR',
                    tanggalSTR = '$tanggalSTR'
                  WHERE id = $id");
    header("Location: provinsi.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Provinsi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Edit Provinsi</h2>
    <form method="POST">
        <input name="nama" type="text" class="form-control mb-2" value="<?= $data['nama'] ?>" required>
        <input name="email" type="email" class="form-control mb-2" value="<?= $data['email'] ?>">
        <input name="narahubung1" type="text" class="form-control mb-2" value="<?= $data['narahubung1'] ?>">
        <input name="narahubung2" type="text" class="form-control mb-2" value="<?= $data['narahubung2'] ?>">
        <input name="status" type="text" class="form-control mb-2" value="<?= $data['status'] ?>">
        <input name="tahunSTR" type="number" class="form-control mb-2" value="<?= $data['tahunSTR'] ?>">
        <input name="tanggalSTR" type="date" class="form-control mb-3" value="<?= $data['tanggalSTR'] ?>">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="provinsi.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
