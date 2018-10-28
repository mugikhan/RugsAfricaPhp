<?php
    require_once "../resources/config.php";
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'assets/PHPMailer/vendor/autoload.php';

    $userName = $_POST["userName"];
    $nameHeading = "Name: ";
    $messageHeading = "Message: ";
    $userSubject = $_POST["userSubject"];
    $userEmail = $_POST["userEmail"];

    $userMessage = $nameHeading . "{$userName} <br />" . $messageHeading . $_POST["userMessage"];
    $userMessage = wordwrap($userMessage,70);

    $headers = "From: " . strip_tags($_POST["userEmail"]) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $to = "mugikhan@gmail.com";

    /*Recaptcha code from http://makingspidersense.com/tutorials/tut-recaptcha.txt */
    function post_captcha($user_response) {
            $fields_string = '';
            $fields = array(
                'secret' => '6LfDv3EUAAAAAAYpmpHpKSUuaPuM_2XdPcTKj2Gy',
                'response' => $user_response
            );
            foreach($fields as $key=>$value)
            $fields_string .= $key . '=' . $value . '&';
            $fields_string = rtrim($fields_string, '&');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

            $result = curl_exec($ch);
            curl_close($ch);

            return json_decode($result, true);
        }

        // Call the function post_captcha
        $res = post_captcha($_POST['g-recaptcha-response']);
        if (!$res['success']) {
            // What happens when the CAPTCHA wasn't checked
            echo '<div class="container-fluid"><div class="row"><h1 class="bg-warning text-center">Please go back and make sure you check the security CAPTCHA box.</h1></div></div><br>';
        }
        else {
            // If CAPTCHA is successfully completed...
            //mail($to, $userSubject, $userMessage, $headers);
            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.rugsafrica.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'info@rugsafrica.com';                 // SMTP username
                $mail->Password = 'R8172_rug123*';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                //Recipients
                $mail->setFrom($userEmail, $userName);
                $mail->addAddress($to);     // Add a recipient
                $mail->addReplyTo('info@rugsafrica.com', 'Information');
                /*$mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');*/

                //Attachments
                /*$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');  */  // Optional name

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $userSubject;
                $mail->Body    = $userMessage;
                //$mail->AltBody = $userMessage;
                $mail->send();
                redirect("thank_you_contact.php");
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
            //header("Location: index.html");
        }

    
?>





