<?php

include_once "config.php";

$orderQuery = "SELECT * FROM orders WHERE order_email=?";
$email = $_SESSION['customer'];
$stmt = statement_init();
statement_confirm($stmt, $orderQuery);

//Bind params
mysqli_stmt_bind_param($stmt, "s", $email);
//Run parameters inside db
statement_execute($stmt);
$result = statement_result($stmt);

while($row = fetch_array($result)){
    $dataArray = array();

    $dataArray[] = $row['order_payment_id'];
    $dataArray[] = $row['order_date'];
    $dataArray[] = $row['order_amount_gross'];
    $dataArray[] = $row['order_payment_status'];
}

echo json_encode($dataArray);

?>