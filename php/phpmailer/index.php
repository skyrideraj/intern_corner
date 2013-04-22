 <?php
    require("phpmailer/class.phpmailer.php");
    echo 'Hi';
    $mail = new PHPMailer();

    // ---------- adjust these lines ---------------------------------------
    $mail->Username = "sengroup8@gmail.com"; // your GMail user name
    $mail->Password = "passwordsen"; 
    $mail->AddAddress("ishanjain1991@gmail.com"); // recipients email
    $mail->FromName = "Ishan Jain"; // readable name

    $mail->Subject = "Yipee";
    $mail->Body    = "Here is the message you want to send to your friend."; 
    //-----------------------------------------------------------------------

    $mail->Host = "ssl://smtp.gmail.com"; // GMail
    $mail->Port = 465;
    $mail->IsSMTP(); // use SMTP
    $mail->SMTPAuth = true; // turn on SMTP authentication
    $mail->From = $mail->Username;
    if(!$mail->Send())
        echo "Mailer Error: " . $mail->ErrorInfo;
    else
        echo "Message has been sent";
    ?>