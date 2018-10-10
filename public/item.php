<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php");?>

    <!-- Page Content -->
<div class="container-fluid">

    <?php

        $itemQuery = "SELECT * FROM products WHERE product_id=?";
        $id = $_GET['id'];
        $stmt = statement_init();
        statement_confirm($stmt, $itemQuery);

        //Bind params
        mysqli_stmt_bind_param($stmt, "s", $id);
        //Run parameters inside db
        statement_execute($stmt);
        $result = statement_result($stmt);

        while($row = fetch_array($result)):

    ?>
<section class="pt-4">
    <div class="container-fluid dark-grey-text mt-5">

        <!--Grid row-->
        <div class="row wow fadeIn">

            <!--Grid column-->
            <div class="col-md-6 mb-4">

                <img src="../resources/<?php echo display_image($row['product_image']);?>" class="img-fluid" alt="">

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-6 mb-4">

                <!--Content-->
                <div class="p-4">

                    <div class="mb-3">
                        <a href="">
                            <span class="badge purple mr-1"><?php echo show_product_category($row['product_category_id']) ?></span>
                        </a>
                        <a href="">
                            <span class="badge blue mr-1">New</span>
                        </a>
                        <a href="">
                            <span class="badge red mr-1">Bestseller</span>
                        </a>
                    </div>
                    <h4><?php echo $row['product_title'] ?></h4>

                    <p class="lead">
                        <span class="mr-1">
                            <del>RXXX</del>
                        </span>
                        <span>R<?php echo $row['product_price'] ?></span>
                    </p>

                    <p class="lead font-weight-bold">Description</p>

                    <p><?php echo $row['product_desc'] ?></p>

                    <form class="d-flex justify-content-center align-items-center">
                        <!-- Default input -->
                        <input type="number" value="1" aria-label="Search" class="form-control" style="width: 100px">
                        <a href="../resources/cart.php?add=<?php echo $row['product_id']; ?>&amp;id=<?php echo $_GET['id']; ?>" class="btn btn-primary addToCart-btn">Add To Cart
                            <i class="fas fa-shopping-cart ml-1"></i>
                        </a>

                    </form>

                </div>
                <!--Content-->

            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->
</div>
</section>

    <?php endwhile; ?>

</div>
<?php include(TEMPLATE_FRONT . DS . "footer.php");?>
