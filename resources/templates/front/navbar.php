<!-- Navbar -->
<header>
<nav class="navbar fixed-top navbar-expand-lg navbar-light white">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand waves-effect" href="index.php">
            <img src="assets/images/logo.png" height="30" width="100%" alt="">
        </a>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="faq.php">FAQ</a>
                </li>
            </ul>

            <!-- Right -->
            <ul class="navbar-nav nav-flex-icons">
                <?php
                    display_cart_nav();
                ?>
                <li class="nav-item text-center">
                    <?php if(!isset($_SESSION['customer'])){
                            display_login();
                        }
                        else{
                            display_account();
                            display_logout();
                        }
                    ?>
                </li>
            </ul>

        </div>

    </div>
</nav>
<!-- Navbar -->
</header>