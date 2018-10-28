<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php");?>


<main class="content-wrapper">

<!-- Page Content -->
<div class="container-fluid">

    <div class="bc-icons-2 mb-5">
        <ol class="breadcrumb blue-grey darken-4 text-white">
            <li class="breadcrumb-item"><a class="text-white" href="index.php"><i class="fas fa-home mx-2" aria-hidden="true"></i>Home</a><i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i></li>
            <li class="breadcrumb-item text-white"><a class="text-white" href="checkout.php">Checkout</a><i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i></li>
            <li class="breadcrumb-item text-white">Success</li>
        </ol>
    </div>
    <div class="success-page">
        <h1>Your order has been placed!</h1>
        <p>Your order has been successfully processed.</p>
        <p>You can view your order history by going to the <a class="success-page-link" href="#">my account</a> page and by clicking on history.</p>
        <p>For enquiries, please contact <a href="contact.php" class="success-page-link">us.</a></p>
        <p>Thanks for shopping with us online!</p>
    </div>
 </div><!--Main Content-->
</main>

<?php include(TEMPLATE_FRONT . DS . "footer.php");?>



