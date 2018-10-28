<?php require_once("../resources/config.php"); session_start();?>

<?php include(TEMPLATE_FRONT . DS . "header.php");?>

<?php

    $accountQuery = "SELECT * FROM customers WHERE customer_email=?";
    $email = $_SESSION['customer'];
    $stmt = statement_init();
    statement_confirm($stmt, $accountQuery);

    //Bind params
    mysqli_stmt_bind_param($stmt, "s", $email);
    //Run parameters inside db
    statement_execute($stmt);
    $result = statement_result($stmt);

    while($row = fetch_array($result)):
?>


<main class="content-wrapper">
    <div class="container-fluid">
        <section id="accountPage">
            <div class="row">
                <?php include(TEMPLATE_FRONT . DS . "sidebar.php");?>
                <div class="col-lg-9 col-12">
                    <h2>My Dashboard</h2>
                    <hr>
                    <p><strong>Hello, <?php echo $row['customer_first_name']?> <?php echo $row['customer_last_name']?></strong></p>
                    <hr>
                    <h4>Recent Orders</h4>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Order #</th>
                            <th scope="col">Date</th>
                            <th scope="col">Information</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php display_orders_account_dashboard(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    <?php endwhile; ?>
    </div>
</main>

<?php include(TEMPLATE_FRONT . DS . "footer.php");?>