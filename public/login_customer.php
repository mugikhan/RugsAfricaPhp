<?php require_once("../resources/config.php");?>

<?php include(TEMPLATE_FRONT . DS . "header.php");?>


    <main class="content-wrapper">
    <!-- Page Content -->
    <div class="container-fluid">
        <h2><?php display_message(); ?></h2>
        <!-- Horizontal material form -->
        <div class="card card-login mx-auto text-center">
            <h1 class="text-center">Login</h1>
            <div class="card-body">
            <form method="post">
                <?php user_login(); ?>
                <!-- Grid row -->
                <div class="form-group row">
                    <!-- Material input -->
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="md-form mt-0">
                            <input type="email" name="email" class="form-control" id="loginEmail" required>
                            <label for="loginEmail">Email</label>
                        </div>
                    </div>
                </div>
                <!-- Grid row -->

                <!-- Grid row -->
                <div class="form-group row">
                    <!-- Material input -->
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="md-form mt-0">
                            <input type="password" name="password" class="form-control" id="loginPassword" required>
                            <label for="loginPassword">Password</label>
                        </div>
                    </div>
                </div>
                <!-- Grid row -->

                <!-- Grid row -->
                <div class="form-group row">
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-8 col-sm-offset-2">
                        <button type="submit" name="submit" class="btn btn-primary btn-md">Sign in</button>
                    </div>
                </div>
                <!-- Grid row -->
                <div class="form-group row">
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-8 col-sm-offset-2">
                        OR
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-8 col-sm-offset-2">
                        <a href="register.php" class="btn btn-sm btn-elegant">Register Here</a>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-8 col-sm-offset-2">
                        OR
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-8 col-sm-offset-2">
                        <a href="register.php" class="btn btn-sm btn-elegant">Forgotten Password</a>
                    </div>
                </div>
            </form>
        <!-- Horizontal material form -->
        </div>

        </div>

    </div>
    <!-- /.container -->
    </main>

<?php include(TEMPLATE_FRONT . DS . "footer.php");?>
