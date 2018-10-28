<?php require_once("config.php"); ?>


<?php

    session_start();
    if(isset($_SESSION['customer'])) {
        if (isset($_GET['add'])) {
            $add = $_GET['add'];

            $query = "SELECT * FROM products WHERE product_id=?";
            $stmt = statement_init();

            statement_confirm($stmt, $query);

            //Bind params
            mysqli_stmt_bind_param($stmt, "s", $add);
            //Run parameters inside db
            statement_execute($stmt);
            $result = statement_result($stmt);

            while ($row = fetch_array($result)) {
                if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {
                    $_SESSION['product_' . $_GET['add']] += 1;
                    $_SESSION['item_quantity']++;
                    if(isset($_GET['id'])) {
                        redirect("../public/item.php?id=" . $_GET['id']);
                    }
                    elseif(isset($_GET['page'])){
                        redirect("../public/index.php");
                    }
                    else{
                        redirect("../public/checkout.php");
                    }
                } else {
                    $row['product_quantity'] == 1 ? set_message("We only have " . $row['product_quantity'] . " " . $row['product_title'] . " available") : set_message("We only have " . $row['product_quantity'] . " " . $row['product_title'] . "'s available");
                    display_error_message(" We only have " . $row['product_quantity'] . " " . $row['product_title'] . "s available");
                    redirect("../public/checkout.php");
                }
            }
        }
    }
    else{
        redirect("../public/login_customer.php");
    }

    if (isset($_GET['remove'])) {
        if ($_SESSION['product_' . $_GET['remove']] < 1) {
            unset($_SESSION['item_total']);
            unset($_SESSION['item_quantity']);
            redirect("../public/checkout.php");
        } else {
            $_SESSION['product_' . $_GET['remove']]--;
            $_SESSION['item_quantity']--;
            redirect("../public/checkout.php");
        }
    }


    if (isset($_GET['delete'])) {

        $_SESSION['product_' . $_GET['delete']] = 0;
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        redirect("../public/checkout.php");
    }

function cart_display()
{

    $total = 0;
    $item_quantity = 0;
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $quantity = 1;
    $productIDArr = array();

    foreach ($_SESSION as $name => $value) {

        if ($value > 0) {
            if (substr($name, 0, 8) == "product_") {

                $length = strlen($name) - 8;

                $id = substr($name, 8, $length);

                $query = "SELECT * FROM products WHERE product_id=?";

                $stmt = statement_init();
                statement_confirm($stmt, $query);

                //Bind params
                mysqli_stmt_bind_param($stmt, "s", $id);
                //Run parameters inside db
                statement_execute($stmt);
                $result = statement_result($stmt);

                while ($row = fetch_array($result)) {

                    $productImage = display_image($row['product_image']);

                    $subTotal = ($row['product_price']) * $value;

                    $item_quantity += $value;

                    $cart_item = <<<DELIMETER

                        <tr>
                            <td colspan="3">{$row['product_title']}<br>
                                <img src="../resources/{$productImage}" style="height: 100px">
                            </td>
                            <td colspan="3">R{$row['product_price']}</td>
                            <td colspan="3">{$value}</td>
                            <!--<td>R{$subTotal}</td>-->
                            <td colspan="3">
                            <div class="row mb-1">
                                <div class="col-12 col-lg-12">
                                    <a class="btn btn-warning btn-sm btn-cart" href="../resources/cart.php?remove={$row['product_id']}"><i class="fas fa-minus"></i></i></a>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-12 col-lg-12">
                                    <a class="btn btn-success btn-sm btn-cart" href="../resources/cart.php?add={$row['product_id']}"><i class="fas fa-plus"></i></i></a>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-12 col-lg-12">
                                    <a class="btn btn-danger btn-sm btn-cart" href="../resources/cart.php?delete={$row['product_id']}"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            </td>
                        </tr>
                        <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                        <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                        <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
                        <input type="hidden" name="quantity_{$quantity}" value="{$item_quantity}">
DELIMETER;
                    array_push($productIDArr, $row['product_id']);

                    echo $cart_item;

                    $item_name++;
                    $item_number++;
                    $amount++;
                    $quantity++;

                    $_SESSION['item_total'] = ($total += $subTotal);
                    $_SESSION['item_quantity'] = $item_quantity;
                }
            }
        }
    }
    $_SESSION['product_ids'] = $productIDArr;
}


function show_paypal()
{

    if (isset($_SESSION['item_quantity']) && $_SESSION['item_quantity'] >= 1) {

        $paypal_btn = <<<DELIMETER
            <input type="image" name="upload"
               src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
               alt="PayPal - The safer, easier way to pay online">
DELIMETER;
        return $paypal_btn;
    }
}

function submit_transaction(){
    if(isset($_POST['process'])){

    }
}


function process_transaction()
{
    if (isset($_GET['tx'])) {

        $amount = $_GET['amt'];
        $currency = $_GET['cc'];
        $transaction_id = $_GET['tx'];
        $status = $_GET['st'];

        $total = 0;
        $item_quantity = 0;

        foreach ($_SESSION as $name => $value) {

            if ($value > 0) {
                if (substr($name, 0, 8) == "product_") {

                    $length = strlen($name) - 8;

                    $id = substr($name, 8, $length);

                    $insertOrder = query("INSERT INTO orders (order_amount, order_transaction_id, order_status, order_currency) VALUES ('{$amount}', '{$transaction_id}', '{$status}', '{$currency}')");
                    confirm($insertOrder);

                    $last_sent_id = get_last_id();

                    $query = query("SELECT * FROM products WHERE product_id=" . escape_string($id) . " ");
                    confirm($query);

                    while ($row = fetch_array($query)) {

                        $subTotal = ($row['product_price']) * $value;

                        $productPrice = $row['product_price'];

                        $productTitle = $row['product_title'];

                        $item_quantity += $value;

                        $total += $subTotal;

                        $insertReport = query("INSERT INTO reports (product_id, order_id, product_title, product_price, product_quantity) VALUES ('{$id}', '{$last_sent_id}' , '{$productTitle}' ,'{$productPrice}', '{$value}'");
                        confirm($insertReport);

                    }
                }
            }
        }
    }
    else {
        redirect("index.php");
    }
    if (isset($_GET['delete'])) {
        $_SESSION['product_' . $_GET['delete']] = 0;
    }
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);
    //session_destroy();
}

?>



