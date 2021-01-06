<?php

/* This class will include everything associated with users:
 * Login - Login()
 * Logout - logOut()
 * Password recovery - forgotPassword(), newPassword(), updatePassword()
 * User creation - Registration()
 * User e-mail verification - Verify()
 */

class UserClass
{
    /* __constructor()
     * Constructor will be called every time Login class is called ($login = new Login())
     */
    public function __construct()
    {
        /* Check if user is logged in. */
        $this->isLoggedIn();

        /* If login data is posted call validation function. */
        if (isset($_POST['login'])) {
            $this->Login();
        }
        /* If forgot password form data is posted call forgotPassword() function. */
        if (isset($_POST['forgotPassword'])) {
            $this->forgotPassword();
        }
        if (isset($_POST['updatePassword'])) {
            $this->updatePassword();
        }
        /* If registration data is posted call createUser function. */
        if (isset($_POST['registration'])) {
            $this->Registration();
        }
        // if add article data is posted to the function
        if (isset($_POST['add_article'])) {
            $this->Add_article();
        }

        // if view article data is posted to the function
        if (isset($_POST['view_article'])) {
            $this->View_article();
        }

        // if edit article data is posted to the function
        if (isset($_POST['edit_article'])) {
            $this->Edit_article();
        }
        if (isset($_POST['add_event'])) {
            $this->Add_Events();
        }
        // if view event data is posted to the function
        if (isset($_POST['view_events'])) {
            $this->View_events();
        }
        // if edit event data is posted to the function
        if (isset($_POST['edit_events'])) {
            $this->Edit_events();
        }

        // if delete article data is posted to the function
        if (isset($_GET['artid'])) {
            $this->Edit_article();
        }

        if (isset($_GET['edid'])) {
            $this->Delete_event();
        }

        if (isset($_POST['view_booking'])) {
            $this->View_booking();
        }

        if (isset($_GET['bkid'])) {
            $this->Pending_appointments();
        }
        

    } /* End __constructor() */

    /* Function Login()
     *  Function that validates user login data, cross-checks with database.
     *  If data is valid user is logged in, session variables are set.
     */

    private function Login()
    {
        // Require credentials for DB connection.
        require 'config/dbconnect.php';

        // Check that data has been submited.
        if (isset($_POST['login'])) {
            // User input from Login Form(loginForm.php).
            $user = trim($_POST['username']);
            $userpsw = trim($_POST['password']);

            // Check that both username and password fields are filled with values.
            if (!empty($user) && !empty($userpsw)) {
                /* Query the username from DB, if response is greater than 0 it means that users exists &
                 * we continue to compare the password hash provided by the user side with the DB data. */
                $stmt = $conn->prepare(
                    'SELECT username, password FROM users WHERE username = ?'
                );
                $stmt->bind_param('s', $user);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                if ($result->num_rows === 1) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    // Cross-reference password that is given by user with the hashed password in database.
                    if (password_verify($userpsw, $row['password'])) {
                        // Username is set as Session user_id for this user.
                        $_SESSION['user_id'] = $row['username'];
                    } else {
                        $_SESSION['message'] = 'Invalid username or password.';
                    }
                } else {
                    $_SESSION['message'] = 'Invalid username or password.';
                }
            } else {
                $_SESSION['message'] = 'Please fill all required fields.';
            }
        }
    } /* End Login() */

    /* Function logOut()
     * Logs user out, destroys all session data.
     */
    public function logOut()
    {
        session_destroy(); // Destroy all session data.
        header('Location: index.php');
    } /* End logOut() */

    /* Function isLoggedIn()
     * Check if user is already logged in, if not then prompt login form.
     */
    public function isLoggedIn()
    {
        // Require credentials for DB connection.
        require 'config/dbconnect.php';

        if (!empty(@$_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    } /* End isLoggedIn() */

    /* Function forgotPassword()
     * If the email exists $forgot_password_key is created to database, after this user will be sent an reset key via e-mail.
     * This is the first step of password reset.
     */
    private function forgotPassword()
    {
        // User input from Forgot password form(forgot.php).
        $email = trim($_POST['email']);

        // Require credentials for DB connection.
        require 'config/dbconnect.php';

        // Check if username or email is already taken.
        $stmt = $conn->prepare('SELECT email FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        // Always give this message to prevent data colleting even if the e-mail doesn't exist(The password reset e-mail is only sent if the e-mail exists in database).
        $_SESSION['SuccessMessage'] = 'E-mail has been sent.';

        // If e-mail exists a key for password reset is created into database, after this an e-mail will be sent to user with link and the token key.
        if ($result->num_rows != 0) {
            $forgot_password_key = password_hash($email, PASSWORD_DEFAULT);
            $stmt = $conn->prepare(
                'UPDATE users SET fpassword_key = ? WHERE email = ?'
            );
            $stmt->bind_param('ss', $forgot_password_key, $email);
            $stmt->execute();
            $stmt->close();

            $_SESSION['SuccessMessage'] = 'User has been created!';

            $message = 'Your reset key is: ' . $forgot_password_key . '';
            $to = $email;
            $subject = 'Reset password';
            $from = 'test@membership.com'; // Insert the e-mail from where you want to send the emails.
            $body =
                '<a href="YOURWEBSITEURL/password_reset.php?email=' .
                $email .
                '&key=' .
                $forgot_password_key .
                '">password_reset.php?email=' .
                $email .
                '&key=' .
                $forgot_password_key .
                '</a>'; // Replace YOURWEBSITEURL with your own URL for the link to work.
            $headers = 'From: ' . $from . "\r\n";
            $headers .= 'Reply-To: ' . $from . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            mail($to, $subject, $body, $headers);
        }
    } /* End forgotPassword() */

    /* Function newPassword()
     * URL opened from e-mail, get email & token key from URL.
     * If the e-mail and token exist in database prompt new password form.
     * Otherwise prompt an error.
     * This is the second step of password reset.
     */
    public function newPassword()
    {
        // Values from password_reset.php URL.
        $email = htmlspecialchars($_GET['email']);
        $forgot_password_key = htmlspecialchars($_GET['key']);

        // Require credentials for DB connection.
        require 'config/dbconnect.php';

        $stmt = $conn->prepare(
            'SELECT email,fpassword_key  FROM users WHERE email = ? AND fpassword_key = ?'
        );
        $stmt->bind_param('ss', $email, $forgot_password_key);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows != 0) {
            include 'views/passwordResetForm.php';
        } else {
            $_SESSION['message'] =
                'Please contact support at support@membership.com';
        }
    } /* End newPassword() */

    /* function updatePassword()
     * Get information from Password Reset Form, if the email & token key are correct, update the passwordin database.
     * This is the third and final step of password reset.
     */
    private function updatePassword()
    {
        // User input from Forgot password form(passwordResetForm.php).
        $password3 = trim($_POST['password3']);
        $password2 = trim($_POST['password2']);
        $email = $_POST['email'];
        $forgot_password_key = $_POST['key'];

        // Require credentials for DB connection.
        require 'config/dbconnect.php';

        // Check that both entered passwords match.
        if ($password3 === $password2) {
            if (!empty($password3) && !empty($email)) {
                $securing = password_hash($password2, PASSWORD_DEFAULT);
                $stmt = $conn->prepare(
                    'UPDATE users SET password = ?, fpassword_key = ?  WHERE email = ? AND fpassword_key = ?'
                );
                $clean_password_key = '';
                $stmt->bind_param(
                    'ssss',
                    $securing,
                    $clean_password_key,
                    $email,
                    $forgot_password_key
                );
                $stmt->execute();
                $stmt->close();
            } else {
                $_SESSION['message'] = 'Please fill all required fields.';
            }
        } else {
            $_SESSION['message'] = 'Passwords do not match!';
        }
    } /* End updatePassword() */

    /* Function Registration(){
     * Function that includes everything for new user creation.
     * Data is taken from registration form, converted to prevent SQL injection and
     * checked that values are filled, if all is correct data is entered to user database.
     */
    private function Registration()
    {
        // Require credentials for DB connection.
        require 'config/dbconnect.php';

        // Variables for createUser()
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $password2 = trim($_POST['password2']);
        $email = $_POST['email'];

        if ($password === $password2) {
            // Create hashed user password.
            $securing = password_hash($password, PASSWORD_DEFAULT);

            // Check that all fields are filled with values.
            if (!empty($username) && !empty($password) && !empty($email)) {
                // Check if username or email is already taken.
                $stmt = $conn->prepare(
                    'SELECT username, email FROM users WHERE username = ? OR email = ?'
                );
                $stmt->bind_param('ss', $username, $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                // Check if email is in the correct format.
                if (
                    !preg_match(
                        '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^',
                        $email
                    )
                ) {
                    header('Location: registration.php');
                    $_SESSION['message'] = 'Please insert correct e-mail.';
                    exit();
                }

                // If username or email is taken.
                if ($result->num_rows != 0) {
                    // Promt user error about username or email already taken.
                    header('Location: registration.php');
                    $_SESSION['message'] = 'Username or e-mail is taken!';
                    exit();
                } else {
                    // Insert data into database
                    $code = substr(md5(mt_rand()), 0, 15);
                    $stmt = $conn->prepare(
                        'INSERT INTO users (username, email, password, activation_code) VALUES (?,?,?,?)'
                    );
                    $stmt->bind_param(
                        'ssss',
                        $username,
                        $email,
                        $securing,
                        $code
                    );
                    $stmt->execute();
                    $stmt->close();

                    // Send user activation e-mail

                    $message = 'Your activation code is: ' . $code . '.';
                    $to = $email;
                    $subject = 'Your activation code for Membership.';
                    $from = 'test@membership.com'; // This should be changed to an email that you would like to send activation e-mail from.
                    $body =
                        'Your activation code is: ' .
                        $code .
                        '<br> To activate your account please click on the following link' .
                        ' <a href="YOURWEBSITEURL/verify.php?id=' .
                        $email .
                        '&code=' .
                        $code .
                        '">verify.php?id=' .
                        $email .
                        '&code=' .
                        $code .
                        '</a>.'; // Input the URL of your website.
                    $headers = 'From: ' . $from . "\r\n";
                    $headers .= 'Reply-To: ' . $from . "\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .=
                        "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    mail($to, $subject, $body, $headers);

                    // If registration is successful return user to registration.php and promt user success pop-up.
                    header('Location: registration.php');
                    $_SESSION['SuccessMessage'] = 'User has been created!';
                    exit();
                }
            } else {
                // If registration fails return user to registration.php and promt user failure error.
                header('Location: registration.php');
                $_SESSION['message'] = 'Please fill all fields!';
                exit();
            }
        } else {
            header('Location: registration.php');
            $_SESSION['message'] = 'Passwords do not match!';
            exit();
        }
    } /* End Registration() */

    /* Function Verify(){
     * User e-mail verification on verify.php
     * E-mail and activation code are cross-referenced with database, if both are correct
     * is_activated is updated in database.
     */
    public function Verify()
    {
        if (isset($_GET['id']) && isset($_GET['code'])) {
            // Variables for Verify()
            $user_email = htmlspecialchars($_GET['id']);
            $activation_code = htmlspecialchars($_GET['code']);

            // Require credentials for DB connection.
            require 'config/dbconnect.php';

            // Cross-reference e-mail and activation_code in database with values from URL.
            $stmt = $conn->prepare(
                'SELECT email FROM users WHERE email = ? and activation_code = ?'
            );
            $stmt->bind_param('ss', $user_email, $activation_code);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            // If e-mail and activation_code exist and are correct then update user is_activated value.
            if ($result->num_rows == 1) {
                $stmt = $conn->prepare(
                    'UPDATE users SET is_activated = ? WHERE email = ? and activation_code = ?'
                );
                $verified = 1;
                $stmt->bind_param(
                    'iss',
                    $verified,
                    $user_email,
                    $activation_code
                );
                $stmt->execute();
                $stmt->close();
                return true;
            } else {
                return false;
            }
        }
    } /* End Verify() */

    /* Function Add_article(){
     * add new article in add-article.php
     * inputs all values into the database.
     */
    public function Add_article()
    {
        // Require credentials for DB connection.
        require 'config/dbconnect.php';
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
        // Check that data has been submited.
        if (isset($_POST['add_article'])) {
            // User input from Login Form(loginForm.php).
            $article_title = $_POST['article-title'];
            $permitted_chars =
                '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $article_body = $_POST['article-body'];
            $targetDir = 'uploads/';
            $filename = basename($_FILES['file']['name']);
            $array = explode('.', $filename);
            $extension = end($array);
            $name2 = generate_string($permitted_chars, 20);
            $fileName = $name2 . '.' . $extension;
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

            // Check that both username and password fields are filled with values.
            if (!empty($article_title) && !empty($article_body)) {
                if (!empty($_FILES['file']['name'])) {
                    // Allow certain file formats
                    if (in_array($fileType, $allowTypes)) {
                        // Upload file to server
                        if (
                            move_uploaded_file(
                                $_FILES['file']['tmp_name'],
                                $targetFilePath
                            )
                        ) {
                            $featured_image = 'uploads/' . $fileName;
                        } else {
                            $featured_image = 'uploads/default.jpg';
                        }
                        $stmt = $conn->prepare(
                            'INSERT INTO articles (title, description, featured_image) VALUES (?,?,?)'
                        );
                        $stmt->bind_param(
                            'sss',
                            $article_title,
                            $article_body,
                            $featured_image
                        );
                        $stmt->execute();
                        $stmt->close();

                        if ($stmt) {
                            $_SESSION['SuccessMessage'] =
                                'article added successfully!';
                        } else {
                            $_SESSION['message'] =
                                'An error occured try again !';
                        }
                    } else {
                        $_SESSION['message'] =
                            'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
                    }
                }
                if (empty($_FILES['file']['name'])) {
                    $featured_image = 'uploads/default/default.png';
                    $stmt = $conn->prepare(
                        'INSERT INTO articles (title, description, featured_image) VALUES (?,?,?)'
                    );
                    $stmt->bind_param(
                        'sss',
                        $article_title,
                        $article_body,
                        $featured_image
                    );
                    $stmt->execute();
                    $stmt->close();

                    if ($stmt) {
                        $_SESSION['SuccessMessage'] =
                            'article added successfully!';
                    } else {
                        $_SESSION['message'] = 'An error occured try again !';
                    }
                }
            } else {
                $_SESSION['message'] = 'Please fill all required fields.';
            }
        }
    } /* End add-article */

    /* Function View_article(){
     * displays values in view file with ajax from database.
     */
    public function View_article()
    {
        // Require credentials for DB connection.
        require 'config/dbconnect.php';

        $view_id = $_POST['view_article'];

        $stmt = $conn->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->bind_param('s', $view_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $stmt->close();

        $dd = json_encode($row);
        exit($dd);
    } /* End view-article */

    /* Function Edit_article(){
     * updates article records in the database.
     */
    public function Edit_article()
    {
        // Require credentials for DB connection.
        require 'config/dbconnect.php';

        // Check that data has been submited.
        if (isset($_POST['edit_article'])) {
            // User input from Login Form(loginForm.php).
            // Require credentials for DB connection.
            require 'config/dbconnect.php';
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
            $id = $_GET['id'];
            // User input from Login Form(loginForm.php).
            $article_title = $_POST['article-title'];
            $permitted_chars =
                '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $article_body = $_POST['article-body'];
            $targetDir = 'uploads/';
            $filename = basename($_FILES['file']['name']);
            $array = explode('.', $filename);
            $extension = end($array);
            $name2 = generate_string($permitted_chars, 30);
            $fileName = $name2 . '.' . $extension;
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

            // Check that both username and password fields are filled with values.
            if (!empty($article_title) && !empty($article_body)) {
                if (!empty($_FILES['file']['name'])) {
                    // Allow certain file formats
                    if (in_array($fileType, $allowTypes)) {
                        $stmt = $conn->prepare(
                            'SELECT title, featured_image FROM articles WHERE id = ?'
                        );
                        $stmt->bind_param('s', $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $stmt->close();

                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $delete_img = unlink($row['featured_image']);

                        if ($delete_img) {
                            // Upload file to server
                            if (
                                move_uploaded_file(
                                    $_FILES['file']['tmp_name'],
                                    $targetFilePath
                                )
                            ) {
                                $featured_image = 'uploads/' . $fileName;
                            } else {
                                $featured_image = 'uploads/default/default.jpg';
                            }
                            $stmt = $conn->prepare(
                                'UPDATE `articles` SET title = ?, description = ?, featured_image = ? WHERE id = ?'
                            );
                            $stmt->bind_param(
                                'ssss',
                                $article_title,
                                $article_body,
                                $featured_image,
                                $id
                            );
                            $stmt->execute();
                            $stmt->close();

                            if ($stmt) {
                                $_SESSION['SuccessMessage'] =
                                    'article updated successfully!';
                                echo "<script>
                             window.location.assign('view_articles.php');
                            </script>
                            ";
                            } else {
                                $_SESSION['message'] =
                                    'An error occured try again !';
                            }
                        }
                    } else {
                        $_SESSION['message'] =
                            'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
                    }
                }
                if (empty($_FILES['file']['name'])) {
                    $featured_image = 'uploads/default/default.jpg';
                    $stmt = $conn->prepare(
                        'UPDATE `articles` SET title = ?, description = ? WHERE id = ?'
                    );
                    $stmt->bind_param(
                        'sss',
                        $article_title,
                        $article_body,
                        $id
                    );
                    $stmt->execute();
                    $stmt->close();

                    if ($stmt) {
                        $_SESSION['SuccessMessage'] =
                            'article updated successfully!';
                        echo "<script>
                               window.location.assign('view_articles.php');
                            </script>
                            ";
                    } else {
                        $_SESSION['message'] = 'An error occured try again !';
                    }
                }
            } else {
                $_SESSION['message'] = 'Please fill all required fields.';
            }
        }

        //Delete article function
        if (isset($_GET['artid'])) {
            $article_id = $_GET['artid'];
            $stmt = $conn->prepare(
                'SELECT title, featured_image FROM articles WHERE id = ?'
            );
            $stmt->bind_param('s', $article_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($row['featured_image'] === 'uploads/default/default.png') {
                $stmt = $conn->prepare('DELETE FROM articles WHERE id = ?');
                $stmt->bind_param('s', $article_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                if ($stmt) {
                    $_SESSION['SuccessMessage'] =
                        'article deleted successfully!';
                    echo "<script>
                             window.location.assign('view_articles.php');
                             swal('Success', 'article deleted succesfully', 'success');
                            </script>
                           ";
                }
            } else {
                $delete_img = unlink($row['featured_image']);
                if ($delete_img) {
                    $stmt = $conn->prepare('DELETE FROM articles WHERE id = ?');
                    $stmt->bind_param('s', $article_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();
                }
            }

            if ($stmt) {
                echo "<script>swal('Good job!', 'Article deleted!', 'success');</script> ";
            } else {
                echo "<script>swal('An Error Occured!', 'Article not deleted!', 'error');</script> ";
            }
        }
    } /* End edit-article */

    /* Function View_article(){
     * displays values in view file with ajax from database.
     */
    private function Add_Events()
    {
        require 'config/dbconnect.php';
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
        // Check that data has been submited.
        if (isset($_POST['add_event'])) {
            // User input from Login Form(loginForm.php).
            $event_title = $_POST['e_title'];
            $permitted_chars =
                '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $event_desc = $_POST['e_description'];
            $targetDir = 'uploads/events/';
            $filename = basename($_FILES['file']['name']);
            $array = explode('.', $filename);
            $extension = end($array);
            $name2 = generate_string($permitted_chars, 20);
            $fileName = $name2 . '.' . $extension;
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];
            $data = [];

            // Check that both username and password fields are filled with values.
            if (!empty($event_desc) && !empty($event_title)) {
                if (!empty($_FILES['file']['name'])) {
                    // Allow certain file formats
                    if (in_array($fileType, $allowTypes)) {
                        // Upload file to server
                        if (
                            move_uploaded_file(
                                $_FILES['file']['tmp_name'],
                                $targetFilePath
                            )
                        ) {
                            $image = 'uploads/events/' . $fileName;
                            $stmt = $conn->prepare(
                                'INSERT INTO events (title, description, image) VALUES (?,?,?)'
                            );
                            $stmt->bind_param(
                                'sss',
                                $event_title,
                                $event_desc,
                                $image
                            );
                            $stmt->execute();
                            $stmt->close();

                            if ($stmt) {
                                $_SESSION['SuccessMessage'] =
                                    'article added successfully!';
                                echo "<script>window.location.assign('view_events.php');</script> ";
                            } else {
                                $_SESSION['message'] =
                                    'An error occured try again !';
                            }
                        }
                    } else {
                        $_SESSION['message'] =
                            'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
                    }
                }
            }
        }
    }

    private function View_events()
    {
        // Require credentials for DB connection.
        require 'config/dbconnect.php';

        $view_id = $_POST['view_events'];

        $stmt = $conn->prepare('SELECT * FROM events WHERE id = ?');
        $stmt->bind_param('s', $view_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $stmt->close();

        $dd = json_encode($row);
        exit($dd);
    }

    private function Edit_events()
    {
        require 'config/dbconnect.php';

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

        $id = $_GET['id'];
        // User input from Login Form(loginForm.php).
        $event_title = $_POST['e_title'];
        $permitted_chars =
            '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $event_desc = $_POST['e_description'];
        $targetDir = 'uploads/events/';
        $filename = basename($_FILES['file']['name']);
        $array = explode('.', $filename);
        $extension = end($array);
        $name2 = generate_string($permitted_chars, 20);
        $fileName = $name2 . '.' . $extension;
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];
        $data = [];

        // Check that both username and password fields are filled with values.
        if (!empty($event_desc) && !empty($event_title)) {
            if (!empty($_FILES['file']['name'])) {
                $stmt = $conn->prepare('SELECT * FROM events WHERE id = ?');
                $stmt->bind_param('s', $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $delete_img = unlink($row['image']);

                if ($delete_img) {
                    // Allow certain file formats
                    if (in_array($fileType, $allowTypes)) {
                        // Upload file to server
                        if (
                            move_uploaded_file(
                                $_FILES['file']['tmp_name'],
                                $targetFilePath
                            )
                        ) {
                            $image = 'uploads/events/' . $fileName;
                            $stmt = $conn->prepare(
                                'UPDATE `events` SET title = ?, description = ?, image = ? WHERE id = ?'
                            );
                            $stmt->bind_param(
                                'ssss',
                                $event_title,
                                $event_desc,
                                $image,
                                $id
                            );
                            $stmt->execute();
                            $stmt->close();

                            if ($stmt) {
                                $_SESSION['SuccessMessage'] =
                                    'article added successfully!';
                                echo "<script>window.location.assign('view_events.php');</script> ";
                            } else {
                                $_SESSION['message'] =
                                    'An error occured try again !';
                            }
                        }
                    } else {
                        $_SESSION['message'] =
                            'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
                    }
                }
            }
        }
        if (empty($_FILES['file']['name'])) {
            $stmt = $conn->prepare(
                'UPDATE `events` SET title = ?, description = ? WHERE id = ?'
            );
            $stmt->bind_param('sss', $event_title, $event_desc, $id);
            $stmt->execute();
            $stmt->close();

            if ($stmt) {
                $_SESSION['SuccessMessage'] = 'article updated successfully!';
                echo "<script>
                               window.location.assign('view_events.php');
                            </script>
                            ";
            } else {
                $_SESSION['message'] = 'An error occured try again !';
            }
        } else {
            $_SESSION['message'] = 'Please fill all required fields.';
        }
    }

    private function Delete_event()
    {
        require 'config/dbconnect.php';
        $event_id = $_GET['edid'];
        $stmt = $conn->prepare(
            'SELECT image FROM events WHERE id = ?'
        );
        $stmt->bind_param('s', $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $delete_img = unlink($row['image']);

        if ($delete_img) {
            $stmt = $conn->prepare('DELETE FROM events WHERE id = ?');
            $stmt->bind_param('s', $event_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        }
        
        if ($stmt) {
            echo "<script>swal('Good job!', 'Article deleted!', 'success');</script> ";
        } else {
            echo "<script>swal('An Error Occured!', 'Article not deleted!', 'error');</script> ";
        }
    }

    /* Function View_booking(){
     * displays values in view file with ajax from database.
     */
    public function View_booking()
    {
        // Require credentials for DB connection.
        require 'config/dbconnect.php';

        $view_id = $_POST['view_booking'];

        $stmt = $conn->prepare('SELECT * FROM bookings WHERE id = ?');
        $stmt->bind_param('s', $view_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $stmt->close();

        $dd = json_encode($row);
        exit($dd);
    } /* End view-article */

    public function Pending_appointments()
    {
        // Require credentials for DB connection.
        require 'config/dbconnect.php';

        $view_id = $_GET['bkid'];
        $status = 'seen';
         $stmt = $conn->prepare(
            'UPDATE `bookings` SET status = ? WHERE id = ?'
        );
        $stmt->bind_param('ss', $status, $view_id);
        $stmt->execute();
        $stmt->close();
       
        if ($stmt) {
            echo "<script>swal('Success!', 'Appointment Seen', 'success');</script> ";
        } else {
            echo "<script>swal('An Error Occured!', 'Try again later!', 'error');</script> ";
        }
    } /* End view-article */

} /* End class UserClass */
