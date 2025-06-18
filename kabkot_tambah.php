<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kab/Kota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Tambah Kabupaten/Kota</h2>
    <form action="" method="post">
        <div class="mb-2">
            <label>Nama Kab/Kota</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Provinsi</label>
            <select name="id_provinsi" class="form-control" required>
                <option value="">-- Pilih Provinsi --</option>
                <?php
                $prov = $conn->query("SELECT * FROM provinsi");
                while ($p = $prov->fetch_assoc()) {
                    echo "<option value='{$p['id']}'>{$p['nama']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-2"><label>Email</label><input type="email" name="email" class="form-control"></div>
        <div class="mb-2"><label>Narahubung 1</label><input type="text" name="narahubung_1" class="form-control"></div>
        <div class="mb-2"><label>Narahubung 2</label><input type="text" name="narahubung_2" class="form-control"></div>
        <div class="mb-2"><label>Tahun STR</label><input type="text" name="tahunSTR" class="form-control"></div>
        <div class="mb-2"><label>Tanggal STR</label><input type="date" name="tanggalSTR" class="form-control"></div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="kabkot.php" class="btn btn-secondary">Kembali</a>
    </form>

    <?php
    if (isset($_POST['simpan'])) {
        $sql = "INSERT INTO kabkot (nama, id_provinsi, email, narahubung_1, narahubung_2, tahunSTR, tanggalSTR)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisssss",
            $_POST['nama'], $_POST['id_provinsi'], $_POST['email'],
            $_POST['narahubung_1'], $_POST['narahubung_2'],
            $_POST['tahunSTR'], $_POST['tanggalSTR']
        );
        $stmt->execute();
        echo "<div class='alert alert-success mt-3'>Data berhasil ditambahkan!</div>";
    }
    ?>
</div>
</body>
</html>
