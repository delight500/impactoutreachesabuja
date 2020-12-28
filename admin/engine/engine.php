<?php

/* This class will include everything associated with users:
 * Login - Login()
 * Logout - logOut()
 * Password recovery - forgotPassword(), newPassword(), updatePassword()
 * User creation - Registration()
 * User e-mail verification - Verify()
 */

// Require credentials for DB connection.
require 'config/dbconnect.php';

//generate string function
function generate_string($input, $strength = 16)
{
    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

//Add quote function
// Check that data has been submited.
if (isset($_FILES['quote_file']['name'])) {
    // User input from Login Form(loginForm.php).
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $targetDir = 'uploads/quotes/';
    $filename = basename($_FILES['quote_file']['name']);
    $array = explode(".", $filename);
    $extension = end($array);
    $name11 = generate_string($permitted_chars, 30);
    $fileName = $name11 . "." . $extension;
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];
    $data = array();
    if (!empty($_FILES['quote_file']['name'])) {
        // Allow certain file formats
        if (in_array($fileType, $allowTypes)) {
            if ($_FILES["quote_file"]["size"] > 5000000) {
                $data['heading1'] = "An error occurred";
                $data['heading2'] = "error";
                $data['message'] = 'File too large, size should not be more than 5mb!';
            }else{

                // Upload file to server
                if (
                move_uploaded_file(
                    $_FILES['quote_file']['tmp_name'],
                    $targetFilePath
                )
                ) {
                    $quote_image = 'uploads/quotes/' . $fileName;

                    $stmt = $conn->prepare(
                        'INSERT INTO quotes (image) VALUES (?)'
                    );
                    $stmt->bind_param('s', $quote_image);
                    $stmt->execute();
                    $stmt->close();
                if($stmt) {
                    $data['heading1'] = "Success";
                    $data['heading2'] = "success";
                    $data['message'] = 'File uploaded successfully!';
                }
                }
            }
        } else {
            $data['heading1'] = "An error occurred";
            $data['heading2'] = "error";
            $data['message'] = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
    }

    // return all our data to an AJAX call
    $main_data = json_encode($data);
    exit($main_data);

}

//Display quote in modal function
if(isset($_POST['view_quote'])) {
    $view_id = $_POST['view_quote'];
    $stmt = $conn->prepare(
        "SELECT * FROM quotes WHERE id = ?"
    );
    $stmt->bind_param(
        "s",
        $view_id
    );
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $stmt->close();

    $dd = json_encode($row);
    exit($dd);
}

//Delete quote function
if(isset($_GET['qid'])){
    $quote_id= $_GET['qid'];
    $stmt = $conn->prepare(
        'SELECT image FROM quotes WHERE id = ?'
    );
    $stmt->bind_param(
        's',
        $quote_id
    );
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $delete_img = unlink($row['image']);
    if($delete_img){
        $stmt = $conn->prepare(
            'DELETE FROM quotes WHERE id = ?'
        );
        $stmt->bind_param(
            's',
            $quote_id
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    }

    echo ("<script>window.location.assign('view_quotes.php');</script> ");

}

