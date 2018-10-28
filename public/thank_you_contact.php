<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php");?>


<main class="content-wrapper">

<!-- Page Content -->
<div class="container-fluid">
    <div class="bc-icons-2 mb-4">
        <ol class="breadcrumb blue-grey darken-4 text-white">
            <li class="breadcrumb-item"><a class="text-white" href="index.php"><i class="fas fa-home mx-2" aria-hidden="true"></i>Home</a><i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i></li>
            <li class="breadcrumb-item text-white"><a class="text-white" href="contact.php">Contact us</a><i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i></li>
            <li class="breadcrumb-item text-white">Success</li>
        </ol>
    </div>
    <div class="success-page">
        <h1>Thanks for contacting us.</h1>
        <p>This email is checked regularly during business hours (9-5pm). We’ll get back to you as soon as possible, usually within a few hours.</p>
        <p>Until then, make sure to check out the following resources:</p>
        <p><a href="faq.php" class="success-page-link">Frequently Asked Questions</a></p>
        <p><a href="privacy.php" class="success-page-link">Privacy Policy</a></p>
    </div>
 </div><!--Main Content-->
</main>

<?php include(TEMPLATE_FRONT . DS . "footer.php");?>



