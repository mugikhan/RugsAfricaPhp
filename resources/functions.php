<?php
    require_once "config.php";
    $upload_directory = "uploads";
    $paginationDisplay = "";
    $outputPagination = "";
    $emailError = "";

    function set_message($msg){
        if(!empty($msg)){
            $_SESSION['message'] = $msg;
        }
        else{
            $msg = "";
        }
    }

    function display_message(){
        if(isset($_SESSION['message'])){
            $message = <<<DELIMETER
                    <div class="alert alert-danger" role="alert">
                       {$_SESSION['message']}
                    </div>
DELIMETER;
            echo $message;
            unset($_SESSION['message']);
        }
    }

    function display_error_message($msg){
        $message = <<<DELIMETER
                    <div class="alert alert-danger" role="alert">
                       $msg
                    </div>
DELIMETER;
        echo $message;
    }

    function redirect($location){
        header("Location: $location");
        exit();
    }

    function query($sql){

        global $connection;

        return mysqli_query($connection, $sql);
    }

    function confirm($result){
        global $connection;

        if(!$result){
            die("QUERY FAILED" . mysqli_error($connection));
        }
    }

    function escape_string($string){
        global $connection;

        return mysqli_real_escape_string($connection, $string);
    }

    function statement_init(){
        global $connection;

        return mysqli_stmt_init($connection);
    }

    function statement_prepare($stmt, $sql){
        return mysqli_stmt_prepare($stmt, $sql);
    }

    function statement_execute($stmt){
        return mysqli_stmt_execute($stmt);
    }

    function statement_result($stmt){
        return mysqli_stmt_get_result($stmt);
    }

    function statement_confirm($stmt, $query){
        global $connection;

        if(!mysqli_stmt_prepare($stmt, $query)){
            die("QUERY FAILED" . mysqli_error($connection));
        }
    }

    function statement_lastID(){
        global $connection;

        return mysqli_stmt_insert_id($connection);
    }

    function fetch_array($result){
        return mysqli_fetch_array($result);
    }

    function fetch_assoc($result){
        return mysqli_fetch_assoc($result);
    }

    function get_last_id(){
        global $connection;

        return mysqli_insert_id($connection);
    }

    function display_image($image){
        global $upload_directory;
        return $upload_directory . DS . $image;
    }

    //Get Products

    function get_products(){
        global $outputPagination;

        $productQuery =  query("SELECT * FROM products WHERE product_quantity >= 1");

        confirm($productQuery);


        $numRows = mysqli_num_rows($productQuery);

        if(isset($_GET['page'])){
            $page = preg_replace('#[^0-9]#', '', $_GET['page']);
        }
        else{
            $page = 1;
        }

        $perPage = 8;

        $lastPage = ceil($numRows / $perPage);

        if($page < 1){
            $page = 1;
        }
        elseif($page > $lastPage){
            $page = $lastPage;
        }

        $middleNumbers = '';

        $subtractPage1 = $page - 1;
        $subtractPage2 = $page - 2;
        $addPage1 = $page + 1;
        $addPage2 = $page + 2;

        if($page == 1){
            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage1.'">' .$addPage1.'</a></li>';
        }
        elseif ($page == $lastPage){
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage1.'">' .$subtractPage1.'</a></li>';

            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';
        }
        elseif($page > 2 && $page < ($lastPage - 1)){
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage2.'">' .$subtractPage2.'</a></li>';

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage1.'">' .$subtractPage1.'</a></li>';

            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage1.'">' .$addPage1.'</a></li>';

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage2.'">' .$addPage2.'</a></li>';
        }
        elseif ($page > 1 && $page < $lastPage){
            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage1.'">' .$subtractPage1.'</a></li>';

            $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';

            $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage1.'">' .$addPage1.'</a></li>';
        }

        $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;

        $productQuery2 =  query("SELECT * FROM products WHERE product_quantity >= 1 $limit");

        confirm($productQuery2);


        if($page != 1){
            $prev = $page - 1;

            //$outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$prev.'">Back</a></li>';
            $outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
        }

        $outputPagination .= $middleNumbers;

        if($page != $lastPage){
            $next = $page + 1;

            //$outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$next.'">Next</a></li>';
            $outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
        }

        while($row = fetch_array($productQuery2)){

            $productImage = display_image($row['product_image']);

            $product =
<<<DELIMETER
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card">
                      <!--Card image-->
                      <div class="view overlay card-img-top">
                        <img src="../resources/$productImage" class="card-img-top" alt="">
                        <a href="item.php?id={$row['product_id']}">
                          <div class="mask rgba-white-slight"></div>
                        </a>
                      </div>
                      <!--Card image-->
        
                      <!--Card content-->
                      <div class="card-body text-center">
                        <!--Category & Title-->
                        <h5>
                          <strong>
                            <a href="item.php?id={$row['product_id']}" class="dark-grey-text">{$row['product_title']}
                              <span class="badge badge-pill danger-color">NEW</span>
                            </a>
                          </strong>
                        </h5>
                        <h4 class="font-weight-bold blue-text">
                          <strong>R{$row['product_price']}</strong>
                        </h4>
                        <a href="../resources/cart.php?add={$row['product_id']}&page=home" class="btn btn-primary addToCart-btn">Add To Cart
                            <i class="fas fa-shopping-cart ml-1"></i>
                        </a>
                      </div>
                      <!--Card content-->
                    </div>
                    <!--Card-->
                </div>
DELIMETER;

            echo $product;
        }
    }

    function display_pagination(){
        global $outputPagination, $paginationDisplay;
        $paginationDisplay = <<<DELIMETER
            <nav class="pagination d-flex justify-content-center wow fadeIn"><ul class='pagination pagination-lg pg-blue'>{$outputPagination}</ul></nav>
DELIMETER;
        echo $paginationDisplay;
    }

    //Get Categories

    function get_categories(){
        $categoryQuery = query("SELECT * FROM categories");
        confirm($categoryQuery);

        while($row = fetch_array($categoryQuery)){
            $categories =
<<<DELIMETER
                    <li class="nav-item">
                      <a href="category.php?id={$row['cat_id']}" class="nav-link waves-effect waves-light">{$row['cat_title']}</a>
                    </li>
DELIMETER;

            echo $categories;

        }
    }

//When a category is clicked
function get_specific_products(){
    $productQuery =  "SELECT * FROM products WHERE product_category_id =? AND product_quantity >= 1";
    $stmt = statement_init();
    $productCatID = $_GET['id'];

    statement_confirm($stmt, $productQuery);

    //Bind params
    mysqli_stmt_bind_param($stmt, "s", $productCatID);
    //Run parameters inside db
    statement_execute($stmt);
    $result = statement_result($stmt);
    while($row = fetch_array($result)) {

        $productImage = display_image($row['product_image']);

        $product =
            <<<DELIMETER
        
            <div class="col-sm-4 col-lg-4 col-md-4">
                <div class="thumbnail">
                    <a href="item.php?id={$row['product_id']}">
                        <img src="../resources/{$productImage}" alt="">
                    </a>
                    <div class="caption">
                        <h4 class="pull-right">R{$row['product_price']}</h4>
                        <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                        </h4>
                        <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                        <div class="buy-btn">
                            <a class="btn btn-primary" href="../resources/cart.php?add={$row['product_id']}">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
DELIMETER;

        echo $product;
    }

}


function get_specific_products_shop(){
    global $outputPagination;

    $productQuery =  query("SELECT * FROM products");

    confirm($productQuery);

    $numRows = mysqli_num_rows($productQuery);

    if(isset($_GET['page'])){
        $page = preg_replace('#[^0-9]#', '', $_GET['page']);
    }
    else{
        $page = 1;
    }

    $perPage = 8;

    $lastPage = ceil($numRows / $perPage);

    if($page < 1){
        $page = 1;
    }
    elseif($page > $lastPage){
        $page = $lastPage;
    }

    $middleNumbers = '';

    $subtractPage1 = $page - 1;
    $subtractPage2 = $page - 2;
    $addPage1 = $page + 1;
    $addPage2 = $page + 2;

    if($page == 1){
        $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';

        $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage1.'">' .$addPage1.'</a></li>';
    }
    elseif ($page == $lastPage){
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage1.'">' .$subtractPage1.'</a></li>';

        $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';
    }
    elseif($page > 2 && $page < ($lastPage - 1)){
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage2.'">' .$subtractPage2.'</a></li>';

        $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage1.'">' .$subtractPage1.'</a></li>';

        $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';

        $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage1.'">' .$addPage1.'</a></li>';

        $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage2.'">' .$addPage2.'</a></li>';
    }
    elseif ($page > 1 && $page < $lastPage){
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage1.'">' .$subtractPage1.'</a></li>';

        $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';

        $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage1.'">' .$addPage1.'</a></li>';
    }

    $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;

    $productQuery2 =  query("SELECT * FROM products $limit");

    confirm($productQuery2);


    if($page != 1){
        $prev = $page - 1;

        //$outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$prev.'">Back</a></li>';
        $outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
    }

    $outputPagination .= $middleNumbers;

    if($page != $lastPage){
        $next = $page + 1;

        //$outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$next.'">Next</a></li>';
        $outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
    }

    while($row = fetch_array($productQuery2)){

        $productImage = display_image($row['product_image']);

        $product =
            <<<DELIMETER
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card">
                      <!--Card image-->
                      <div class="view overlay card-img-top">
                        <img src="../resources/$productImage" class="card-img-top" alt="">
                        <a href="item.php?id={$row['product_id']}">
                          <div class="mask rgba-white-slight"></div>
                        </a>
                      </div>
                      <!--Card image-->
        
                      <!--Card content-->
                      <div class="card-body text-center">
                        <!--Category & Title-->
                        <h5>
                          <strong>
                            <a href="item.php?id={$row['product_id']}" class="dark-grey-text">{$row['product_title']}
                              <span class="badge badge-pill danger-color">NEW</span>
                            </a>
                          </strong>
                        </h5>
                        <h4 class="font-weight-bold blue-text">
                          <strong>R{$row['product_price']}</strong>
                        </h4>
                      </div>
                      <!--Card content-->
                    </div>
                    <!--Card-->
                </div>
DELIMETER;

        echo $product;
    }
}


    function admin_login(){
            if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $password = $_POST['password'];

                $query = "SELECT * FROM users WHERE user_name=? AND user_password=?";
                $stmt = statement_init();
                statement_confirm($stmt, $query);

                //Bind params
                mysqli_stmt_bind_param($stmt, "ss", $username, $password);
                //Run parameters inside db
                statement_execute($stmt);
                $result = statement_result($stmt);

                if(mysqli_num_rows($result) == 0){
                    set_message("Your password or username was incorrect");
                    redirect("login.php");
                }
                else{
                    session_start();
                    $_SESSION['username'] = $username;
                    redirect("admin");
                }
            }
    }

    //Backend helper functions/////////////////////////////

    function show_product_category($productCategoryID){
        //$categoryQuery = query("SELECT * FROM categories WHERE cat_id={$productCategoryID}");
        //confirm($categoryQuery);

        $categoryQuery = "SELECT * FROM categories WHERE cat_id=?";
        $stmt = statement_init();
        statement_confirm($stmt, $categoryQuery);

        //Bind params
        mysqli_stmt_bind_param($stmt, "s", $productCategoryID);
        //Run parameters inside db
        statement_execute($stmt);
        $result = statement_result($stmt);

        while($categoryRow = fetch_assoc($result)){
            return $categoryRow['cat_title'];
        }
    }




    ////////////////////////////////////////////////////////////////////////////////////////////////////////////Backend/Admin Functions/////////////////////////////////////////////////////////////////////////////////

    function display_orders(){
        $orderQuery =  query("SELECT * FROM orders");

        confirm($orderQuery);

        while($row = fetch_array($orderQuery)){
            $orders =
                <<<DELIMETER
                    <tr>
                        <td>{$row['order_id']}</td>
                        <td>R{$row['order_amount']}</td>
                        <td>{$row['order_transaction_id']}</td>
                        <td>{$row['order_status']}</td>
                        <td>{$row['order_currency']}</td>
                        <td><a class="btn btn-danger" href="index.php?delete_order_id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
                   </tr>
DELIMETER;

            echo $orders;
        }
    }

    function display_products(){
        $productQuery =  query("SELECT * FROM products");

        confirm($productQuery);

        while($row = fetch_array($productQuery)){
            $categoryTitle = show_product_category($row['product_category_id']);

            $productImage = display_image($row['product_image']);

            $products =
                <<<DELIMETER
                        <tr>
                            <td>{$row['product_id']}</td>
                            <td>{$row['product_title']}<br>
                            <a href="index.php?edit_product&id={$row['product_id']}">
                                <img src="../../resources/{$productImage}" alt="" style="width: 60px; height: 60px">
                            </a>
                            </td>
                            <td>{$categoryTitle}</td>
                            <td>R{$row['product_price']}</td>
                            <td>{$row['product_quantity']}</td>
                            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>
DELIMETER;

        echo $products;
    }
}

    function add_product(){
        if(isset($_POST['publish'])){
            $productTitle = $_POST['product_title'];
            $productCatID = $_POST['product_category_id'];
            $productPrice = $_POST['product_price'];
            $productQuantity = $_POST['product_quantity'];
            $productDesc = $_POST['product_desc'];
            $productShortDesc = $_POST['product_short_desc'];
            $productImage = $_FILES['file']['name'];
            $tempImage = $_FILES['file']['tmp_name']; //No need to escape this string. Because it is made by PHP as a temp file that exists on the server
            move_uploaded_file($tempImage, UPLOAD_DIR . DS . $productImage);

            //if($productCatID != "default") {
            //$query = query("INSERT INTO products (product_title, product_category_id, product_price, product_quantity, product_desc, product_short_desc, product_image) VALUES ('{$productTitle}', '{$productCatID}', '{$productPrice}', '{$productQuantity}', '{$productDesc}', '{$productShortDesc}', '{$productImage}')");

            //confirm($query);
            $query = "INSERT INTO products (product_title, product_category_id, product_price, product_quantity, product_desc, product_short_desc, product_image) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = statement_init();

            statement_confirm($stmt, $query);
            //Bind params
            mysqli_stmt_bind_param($stmt, "sidisss", $productTitle, $productCatID, $productPrice, $productQuantity, $productDesc, $productShortDesc, $productImage);
            //Run parameters inside db
            statement_execute($stmt);
            set_message("Successfully added a product with name {$productTitle}");
            redirect("index.php?products");
            //}
        }
    }


    function show_categories_admin(){
        $categoryQuery = query("SELECT * FROM categories");
        confirm($categoryQuery);

        while($row = fetch_array($categoryQuery)){
            $categories =
                <<<DELIMETER
                    <option value="{$row['cat_id']}">{$row['cat_title']}</option>
DELIMETER;

            echo $categories;

        }
}

    function edit_product(){
        if(isset($_POST['update'])){
            $productTitle = $_POST['product_title'];
            $productCatID = $_POST['product_category_id'];
            $productPrice = $_POST['product_price'];
            $productQuantity = $_POST['product_quantity'];
            $productDesc = $_POST['product_desc'];
            $productShortDesc = $_POST['product_short_desc'];
            $productImage = $_FILES['file']['name'];
            $tempImage = $_FILES['file']['tmp_name']; //No need to escape this string. Because it is made by PHP as a temp file that exists on the server

            if(empty($productImage)){
                //$getPicQuery = query("SELECT product_image FROM products WHERE product_id= " . escape_string($_GET['id']) . " ");
                //confirm($getPicQuery);
                $getPicQuery = "SELECT product_image FROM products WHERE product_id=?";
                $stmt = statement_init();
                $productID = $_GET['id'];

                statement_confirm($stmt, $getPicQuery);

                //Bind params
                mysqli_stmt_bind_param($stmt, "s", $productID);
                //Run parameters inside db
                statement_execute($stmt);
                $result = statement_result($stmt);

                while($pic = fetch_assoc($result)){
                    $productImage = $pic['product_image'];
                }
            }
            move_uploaded_file($tempImage, UPLOAD_DIR . DS . $productImage);

            //if($productCatID != "default") {
            $updateQuery = "UPDATE products SET ";
            $updateQuery .= "product_title=?, ";
            $updateQuery .= "product_category_id=?, ";
            $updateQuery .= "product_price=?, ";
            $updateQuery .= "product_quantity=?, ";
            $updateQuery .= "product_desc=?, ";
            $updateQuery .= "product_short_desc=?, ";
            $updateQuery .= "product_image=? ";
            //$updateQuery .= "WHERE product_id =" . escape_string($_GET['id']);
            $updateQuery .= "WHERE product_id=?";
            //$send_update_query = query($updateQuery);
            //confirm($send_update_query);
            $stmt = statement_init();
            $productID = $_GET['id'];

            statement_confirm($stmt, $updateQuery);

            //Bind params
            mysqli_stmt_bind_param($stmt, "sidissss", $productTitle, $productCatID, $productPrice, $productQuantity, $productDesc, $productShortDesc, $productImage, $productID);
            //Run parameters inside db
            statement_execute($stmt);
            $result = statement_result($stmt);
            set_message("Successfully updated product with id " . $productID);
            redirect("index.php?products");
            //}
        }
    }


    //Categories in admin

    function display_categories_admin(){
        $categoryQuery = query("SELECT * FROM categories");
        confirm($categoryQuery);

        while($row = fetch_array($categoryQuery)){
            $catID = $row['cat_id'];
            $catTitle = $row['cat_title'];

            $category = <<<DELIMETER
            <tr>
                <td>{$catID}</td>
                <td>{$catTitle}</td>
                <td><a class="btn btn-danger" href="../../resources/templates/back/delete_category.php?id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>
DELIMETER;
            echo $category;
        }
    }

    function add_category(){
        if(isset($_POST['add_category'])){
            //$catTitle = escape_string($_POST['cat_title']);
            $catTitle = $_POST{'cat_title'};

            if(empty($catTitle) || $catTitle == " "){
                echo "Please enter a value";
            }
            else {

                //$query = query("INSERT INTO categories (cat_title) VALUES('{$catTitle}')");
                $query = "INSERT INTO categories (cat_title) VALUES (?)";
                //confirm($query);
                $stmt = statement_init();

                statement_confirm($stmt, $query);

                //Bind params
                mysqli_stmt_bind_param($stmt, "s", $catTitle);
                //Run parameters inside db
                statement_execute($stmt);
                $result = statement_result($stmt);

                set_message("Category with title " . $catTitle . " created");
            }
        }
    }


    //Users in admin

    function display_users() {

        $user_query = query("SELECT * FROM users");
        confirm($user_query);

        while($row = fetch_array($user_query)) {

            $user_id = $row['user_id'];
            $username = $row['user_name'];
            $email = $row['user_email'];
            $password = $row['user_password'];

            $user = <<<DELIMETER
                <tr>
                    <td>{$user_id}</td>
                    <td>{$username}</td>
                     <td>{$email}</td>
                    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$row['user_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
DELIMETER;
            echo $user;
        }
    }


    function add_user() {
        if(isset($_POST['add_user'])) {
            /*$username   = escape_string($_POST['username']);
            $email      = escape_string($_POST['email']);
            $password   = escape_string($_POST['password']);*/
            $username   = $_POST['username'];
            $email      = $_POST['email'];
            $password   = $_POST['password'];
            // $user_photo = escape_string($_FILES['file']['name']);
            // $photo_temp = escape_string($_FILES['file']['tmp_name']);


            // move_uploaded_file($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo);


            //$query = query("INSERT INTO users(user_name, user_email, user_password) VALUES('{$username}','{$email}','{$password}')");
            //confirm($query);
            $query = "INSERT INTO users(user_name, user_email, user_password) VALUES(?, ?, ?)";
            $stmt = statement_init();

            statement_confirm($stmt, $query);

            //Bind params
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
            //Run parameters inside db
            statement_execute($stmt);

            set_message("USER CREATED");

            redirect("index.php?users");
        }
    }


    //Reports in admin
    function get_reports(){

        $query = query(" SELECT * FROM reports");
        confirm($query);

        while($row = fetch_array($query)) {

            $report = <<<DELIMETER
    
            <tr>
                 <td>{$row['report_id']}</td>
                <td>{$row['product_id']}</td>
                <td>{$row['order_id']}</td>
                <td>{$row['product_price']}</td>
                <td>{$row['product_title']}
                <td>{$row['product_quantity']}</td>
                <td><a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>

DELIMETER;

        echo $report;
    }
}



    //////////////////////////////CUSTOMER REGISTER//////////////////////////////////

    function register_customer(){
        global $emailError;
        if(isset($_POST['register'])){

            $customerFirstName = $_POST['customer_first_name'];
            $customerLastName = $_POST['customer_last_name'];
            $customerEmail = $_POST['customer_email'];
            $customerPassword = $_POST['customer_password'];
            $customerConfirmPass = $_POST['confirm_password'];
            if(!preg_match("/[a-z\s]/i",$customerFirstName) || !preg_match("/[a-z\s]/i",$customerLastName)){
                display_error_message("Please enter a valid first and last name");
            }
            if(!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)){
                display_error_message("Please enter a valid email");
            }
            if($customerPassword === $customerConfirmPass) {

                list($salt, $hashedPass) = create_hash($customerPassword);

                $query = "INSERT INTO customers (customer_first_name, customer_last_name, customer_email, customer_password, customer_salt) VALUES (?, ?, ?, ?, ?)";
                $stmt = statement_init();

                statement_confirm($stmt, $query);

                //Bind params
                mysqli_stmt_bind_param($stmt, "sssss", $customerFirstName, $customerLastName, $customerEmail, $hashedPass, $salt);
                //Run parameters inside db
                statement_execute($stmt);
                $result = statement_result($stmt);
                redirect("index.php");
            }
            else{
                display_error_message("Please make sure your passwords match");
                //redirect("register.php");
            }
        }
    }

    function user_login(){
        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $hashedPass = "";
            $storedSalt = "";

            $hashQuery = "SELECT * FROM customers WHERE customer_email=?";
            $stmt = statement_init();
            statement_confirm($stmt, $hashQuery);

            //Bind params
            mysqli_stmt_bind_param($stmt, "s", $email);
            //Run parameters inside db
            statement_execute($stmt);
            $result = statement_result($stmt);

            while($row = fetch_array($result)){
                $hashedPass = $row['customer_password'];
                $storedSalt = $row['customer_salt'];

            }
            $hashCheck = verify_hash($password, $hashedPass, $storedSalt);

            if(!$hashCheck){
                set_message("Your password or username was incorrect");
                redirect("login_customer.php");
            }
            else{
                session_start();
                if(!isset($_SESSION['customer'])) {
                    $_SESSION['customer'] = $email;
                }
                redirect("../public/index.php");
            }
        }
    }

    function get_specific_products_search(){
        global $outputPagination;
        if(isset($_POST['search'])){
            if(preg_match("/^[  a-zA-Z]+/", $_POST['query'])){
                $query = $_POST['query'];
                $query = escape_string($query);
                $sql = query("SELECT * FROM products WHERE product_title LIKE '%" . $query .  "%'");
                confirm($sql);
                if(mysqli_num_rows($sql) > 0){

                $numRows = mysqli_num_rows($sql);

                if(isset($_GET['page'])){
                    $page = preg_replace('#[^0-9]#', '', $_GET['page']);
                }
                else{
                    $page = 1;
                }

                $perPage = 8;

                $lastPage = ceil($numRows / $perPage);

                if($page < 1){
                    $page = 1;
                }
                elseif($page > $lastPage){
                    $page = $lastPage;
                }

                $middleNumbers = '';

                $subtractPage1 = $page - 1;
                $subtractPage2 = $page - 2;
                $addPage1 = $page + 1;
                $addPage2 = $page + 2;

                if($page == 1){
                    $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';

                    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage1.'">' .$addPage1.'</a></li>';
                }
                elseif ($page == $lastPage){
                    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage1.'">' .$subtractPage1.'</a></li>';

                    $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';
                }
                elseif($page > 2 && $page < ($lastPage - 1)){
                    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage2.'">' .$subtractPage2.'</a></li>';

                    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage1.'">' .$subtractPage1.'</a></li>';

                    $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';

                    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage1.'">' .$addPage1.'</a></li>';

                    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage2.'">' .$addPage2.'</a></li>';
                }
                elseif ($page > 1 && $page < $lastPage){
                    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$subtractPage1.'">' .$subtractPage1.'</a></li>';

                    $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page.'</a></li>';

                    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$addPage1.'">' .$addPage1.'</a></li>';
                }

                $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;

                //$productQuery2 =  query("SELECT * FROM products WHERE product_title LIKE '%" . $query .  "%' $limit");
                $productQuery2 =  query("SELECT * FROM products WHERE MATCH(product_title) AGAINST('+product') $limit");

                confirm($productQuery2);

                if($page != 1){
                    $prev = $page - 1;

                    $outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
                }

                $outputPagination .= $middleNumbers;

                if($page != $lastPage){
                    $next = $page + 1;

                    $outputPagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$next.'" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
                }

                while($row = fetch_array($productQuery2)) {
                    $productImage = display_image($row['product_image']);

                    $product =
                            <<<DELIMETER
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card">
                      <!--Card image-->
                      <div class="view overlay card-img-top">
                        <img src="../resources/$productImage" class="card-img-top" alt="">
                        <a href="item.php?id={$row['product_id']}">
                          <div class="mask rgba-white-slight"></div>
                        </a>
                      </div>
                      <!--Card image-->
        
                      <!--Card content-->
                      <div class="card-body text-center">
                        <!--Category & Title-->
                        <h5>
                          <strong>
                            <a href="item.php?id={$row['product_id']}" class="dark-grey-text">{$row['product_title']}
                              <span class="badge badge-pill danger-color">NEW</span>
                            </a>
                          </strong>
                        </h5>
                        <h4 class="font-weight-bold blue-text">
                          <strong>R{$row['product_price']}</strong>
                        </h4>
                      </div>
                      <!--Card content-->
                    </div>
                    <!--Card-->
                </div>
DELIMETER;

                    echo $product;
                    }
                }
            }
            else{
                set_message("Please enter a value");
            }
        }
    }

    function display_cart_nav(){
        if(isset($_SESSION['customer']) && isset($_SESSION['item_quantity'])) {
            $cartNum = $_SESSION['item_quantity'];
        }
        else{
            $cartNum = 0;
        }
        $cartIcon =
<<<DELIMETER
            <li class="nav-item" id="cartLink">
                <a class="nav-link waves-effect" href="checkout.php">
                    <!--<span class="badge red mr-1">
                    </span>
                    <i class="fa fa-shopping-cart"></i>
                    <span class="clearfix d-none d-sm-inline-block">Cart</span>-->
                    <span class="fa-layers fa-fw">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                        <span class="fa-layers-text fa-inverse" data-fa-transform="shrink-1 right-12 up-3">$cartNum</span>
                  </span>
                </a>
            </li>
DELIMETER;
        echo $cartIcon;
    }


    function display_login(){
            $login_register = <<<DELIMETER
                <a class="btn btn-outline-elegant btn-sm" href="login_customer.php">Login</a>
                <a class="btn btn-outline-elegant btn-sm" href="register.php">Register</a>
DELIMETER;
            echo $login_register;
    }

    function display_logout(){
        $logout = <<<DELIMETER
                <a class="btn btn-outline-elegant btn-sm" href="logout_customer.php">Logout</a>
DELIMETER;

        echo $logout;
    }

    function display_account(){
        $account = <<<DELIMETER
                <a href="account.php" class="nav-link">
                    <i class="fas fa-user mr-2"></i>My Account<br>
                </a>
DELIMETER;

        echo $account;
    }

    ////////////////////////////////////////////////////////////ACCOUNT MANAGER/////////////////////////////////////

    function display_orders_account_dashboard(){
        $orderQuery = "SELECT * FROM orders WHERE order_email=? LIMIT 10";
        $email = $_SESSION['customer'];
        $stmt = statement_init();
        statement_confirm($stmt, $orderQuery);

        //Bind params
        mysqli_stmt_bind_param($stmt, "s", $email);
        //Run parameters inside db
        statement_execute($stmt);
        $result = statement_result($stmt);

        while($row = fetch_array($result)){
            $orders = <<<DELIMETER
                <tr>
                    <td>{$row['order_payment_id']}</td>
                    <td>{$row['order_date']}</td>
                    <td><div class="row">
                            <div class="col-12 col-lg-12">
                                <strong>Order Total: R{$row['order_amount_gross']}</strong>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <strong>Payment Status: {$row['order_payment_status']}</strong>
                            </div>
                        </div>
                    </td>
                </tr>
DELIMETER;
            echo $orders;
        }
    }

    function display_addresses(){
        $addressQuery = "SELECT * FROM addresses WHERE address_cust_email=?";
        $email = $_SESSION['customer'];
        $stmt = statement_init();
        statement_confirm($stmt, $addressQuery);

        //Bind params
        mysqli_stmt_bind_param($stmt, "s", $email);
        //Run parameters inside db
        statement_execute($stmt);
        $result = statement_result($stmt);

        while($row = fetch_array($result)){
            $addresses = <<<DELIMETER
                <p>
                    {$row['address_street']}<br>
                    {$row['address_suburb']}<br>
                    {$row['address_city']}<br>
                    {$row['address_province']}<br>
                    {$row['address_postal_code']}<br>
                    {$row['address_country']}
                </p>
DELIMETER;
            echo $addresses;
        }
    }

    function display_orders_account(){
        if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
            $startrow = 0;
        } else {
            $startrow = (int)$_GET['startrow'];
        }
        $orderQuery = "SELECT * FROM orders WHERE order_email=?";
        $email = $_SESSION['customer'];
        $stmt = statement_init();
        statement_confirm($stmt, $orderQuery);

        //Bind params
        mysqli_stmt_bind_param($stmt, "s", $email);
        //Run parameters inside db
        statement_execute($stmt);
        $result = statement_result($stmt);

        while($row = fetch_array($result)){
            $orders = <<<DELIMETER
                <tr>
                    <td>{$row['order_payment_id']}</td>
                    <td>{$row['order_date']}</td>
                    <td><div class="row">
                            <div class="col-12 col-lg-12">
                                <strong>Order Total: R{$row['order_amount_gross']}</strong>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <strong>Payment Status: {$row['order_payment_status']}</strong>
                            </div>
                        </div>
                    </td>
                </tr>
DELIMETER;
            echo $orders;
        }
    }

    //////////////////////////////////////////////////////////////////Hash functions/////////////////////////////////////////////////////////////////////////////////

    function create_hash($password){
        if(!is_string($password)){
            throw new InvalidArgumentException("create_hash(): Expected a string");
        }

        $saltBytes = 12;

        $salt_raw = openssl_random_pseudo_bytes($saltBytes);
        $salt = bin2hex($salt_raw);

        $newPassword = $salt . $password;

        $hash = hash( "sha512" ,$newPassword);

        return array($salt, $hash);
    }

    function verify_hash($password, $hashedPass, $salt){
        if (!is_string($password) || !is_string($hashedPass) || !is_string($hashedPass)) {
            throw new InvalidArgumentException(
                "verify_password(): Expected two strings"
            );
        }

        $newPassword = $salt . $password;

        $hash = hash( "sha512" ,$newPassword);


        if($hash === $hashedPass){
            return true;
        }
        else
            return false;
    }
?>