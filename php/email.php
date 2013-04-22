<?php
require("/phpmailer/class.phpmailer.php");
require_once __DIR__.'/../includes/initialize_database.php';
Class email{
function emailer($email,$subject,$content){
$mailer = new PHPMailer();
  $mailer->IsSMTP();
  $mailer->SMTPAuth = true;
  $mailer->Host = "smtp.gmail.com";
  $mailer->SMTPDebug = 1;
  $mailer->SMTPSecure = 'ssl';
  $mailer->Port = 465;
  $mailer->Username = "sengroup8@gmail.com";
  $mailer->Password = "passwordsen";
  $mailer->SetFrom('sengroup8@gmail.com','sen');
  $mailer->FromName = "From";
  $mailer->AddAddress($email);
  $mailer->Subject = $subject;
  $mailer->Body = $content;
  $mailer->IsHTML (true);
  if (!$mailer->Send())
  {
    echo "Error: $mailer->ErrorInfo";
  }
  else
  {
    echo "Message Sent!";
  }
  }
}

?> 