<?php require_once("../resources/config.php"); session_start();?>

<?php include(TEMPLATE_FRONT . DS . "header.php");?>



<main>
    <div class="container-fluid">
        <?php include(TEMPLATE_FRONT . DS . "slideshow.php");?>
        <?php include(TEMPLATE_FRONT . DS . "categories.php");?>
        <section class="text-center mb-4">
            <div class="col-lg-12 col-12">
                <div class="row wow fadeIn">
                    <?php get_specific_products_shop(); ?>
                </div>
            </div>
        </section>
        <!--Pagination-->
        <?php display_pagination(); ?>
        <!--Pagination-->
    </div>
</main>
<?php include(TEMPLATE_FRONT . DS . "footer.php");?>

<!-- /.container -->
