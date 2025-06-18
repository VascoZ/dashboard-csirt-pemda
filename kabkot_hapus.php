<?php
include 'conn.php';
$id = $_GET['id'];
$conn->query("DELETE FROM kabkot WHERE id=$id");
header("Location: kabkot.php");
exit();
?>
