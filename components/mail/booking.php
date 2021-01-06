<?php
// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['surname'])     ||
   empty($_POST['state'])     ||
   empty($_POST['phone-number'])   ||
   empty($_POST['country'])   ||
   empty($_POST['church-name'])   ||
   empty($_POST['address'])   ||
   empty($_POST['description'])   ||
   !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
   {
   echo "No arguments Provided!";
   return false;
   }
   
$name = strip_tags(htmlspecialchars($_POST['name'])); 
$surname = strip_tags(htmlspecialchars($_POST['surname']));
$state = strip_tags(htmlspecialchars($_POST['state']));
$phonenumber = strip_tags(htmlspecialchars($_POST['phone-number']));
$country = strip_tags(htmlspecialchars($_POST['country']));
$churchname = strip_tags(htmlspecialchars($_POST['church-name']));
$address = strip_tags(htmlspecialchars($_POST['address']));
$description = strip_tags(htmlspecialchars($_POST['description']));
$email_address = $_POST['email'];

// Create the email and send the message
$to = 'yourname@yourdomain.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Website Booking Form:  $name";
$email_body = "You have received a new message from your website Booking form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phonenumber\n\nMessage:\n$message";
$headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";   
mail($to,$email_subject,$email_body,$headers);

return true;
