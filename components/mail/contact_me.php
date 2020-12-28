<?php
// Check for empty fields
if(empty($_POST['c_name'])      ||
   empty($_POST['c_email'])     ||
   empty($_POST['c_phone'])     ||
   empty($_POST['c_message'])   ||
   !filter_var($_POST['c_email'],FILTER_VALIDATE_EMAIL))
   {
   echo "No arguments Provided!";
   return false;
   }
$data = array();
$name = strip_tags(htmlspecialchars($_POST['c_name']));
$email_address = strip_tags(htmlspecialchars($_POST['c_email']));
$phone = strip_tags(htmlspecialchars($_POST['c_phone']));
$subject = strip_tags(htmlspecialchars($_POST['c_subject']));
$message = strip_tags(htmlspecialchars($_POST['c_message']));
   
// Create the email and send the message
$to = 'yourname@yourdomain.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Website Contact Form:  $name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nSubject: $subject\n\nMessage:\n$message";
$headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";   
$send_mail = mail($to,$email_subject,$email_body,$headers);

if($send_mail){
    $data['heading1'] = "Success";
   $data['heading2'] = "success";
   $data['message'] = 'Contact form submitted successfully!';
                
}else {
    $data['heading1'] = "Error";
   $data['heading2'] = "error";
   $data['message'] = 'An error occured';
}

$main_data = json_encode($data);
exit($main_data);

