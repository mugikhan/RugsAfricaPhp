<?php require_once("../resources/config.php");?>

<?php include(TEMPLATE_FRONT . DS . "header.php");?>


<main class="content-wrapper">
<div class="container-fluid">

    <!-- Horizontal material form -->
    <div class="card card-login mx-auto text-center">
        <h1 class="text-center">Register</h1>
        <h2><?php display_message(); ?></h2>
        <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <?php register_customer(); ?>
            <!-- Grid row -->
            <div class="row">
                <div class="col-md-2">
                </div>
                <!-- Grid column -->
                <div class="col-md-8 col-md-offset-2">
                    <!-- Material input -->
                    <div class="md-form form-group">
                        <input type="text" class="form-control" id="registerFirstName" name="customer_first_name" required>
                        <label for="registerName">First Name</label>
                    </div>
                </div>
                <!-- Grid column -->
            </div>
            <div class="row">
                <div class="col-md-2">
                </div>
                <!-- Grid column -->
                <div class="col-md-8 col-md-offset-2">
                    <!-- Material input -->
                    <div class="md-form form-group">
                        <input type="text" class="form-control" id="registerLastName" name="customer_last_name" required>
                        <label for="registerName">Last Name</label>
                    </div>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->

            <!-- Grid row -->
            <div class="row">
                <div class="col-md-2">
                </div>
                <!-- Grid column -->
                <div class="col-md-8 col-md-offset-2">
                    <!-- Material input -->
                    <div class="md-form form-group">
                        <input type="email" class="form-control" id="registerEmail" name="customer_email" required>
                        <label for="registerEmail">Email</label>
                    </div>
                </div>
                <!-- Grid column -->
            </div>
            <div class="row">
                <div class="col-md-2">
                </div>
                <!-- Grid column -->
                <div class="col-md-8 col-md-offset-2">
                    <!-- Material input -->
                    <div class="md-form form-group">
                        <input type="password" class="form-control" id="registerPassword" name="customer_password" required>
                        <label for="registerPassword">Password</label>
                    </div>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->

            <!-- Grid row -->
            <div class="row">
                <div class="col-md-2">
                </div>
                <!-- Grid column -->
                <div class="col-md-8 col-md-offset-2">
                    <!-- Material input -->
                    <div class="md-form form-group">
                        <input type="password" class="form-control" id="registerPassword" name="confirm_password" required>
                        <label for="registerPassword">Confirm Password</label>
                    </div>
                </div>
                <!-- Grid column -->
            </div>
            <button type="submit" name="register" class="btn btn-elegant btn-lg">Register</button>
        </form>
    <!-- Extended material form grid -->
</div>
</main>

        <?php include(TEMPLATE_FRONT . DS . "footer.php");?>
