<?php include 'conn.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM kabkot WHERE id=$id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Kab/Kota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Edit Kabupaten/Kota</h2>
    <form action="" method="post">
        <div class="mb-2"><label>Nama</label><input type="text" name="nama" value="<?= $data['nama'] ?>" class="form-control" required></div>
        <div class="mb-2">
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
        <div class="mb-2"><label>Email</label><input type="email" name="email" value="<?= $data['email'] ?>" class="form-control"></div>
        <div class="mb-2"><label>Narahubung 1</label><input type="text" name="narahubung1" value="<?= $data['narahubung1'] ?>" class="form-control"></div>
        <div class="mb-2"><label>Narahubung 2</label><input type="text" name="narahubung2" value="<?= $data['narahubung2'] ?>" class="form-control"></div>

        <div class="mb-2">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <?php
                $statusOptions = ["Teregistrasi", "Terbentuk", "Proses", "-"];
                foreach ($statusOptions as $status) {
                    $selected = ($data['status'] == $status) ? 'selected' : '';
                    echo "<option value=\"$status\" $selected>$status</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-2"><label>Tahun STR</label><input type="text" name="tahunSTR" value="<?= $data['tahunSTR'] ?>" class="form-control"></div>
        <div class="mb-2"><label>Tanggal STR</label><input type="date" name="tanggalSTR" value="<?= $data['tanggalSTR'] ?>" class="form-control"></div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="kabkot.php" class="btn btn-secondary">Kembali</a>
    </form>

<?php
if (isset($_POST['update'])) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssssi", 
        $_POST['nama'],
        $_POST['id_provinsi'],
        $_POST['email'],
        $_POST['narahubung1'],
        $_POST['narahubung2'],
        $_POST['status'],
        $tahunSTR = !empty($_POST['tahunSTR']) ? $_POST['tahunSTR'] : null;
        $tanggalSTR = !empty($_POST['tanggalSTR']) ? $_POST['tanggalSTR'] : null;
        $id
    $sql = "UPDATE kabkot SET nama=?, id_provinsi=?, email=?, narahubung1=?, narahubung2=?, status=?, tahunSTR=?, tanggalSTR=? WHERE id=?";

    );
    if ($stmt->execute()) {
        echo "<div class='alert alert-success mt-3'>Data berhasil diupdate!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Gagal update: " . $stmt->error . "</div>";
    }
}
?>

</div>
</body>
</html>
