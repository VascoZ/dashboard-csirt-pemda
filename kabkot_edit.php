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
        <div class="mb-2"><label>Narahubung 1</label><input type="text" name="narahubung_1" value="<?= $data['narahubung_1'] ?>" class="form-control"></div>
        <div class="mb-2"><label>Narahubung 2</label><input type="text" name="narahubung_2" value="<?= $data['narahubung_2'] ?>" class="form-control"></div>
        <div class="mb-2"><label>Tahun STR</label><input type="text" name="tahunSTR" value="<?= $data['tahunSTR'] ?>" class="form-control"></div>
        <div class="mb-2"><label>Tanggal STR</label><input type="date" name="tanggalSTR" value="<?= $data['tanggalSTR'] ?>" class="form-control"></div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="kabkot.php" class="btn btn-secondary">Kembali</a>
    </form>

    <?php
    if (isset($_POST['update'])) {
        $sql = "UPDATE kabkot SET nama=?, id_provinsi=?, email=?, narahubung_1=?, narahubung_2=?, tahunSTR=?, tanggalSTR=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisssssi",
            $_POST['nama'], $_POST['id_provinsi'], $_POST['email'],
            $_POST['narahubung_1'], $_POST['narahubung_2'],
            $_POST['tahunSTR'], $_POST['tanggalSTR'], $id
        );
        $stmt->execute();
        echo "<div class='alert alert-success mt-3'>Data berhasil diupdate!</div>";
    }
    ?>
</div>
</body>
</html>
