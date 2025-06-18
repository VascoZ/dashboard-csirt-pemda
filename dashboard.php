<?php
include 'conn.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard CSIRT</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        table { border-collapse: collapse; width: 100%; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f36c6c; color: white; }
        h1 { color: #333; }
    </style>
</head>
<body>

<h1>Dashboard CSIRT Kabupaten/Kota</h1>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kabupaten/Kota</th>
            <th>Provinsi</th>
            <th>Email</th>
            <th>Narahubung 1</th>
            <th>Narahubung 2</th>
            <th>Tahun STR</th>
            <th>Tanggal STR</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT kabkot.nama AS kabkot_nama, provinsi.nama AS provinsi_nama, kabkot.email, 
                       kabkot.narahubung_1, kabkot.narahubung_2, kabkot.tahunSTR, kabkot.tanggalSTR 
                FROM kabkot
                JOIN provinsi ON kabkot.id_provinsi = provinsi.id";

        $result = $conn->query($sql);
        $no = 1;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['kabkot_nama']}</td>
                        <td>{$row['provinsi_nama']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['narahubung_1']}</td>
                        <td>{$row['narahubung_2']}</td>
                        <td>{$row['tahunSTR']}</td>
                        <td>{$row['tanggalSTR']}</td>
                      </tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='8'>Data belum tersedia</td></tr>";
        }

        $conn->close();
        ?>
    </tbody>
</table>

</body>
</html>
