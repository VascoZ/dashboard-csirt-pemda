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
    $tahunSTR = !empty($_POST['tahunSTR']) ? $_POST['tahunSTR'] : null;
    $tanggalSTR = !empty($_POST['tanggalSTR']) ? $_POST['tanggalSTR'] : null;

    $stmt = $conn->prepare("UPDATE provinsi SET 
        nama = ?, email = ?, narahubung1 = ?, narahubung2 = ?, 
        status = ?, tahunSTR = ?, tanggalSTR = ?
        WHERE id = ?");
    $stmt->bind_param("sssssssi", $nama, $email, $narahubung1, $narahubung2, $status, $tahunSTR, $tanggalSTR, $id);
    $stmt->execute();

    header("Location: provinsi.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Provinsi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }
        h2 {
            font-weight: 600;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 600px;">
        <h2 class="text-center">Edit Provinsi</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Nama Provinsi</label>
                <input name="nama" type="text" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input name="email" type="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>">
            </div>
            <div class="mb-3">
                <label>Narahubung 1</label>
                <input name="narahubung1" type="text" class="form-control" value="<?= htmlspecialchars($data['narahubung1']) ?>">
            </div>
            <div class="mb-3">
                <label>Narahubung 2</label>
                <input name="narahubung2" type="text" class="form-control" value="<?= htmlspecialchars($data['narahubung2']) ?>">
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <?php
                    $statusOptions = ["Teregistrasi", "Terbentuk", "Proses", "-"];
                    foreach ($statusOptions as $s) {
                        $selected = ($data['status'] == $s) ? 'selected' : '';
                        echo "<option value=\"$s\" $selected>$s</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Tahun STR</label>
                <input name="tahunSTR" type="number" class="form-control" value="<?= htmlspecialchars($data['tahunSTR']) ?>">
            </div>
            <div class="mb-4">
                <label>Tanggal STR</label>
                <input name="tanggalSTR" type="date" class="form-control" value="<?= htmlspecialchars($data['tanggalSTR']) ?>">
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="provinsi.php" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
