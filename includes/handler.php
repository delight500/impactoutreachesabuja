<?php
    require 'admin/config/dbconnect.php';
    // Check that data has been submited.
    if (isset($_POST['b_fname'])) {

        $b_fname = $_POST['b_fname'];
        $b_sname = $_POST['b_sname'];
        $b_state = $_POST['b_state'];
        $b_pnumber = $_POST['b_pnumber'];
        $b_country = $_POST['b_country'];
        $b_Cname = $_POST['b_Cname'];
        $b_email = $_POST['b_email'];
        $b_address = $_POST['b_address'];
        $b_purpose = $_POST['b_purpose'];
        $b_desc = $_POST['b_desc'];
        $status = "pending";
        $data = array();
        

        // Check that both username and password fields are filled with values.
        if (!empty($b_fname) && !empty($b_sname)) {
            
            $stmt = $conn->prepare(
                'INSERT INTO bookings (bf_name, bs_name, b_state, b_pnumber, b_country, b_Cname, b_email, b_address, b_purposet, b_purposedesc, status) VALUES (?,?,?,?,?,?,?,?,?,?,?)'
            );
            $stmt->bind_param(
                'sssssssssss',
                $b_fname,
                $b_sname,
                $b_state,
                $b_pnumber,
                $b_country,
                $b_Cname,
                $b_email,
                $b_address,
                $b_purpose,
                $b_desc,
                $status
            );
            $stmt->execute();
            $stmt->close();
            
            if ($stmt) {
                $data['heading1'] = "Success";
                $data['heading2'] = "success";
                $data['message'] = 'Booking registered successfully!';
            } else {
                $data['heading1'] = "Error";
                $data['heading2'] = "error";
                $data['message'] = 'An error occured try again!';
            }
               
            } else {
            $data['heading1'] = "Error";
            $data['heading2'] = "error";
            $data['message'] = 'Please fill all required fields.';
            }
            
            $main_data = json_encode($data);
            exit($main_data);
    }


if (isset($_POST['c_name'])) {
    $data = array();
    if(empty($_POST['c_name'])      ||
    empty($_POST['c_email'])     ||
    empty($_POST['c_phone'])     ||
    empty($_POST['c_message'])   ||
    !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
    {
    $data['heading1'] = "Error";
    $data['heading2'] = "error";
    $data['message'] = 'Please fill up all the fields';
    }
    
    $name = strip_tags(htmlspecialchars($_POST['c_name']));
    $email_address = strip_tags(htmlspecialchars($_POST['c_email']));
    $phone = strip_tags(htmlspecialchars($_POST['c_phone']));
    $message = strip_tags(htmlspecialchars($_POST['c_message']));

    
    // Create the email and send the message
    $to = 'contact@impactoutreachesabuja.org.ng'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
    $email_subject = "Website Contact Form:  $name";
    $email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
    $headers = "From: noreply@impactoutreachesabuja.org.ng\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
    $headers .= "Reply-To: $email_address";   
    $mail = mail($to,$email_subject,$email_body,$headers);

    if($mail){
        $data['heading1'] = "Success";
        $data['heading2'] = "success";
        $data['message'] = 'Message sent Successfully!';
    }else{
        $data['heading1'] = "Error";
        $data['heading2'] = "error";
        $data['message'] = 'An error occured try again later!';
    }
    
    $main_data = json_encode($data);
    exit($main_data);
}
