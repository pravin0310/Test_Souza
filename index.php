<!DOCTYPE html>
<html>
<?php
include 'db/db_conn.php';
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <title>Purchase Form</title>
    <script>
        function calculateAmounts() {
            let rows = document.querySelectorAll('.item-row');
            let totalBasicAmount = 0;
            let totalPrice = 0;

            rows.forEach(row => {
                let qty = parseFloat(row.querySelector('.quantity').value) || 0;
                let price = parseFloat(row.querySelector('.price').value) || 0;
                let vatPer = parseFloat(row.querySelector('.vat-code').value) || 0;
                let discountValue = parseFloat(row.querySelector('.discount-value').value) || 0;
                let discountType = row.querySelector('.discount-type').value;

                let basicAmount = qty * price + (qty * price * vatPer / 100);
                let rowTotalPrice = basicAmount;

                if (discountType === 'Percentage') {
                    if (discountValue >= 100) {
                        alert('Discount percentage cannot be 100 or more.');
                        row.querySelector('.discount-value').value = '';
                        return;
                    }
                    rowTotalPrice -= (basicAmount * discountValue / 100);
                } else {
                    rowTotalPrice -= discountValue;
                }

                row.querySelector('.basic-amount').value = basicAmount.toFixed(2);
                row.querySelector('.total-price').value = rowTotalPrice.toFixed(2);

                totalBasicAmount += basicAmount;
                totalPrice += rowTotalPrice;
            });

            document.getElementById('total-basic-amount').innerText = totalBasicAmount.toFixed(2);
            document.getElementById('total-price').innerText = totalPrice.toFixed(2);
        }

        function addNewRow() {
            let templateRow = document.getElementById('template-row');
            let newRow = templateRow.cloneNode(true);

            newRow.removeAttribute('id');
            newRow.querySelectorAll('input, select').forEach(input => {
                input.value = '';
            });

            document.getElementById('item-rows').appendChild(newRow);
            calculateAmounts();
        }

        function removeRow(button) {
            let rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                let row = button.closest('.item-row');
                if (row) {
                    row.remove();
                    calculateAmounts();
                }
            } else {
                alert("You Do not Remove the Purchase Form");
            }
        }


        function checkValidate() {
            let rows = document.querySelectorAll('.item-row');
            let isValid = true;
            // return;
            rows.forEach(row => {
                let qty = parseFloat(row.querySelector('.quantity').value) || 0;
                let itemCode = row.querySelector('.item-code').value || "";
                let price = row.querySelector('.price').value || 0;

                if (itemCode == "" && qty <= 0) {
                    alert('Enter Quantity for Item Code ' + itemCode);
                    row.querySelector('.quantity').style.border = '2px solid red';
                    row.querySelector('.item-code').style.border = '2px solid red';
                    row.querySelector('.price').style.border = '2px solid red';
                    isValid = false;
                }
            });

            if (isValid) {
                document.getElementById('purchase-form').submit();
            }
        }
    </script>
</head>

<body>
    <h1 class="text-center">Purchase Form</h1>
    <div class="container mt-4">
        <form id="purchase-form" method="post" action="include/saveItem.php">
            <div class="row">
                <div class="col-12">
                    <div id="item-rows">
                        <div class="row">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-secondary" onclick="addNewRow()">Add New Row</button>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control date" name="date" id="date">
                            </div>
                            <div class="col-md-3">
                                <?php
                                $invNo = 1;
                                $sql = "SELECT inv_no FROM purchases order by inv_no DESC limit 1";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $invNo = $row['inv_no'] + 1;
                                }
                                echo '<span><label for="">Invoice No: </label>' . $invNo . '</span>';
                                echo '<input type="hidden" class="form-control invNo" name="invNo" id="invNo" value="' . $invNo . '">';
                                ?>
                            </div>
                        </div>
                        <div id="template-row" class="item-row mb-3 p-3 border rounded">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="category">Category</label>
                                    <select class="form-control item-category" name="item_category[]" id="cat" onchange="changecatgryDescUnites(this)">
                                        <option value="">Select Item Code</option>
                                        <?php
                                        $sql = "SELECT cat,code, description FROM ims_itemcodes";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['cat']}'>{$row['cat']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="category">Item Code</label>
                                    <select class="form-control item-code" name="item_code[]" id="code" onchange="changecatgryDescUnites(this)">
                                        <option value="">Select Item Code</option>
                                        <?php
                                        $sql = "SELECT cat,code, description FROM ims_itemcodes";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['code']}'>{$row['code']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="category">Description</label>
                                    <!-- <input type="text" class="form-control description" name="description[]" readonly> -->
                                    <select class="form-control item-Description" name="description[]" id="description" onchange="changecatgryDescUnites(this)">
                                        <option value="">Select Description</option>
                                        <?php
                                        $sql = "SELECT cat,code, description FROM ims_itemcodes";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['description']}'>{$row['description']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="sunits">Units</label>
                                    <input type="text" class="form-control sunits" name="sunits[]" id="sunits">

                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2">
                                    <label for="" class="category">Quantity</label>
                                    <input type="number" class="form-control quantity" name="quantity[]" id="quantity" value="0">
                                </div>
                                <div class="col-md-2">
                                    <label for="" class="category">Price/Unit</label>
                                    <input type="number" class="form-control price" name="price[]" min="0" step="0.01" oninput="calculateAmounts()" value="0">
                                </div>
                                <div class="col-md-2">
                                    <label for="" class="category">VAT Code</label>
                                    <select class="form-control vat-code" name="vat_code[]" onchange="changeVatCode(this)">
                                        <option value="">Select VAT Code</option>
                                        <?php
                                        $sql = "SELECT code, vatper FROM vat";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['vatper']}'>{$row['vatper']}%</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="category">Discount Type</label>
                                    <select class="form-control discount-type" name="discount_type[]" onchange="calculateAmounts()">
                                        <option value="Percentage">Percentage</option>
                                        <option value="Amount">Amount</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="category">Discount Value</label>
                                    <input type="number" class="form-control discount-value" name="discount_value[]" min="0" step="0.01" oninput="calculateAmounts()">
                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <label for="" class="category">Basic Amount</label>
                                    <input type="text" class="form-control basic-amount" name="basic_amount[]" value="0.00" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="category">Total Price</label>
                                    <input type="text" class="form-control total-price" name="total_price[]" value="0.00" readonly>
                                    <div class="remove-btn-container mt-2">

                                    </div>
                                </div>
                                <div class="col-md-3" style="margin-top: 24px;">
                                    <label for="" class="category"></label>
                                    <!-- <input type="text" class="form-control total-price" name="total_price[]" value="0.00" readonly> -->
                                    <button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button>

                                </div>
                            </div>
                        </div>
                        <!-- End of Template Row -->
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div>Total Basic Amount: <span id="total-basic-amount">0.00</span></div>
                        </div>
                        <div class="col-md-6">
                            <div>Total Price: <span id="total-price">0.00</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <button type="button" class="btn btn-primary" onclick="checkValidate()">Save</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function changecatgryDescUnites(select) {
            let row = select.closest('.item-row');
            let itemCode = select.value;
            let type = select.id;

            if (itemCode) {
                fetch(`include/itemDet.php?type=${type}&value=${itemCode}`)
                    .then(response => response.json())
                    .then(data => {
                        row.querySelector('#description').value = data.description;
                        row.querySelector('#sunits').value = data.sunits;
                        row.querySelector('#code').value = data.code;
                        row.querySelector('#cat').value = data.cat;

                        calculateAmounts();
                    });
            } else {
                row.querySelector('.description').value = '';
                row.querySelector('.units').value = '';
                calculateAmounts();
            }
        }

        function changeVatCode(select) {
            let row = select.closest('.item-row');
            let vatCode = select.value;
            calculateAmounts();
        }
    </script>
</body>

</html>