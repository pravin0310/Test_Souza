<?php
include '../db/db_conn.php';

try {
    $groupedData = [];
    foreach ($_POST['item_code'] as $index => $item_code) {
        // Create item object
        $item = [
            'date' => $_POST['date'],
            'invNo' => $_POST['invNo'],
            'item_category' => $_POST['item_category'][$index],
            'item_code' => $item_code,
            'description' => $_POST['description'][$index],
            'sunits' => $_POST['sunits'][$index],
            'quantity' => (int)$_POST['quantity'][$index],
            'price' => (float)$_POST['price'][$index],
            'vat_code' => $_POST['vat_code'][$index],
            'discount_type' => $_POST['discount_type'][$index],
            'discount_value' => (float)$_POST['discount_value'][$index],
            'basic_amount' => (float)$_POST['basic_amount'][$index],
            'total_price' => (float)$_POST['total_price'][$index]
        ];
        $groupedData[] = $item;
    };

    foreach ($groupedData as $index => $row) {

        $invNo = mysqli_real_escape_string($conn, $row['invNo']);
        $date = mysqli_real_escape_string($conn, $row['date']);
        $item_category = mysqli_real_escape_string($conn, $row['item_category']);
        $item_code = mysqli_real_escape_string($conn, $row['item_code']);
        $description = mysqli_real_escape_string($conn, $row['description']);
        $sunits = mysqli_real_escape_string($conn, $row['sunits']);
        $vat_code = mysqli_real_escape_string($conn, $row['vat_code']);
        $discount_type = mysqli_real_escape_string($conn, $row['discount_type']);

        $query = "INSERT INTO purchases (inv_no, date, category, code, description, unit, qty, price, vat, basic_amount, discount_type, discount_val, total_price) 
                  VALUES ('$invNo', '$date', '$item_category', '$item_code', '$description', '$sunits', {$row['quantity']}, {$row['price']}, '$vat_code', {$row['basic_amount']}, '$discount_type', {$row['discount_value']}, {$row['total_price']})";

        if (!mysqli_query($conn, $query)) {
            throw new Exception("Error executing query: " . mysqli_error($conn));
        }
    }

    header("Location: ../index.php");
} catch (Exception $e) {
    echo "Failed: " . $e->getMessage();
}

$conn->close();
