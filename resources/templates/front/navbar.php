<!--<nav class="navbar navbar-expand-lg navbar-dark blue-grey darken-4 fixed-top scrolling-navbar">
    <div class="container-fluid">
        <div class="row align-middle" id="navRow">
            <div class="col-lg-2 col-md-2">
                <a class="navbar-brand" href="index.html">
                    <img src="assets/images/logo.png" height="30" width="100%" alt="">
                </a>
            </div>
            <div class="col-lg-6 col-md-6">
                <button class="navbar-toggler float" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav">
                        <!--Future Accounts and Cart
                        <li class="nav-item">
                            <div class="nav-item-wrapper">
                                <a href="URL-HERE" title="Account" target="_blank" rel="nofollow"><i class="fas fa-user fa-2x"></i><p>Account</p></a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="URL-HERE" title="Wishlist" target="_blank" rel="nofollow">
                                    <span class="fas fa-heart fa-2x"></span>
                                    <strong class="fa-stack-2x" id="wishlistItems">
                                        2
                                    </strong>
                                    <p>Wishlist</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="checkout.php" title="Cart" target="_blank" rel="nofollow">
                                <span class="fas fa-shopping-cart fa-2x"></span>
                                <strong class="fa-stack-2x" id="cartItems">
                                    2
                                </strong>
                                <p>Cart</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="input-group md-form form-sm form-1" id="navSearchBar">
                    <input class="form-control nav-search" type="text" placeholder="Search" aria-label="Search">
                    <div class="input-group-append nav-search-submit">
                        <span class="input-group-text lightgrey" id="basic-text1"><i class="fa fa-search text-grey" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>-->

<!-- Navbar -->
<header>
<nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
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
                    <a class="nav-link waves-effect" href="#">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="#">FAQ</a>
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