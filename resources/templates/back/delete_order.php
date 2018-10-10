<?php require_once("../../resources/config.php") ?>

<?php
    if(isset($_GET['delete_order_id'])){
        $query = "DELETE FROM orders WHERE order_id=?";
        //confirm($query);
        $orderID = $_GET['delete_order_id'];

        $stmt = statement_init();
        statement_confirm($stmt, $query);

        //Bind params
        mysqli_stmt_bind_param($stmt, "s", $orderID);
        //Run parameters inside db
        statement_execute($stmt);
        //$result = statement_result($stmt);

        set_message("Order with id " . $_GET['delete_order_id'] . " deleted");

        redirect("index.php?orders");
    }
    else{
        redirect("index.php?orders");
    }



?>


