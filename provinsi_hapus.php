<?php
include 'conn.php';
$id = $_GET['id'];
$conn->query("DELETE FROM provinsi WHERE id = $id");
header("Location: provinsi.php");
?>