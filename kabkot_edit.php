<?php
include 'conn.php';

ob_start(); // ➜ Aktifkan output buffering agar header() bisa dipakai kapan saja

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM kabkot WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $id_provinsi = $_POST['id_provinsi'];
    $email = $_POST['email'];
    $narahubung1 = $_POST['narahubung1'];
    $narahubung2 = $_POST['narahubung2'];
    $status = $_POST['status'];
    $tahunSTR = !empty($_POST['tahunSTR']) ? $_POST['tahunSTR'] : null;
    $tanggalSTR = !empty($_POST['tanggalSTR']) ? $_POST['tanggalSTR'] : null;

    $sql = "UPDATE kabkot SET nama = ?, id_provinsi = ?, email = ?, narahubung1 = ?, narahubung2 = ?, status = ?, tahunSTR = ?, tanggalSTR = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssssi", $nama, $id_provinsi, $email, $narahubung1, $narahubung2, $status, $tahunSTR, $tanggalSTR, $id);

    if ($stmt->execute()) {
        // ✅ Redirect ke halaman sebelumnya
        $redirect = $_SERVER['HTTP_REFERER'] ?? 'kabkot.php';
        header("Location: $redirect");
        exit;
    } else {
        $error = "Gagal update: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Kab/Kota</title>
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
    <div class="card mx-auto" style="max-width: 650px;">
        <h2 class="text-center">Edit Kab/Kota</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Nama Kab/Kota</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Provinsi</label>
                <select name="id_provinsi" class="form-control" required>
                    <?php
                    $prov = $conn->query("SELECT * FROM provinsi");
                    while ($p = $prov->fetch_assoc()) {
                        $selected = ($p['id'] == $data['id_provinsi']) ? 'selected' : '';
                        echo "<option value='{$p['id']}' $selected>{$p['nama']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>">
            </div>
            <div class="mb-3">
                <label>Narahubung 1</label>
                <input type="text" name="narahubung1" class="form-control" value="<?= htmlspecialchars($data['narahubung1']) ?>">
            </div>
            <div class="mb-3">
                <label>Narahubung 2</label>
                <input type="text" name="narahubung2" class="form-control" value="<?= htmlspecialchars($data['narahubung2']) ?>">
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
                <input type="text" name="tahunSTR" class="form-control" value="<?= htmlspecialchars($data['tahunSTR']) ?>">
            </div>
            <div class="mb-4">
                <label>Tanggal STR</label>
                <input type="date" name="tanggalSTR" class="form-control" value="<?= htmlspecialchars($data['tanggalSTR']) ?>">
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="kabkot.php" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
