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
                    <h2>Address Book</h2>
                    <hr>
                    <h4>Default Addresses</h4>
                    <hr>
                    <div class="list-group">
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-2 h5">Default Delivery Address</h5>
                            </div>
                            <?php display_addresses() ?>
                        </div>
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-2 h5">Default Billing Address</h5>
                            </div>
                            <?php display_addresses() ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endwhile; ?>
    </div>
</main>

<?php include(TEMPLATE_FRONT . DS . "footer.php");?>