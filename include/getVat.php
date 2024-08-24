<?php
include '../db/db_conn.php';

$code = $_GET['code'];

$sql = "SELECT vatper FROM vat WHERE code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
