<?php
include '../db/db_conn.php';
$value = $_GET['value'];
$type = $_GET['type'];

$sql = "SELECT cat,code,description, sunits FROM ims_itemcodes WHERE $type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $value);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
