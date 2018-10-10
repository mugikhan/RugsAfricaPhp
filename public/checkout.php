<?php require_once("../resources/config.php"); ?>
<?php require_once("../resources/cart.php");?>


<?php include(TEMPLATE_FRONT . DS . "header.php");?>
<!-- Page Content -->
<main class="content-wrapper">
<div class="container-fluid">
    <div class="bc-icons-2 mb-5">
        <ol class="breadcrumb blue-grey darken-4 text-white">
            <li class="breadcrumb-item"><a class="text-white" href="index.php"><i class="fas fa-home mx-2" aria-hidden="true"></i>Home</a><i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i></li>
            <li class="breadcrumb-item text-white"><a class="text-white" href="checkout.php">Checkout</a></li>
        </ol>
    </div>
<div class="row">
    <div class="col-lg-12">
        <h1 class="text-center">Checkout</h1>
            <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                  <tr>
                   <th class="th-sm">Product</th>
                   <th class="th-sm">Price</th>
                   <th class="th-sm">Quantity</th>
                  </tr>
                </thead>
                <tbody>
                    <?php cart_display(); ?>
                </tbody>
            </table>
            </div>
            <?php
            //Fetch Customer name and email
            $firstName  = "";
            $lastName  = "";
            $buyerEmail      = "";
            $sessionEmail = $_SESSION['customer'];
            $itemIDs = array();
            $itemNames = "";
            $itemNamesArr = array();

            $query = "SELECT * FROM customers WHERE customer_email=?";
            $stmt = statement_init();

            statement_confirm($stmt, $query);

            //Bind params
            mysqli_stmt_bind_param($stmt, "s", $sessionEmail);
            //Run parameters inside db
            statement_execute($stmt);
            $result = statement_result($stmt);
            while($row = fetch_array($result)){
                $firstName  = $row['customer_first_name'];
                $lastName  = $row['customer_last_name'];
                $buyerEmail = $row['customer_email'];
            }

            //Payfast integration
            if(isset($_SESSION['item_total'])) {
                $cartTotal = $_SESSION['item_total'];// This amount needs to be sourced from your application
            }
            else{
                $cartTotal = 0;
            }
            if(isset($_SESSION['product_ids'])){
                $productIDArr = $_SESSION['product_ids'];
                $arrLen = count($productIDArr);
                for($i = 0; $i < $arrLen; $i++ ){
                    $query = "SELECT * FROM products WHERE product_id=?";
                    $stmt = statement_init();

                    statement_confirm($stmt, $query);

                    //Bind params
                    mysqli_stmt_bind_param($stmt, "s", $productIDArr[$i]);
                    //Run parameters inside db
                    statement_execute($stmt);
                    $result = statement_result($stmt);
                    while($row = fetch_array($result)){
                        $itemNames .= $row['product_title'] . ",";
                    }
                }
            }
            else{
                $productIDArr = null;
            }
            $data = array(
                // Merchant details
                'merchant_id' => '10010228',
                'merchant_key' => 'krfdrtmax3etq',
                'return_url' => 'http://0dc8159d.ngrok.io/RugsAfrica/public/thank_you.php',
                'cancel_url' => 'http://0dc8159d.ngrok.io/RugsAfrica/public/cancel.php',
                'notify_url' => 'http://0dc8159d.ngrok.io/RugsAfrica/public/notify.php?total=' . $cartTotal,
                // Buyer details
                'name_first' => $firstName,
                'name_last'  => $lastName,
                'email_address'=> $buyerEmail,
                // Transaction details
                //'m_payment_id' => '8542', //Unique payment ID to pass through to notify_url
                // Amount needs to be in ZAR
                // If multicurrency system its conversion has to be done before building this array
                'amount' => $cartTotal,
                'item_name' => $itemNames,
                'item_description' => 'Test',
                /*'email_confirmation' => 1,
                'confirmation_address' => 'info@rugsafrica.co.za',*/
            );
            // Create GET string
            $pfOutput = '';
            foreach( $data as $key => $val )
            {
                if(!empty($val))
                {
                    $pfOutput .= $key .'='. urlencode(trim($val)) .'&';
                }
            }
            // Remove last ampersand
            $getString = substr( $pfOutput, 0, -1 );
            //Uncomment the next line and add a passphrase if there is one set on the account
            //$passPhrase = '';
            if( isset( $passPhrase ) )
            {
                $getString .= '&passphrase='. urlencode( trim( $passPhrase ) );
            }
            $data['signature'] = md5( $getString );

            // If in testing mode make use of either sandbox.payfast.co.za or www.payfast.co.za
            $testingMode = true;
            $pfHost = $testingMode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
            $htmlForm = '<form action="https://'.$pfHost.'/eng/process" method="post">';
            foreach($data as $name=> $value)
            {
                $htmlForm .= '<input name="'.$name.'" type="hidden" value="'.$value.'" />';
            }
            $htmlForm .= (isset($_SESSION['item_total']) > 0 ? '<button type="submit" name="process" class="btn btn-lg btn-primary">Buy Now</button></form>' : '</form>');
            echo $htmlForm; ?>
    </div>
</div>



<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">
<tbody>
<tr class="cart-subtotal">
<th>Items:</th>
<td><span class="amount"><?php echo isset($_SESSION['item_quantity']) ? $_SESSION['item_quantity'] : $_SESSION['item_quantity']=0;?></span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount">R<?php echo isset($_SESSION['item_total']) ? $_SESSION['item_total'] : $_SESSION['item_total']=0;?></span></strong> </td>
</tr>


</tbody>

</table>

</div><!-- CART TOTALS-->


 </div><!--Main Content-->
</div>
</main>

    <?php include(TEMPLATE_FRONT . DS . "footer.php");?>

