<?php
/** Copyright (c) 2017 PayFast (Pty) Ltd You (being anyone who is not PayFast (Pty) Ltd) may download
 * and use this code for testing purposes, in conjunction with a registered and active PayFast account.
 * If your PayFast account is terminated for any reason, you may not use this code or part thereof.
 * Except as expressly indicated in this licence, you may not use, copy, modify or distribute this
 * code or part thereof in any way.
 */

// This is the Notify page (a.k.a. Callback page or ITN page) which does all the ‘heavy lifting’
// with regards to updating your database with payment information etc.

require( 'payfast_common.inc' );
require ('../resources/config.php');

// Notify PayFast that information has been received
pflog( 'PayFast ITN call received' );

// Variable Initialization
$pfError = false;
$pfErrMsg = '';
$pfDone = false;
$pfData = array();
$pfHost = 'sandbox.payfast.co.za';
$pfOrderId = '';
$pfParamString = '';

// Check the header response
if( !$pfError && !$pfDone )
{
    header( 'HTTP/1.0 200 OK' );
    flush();
}

// Get data sent by PayFast
pflog( 'Get posted data' );

// Posted variables from ITN
$pfData = pfGetData();

pflog( 'PayFast Data: '. print_r( $pfData, true ) );

if( $pfData === false )
{
    $pfError = true;
    $pfErrMsg = PF_ERR_BAD_ACCESS;
}

// Strip any slashes in data
foreach($pfData as $key => $val)
{
    $pfData[$key] = stripslashes( $val );
}

//// Verify security signature
if( !$pfError && !$pfDone )
{
    pflog( 'Verify security signature' );

    $pfPassPhrase = ''; // Set your passphrase here

    // If signature different, log for debugging
    if( !pfValidSignature( $pfData, $pfParamString, $pfPassPhrase ) )
    {
        $pfError = true;
        $pfErrMsg = PF_ERR_INVALID_SIGNATURE;
    }
}

//// Verify source IP (If not in debug mode)
/// Check this on online deployment
/*if( !$pfError && !$pfDone)
{
    pflog( 'Verify source IP' );

    if( !pfValidIP($_SERVER['REMOTE_ADDR']) )
    {
        $pfError = true;
        pflog("What IP it got " . $_SERVER['REMOTE_ADDR']);
        $pfErrMsg = PF_ERR_BAD_SOURCE_IP;
    }
}*/

//// Verify data received
if( !$pfError )
{
    pflog( 'Verify data received' );

    $pfValid = pfValidData( $pfHost, $pfParamString );

    if( !$pfValid )
    {
        $pfError = true;
        $pfErrMsg = PF_ERR_BAD_ACCESS;
    }
}

//// Check Amounts
$dbAmount = $_GET["total"];
$amountCheck = pfAmountsEqual( $dbAmount, $pfData['amount_gross']);

if ( !$amountCheck )
{
    $pfError = true;
    $pfErrMsg = PF_ERR_AMOUNT_MISMATCH;
}

if ( !$pfError )

    //// Check order status and update the order
    if( !$pfError && !$pfDone )
    {
        pflog( 'Check order status and update the order' );

        if ( $pfData['payment_status'] == 'COMPLETE' )
        {
            $payfastID = $pfData['pf_payment_id'];
            $paymentStatus = $pfData['payment_status'];
            $itemNames = $pfData['item_name'];
            $amountGross = $pfData['amount_gross'];
            $amountFee = $pfData['amount_fee'];
            $amountNet = $pfData['amount_net'];
            $customerEmail = $pfData['email_address'];
            $orderDate = date("d/m/Y");

            ///use this for when fetching products to display to users what they ordered
            $itemNamesArr = array();
            $itemNamesArr = explode(",", $itemNames);
            $itemNameCount = count($itemNamesArr);
            array_splice($itemNamesArr, $itemNameCount - 1);

            /*$query = query("INSERT INTO orders (order_payment_id, order_payment_status, order_item_name, order_amount_gross, order_amount_fee, order_amount_net, order_email) VALUES ($payfastID, $paymentStatus, $itemName, $amountGross, $amountFee, $amountNet, $customerEmail)");
            confirm($query);*/
            $query = "INSERT INTO orders (order_payment_id, order_payment_status, order_item_name, order_amount_gross, order_amount_fee, order_amount_net, order_email, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = statement_init();

            statement_confirm($stmt, $query);

            //Bind params
            mysqli_stmt_bind_param($stmt, "issdddss", $payfastID, $paymentStatus, $itemNames, $amountGross, $amountFee, $amountNet, $customerEmail, $orderDate);
            //Run parameters inside db
            statement_execute($stmt);
            $result = statement_result($stmt);
            $pfDone = true;
        }
    }

// If an error occurred
if( $pfError )
{
    pflog( 'Error occurred: '. $pfErrMsg );
}

?>