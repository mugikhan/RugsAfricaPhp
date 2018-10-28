<?php require_once("../resources/config.php"); session_start();?>

<?php include(TEMPLATE_FRONT . DS . "header.php");?>


<main class="content-wrapper">
    <div class="container-fluid">
        <section id="accountPage">
            <div class="row">
                <?php include(TEMPLATE_FRONT . DS . "sidebar.php");?>
                <div class="col-lg-9 col-12">
                    <h2>Edit Account Information</h2>
                    <hr>
                    <h4>Account information</h4>
                    <hr>
                    <!-- Extended material form grid -->
                    <form method="post">
                        <!-- Grid row -->
                        <div class="form-row">
                            <!-- Grid column -->
                            <div class="col-md-6">
                                <!-- Material input -->
                                <div class="md-form form-group">
                                    <input type="text" class="form-control" id="input-first-name">
                                    <label for="input-first-name">First Name</label>
                                </div>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6">
                                <!-- Material input -->
                                <div class="md-form form-group">
                                    <input type="text" class="form-control" id="input-last-name">
                                    <label for="input-last-name">Last Name</label>
                                </div>
                            </div>
                            <!-- Grid column -->
                        </div>
                        <!-- Grid row -->

                        <!-- Grid row -->
                        <div class="form-row">
                            <!-- Grid column -->
                            <div class="col-md-12">
                                <!-- Material input -->
                                <div class="md-form form-group">
                                    <input type="text" class="form-control" id="input-email">
                                    <label for="input-email">Email</label>
                                </div>
                            </div>
                            <!-- Grid column -->
                        </div>
                        <!-- Grid row -->

                        <!-- Grid row -->
                        <div class="form-row">
                            <!-- Grid column -->
                            <div class="col-md-12">
                                <!-- Material input -->
                                <div class="md-form form-group">
                                    <input type="text" class="form-control" id="input-current-password">
                                    <label for="input-current-password">Current Password</label>
                                </div>
                            </div>
                            <!-- Grid column -->
                        </div>
                        <!-- Grid row -->

                        <!-- Grid row -->
                        <div class="form-row">
                            <!-- Grid column -->
                            <div class="col-md-6">
                                <!-- Material input -->
                                <div class="md-form form-group">
                                    <input type="text" class="form-control" id="input-new-password">
                                    <label for="input-new-password">New Password</label>
                                </div>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6">
                                <!-- Material input -->
                                <div class="md-form form-group">
                                    <input type="text" class="form-control" id="input-new-password-confirm">
                                    <label for="input-new-password-confirm">Confirm Password</label>
                                </div>
                            </div>
                            <!-- Grid column -->
                        </div>
                        <!-- Grid row -->
                        <!-- Grid row -->
                        <div class="form-row">
                            <div class="col-lg-2">

                            </div>
                            <div class="col-lg-8 col-lg-offset-2 text-center">
                                <button type="submit" name="submit" class="btn btn-primary btn-md">Save</button>
                            </div>
                        </div>
                        <!-- Grid row -->
                    </form>
                    <!-- Extended material form grid -->
                </div>
            </div>
        </section>
    </div>
</main>

<?php include(TEMPLATE_FRONT . DS . "footer.php");?>