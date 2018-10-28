<?php require_once("../resources/config.php"); session_start();?>

<?php include(TEMPLATE_FRONT . DS . "header.php");?>

<main class="content-wrapper">
    <div class="container-fluid">
        <section id="accountPage">
            <div class="row">
                <?php include(TEMPLATE_FRONT . DS . "sidebar.php");?>
                <div class="col-lg-9 col-12">
                    <h2>My Dashboard</h2>
                    <hr>
                    <h4>My Orders</h4>
                    <hr>
                    <table id="orderTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
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
    </div>
</main>

<?php include(TEMPLATE_FRONT . DS . "footer.php");?>