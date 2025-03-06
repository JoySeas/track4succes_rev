<?php
// Include the Composer autoloader to load PHPMailer classes
require '../vendor/autoload.php';

include("connect.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form'])) {
    switch ($_POST['form']) {
        case 'registeruseraccount':
            // Hash the password for security
            $password = $_POST['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Generate a unique user_id
            $user_id = generateID($connection, 'user_id', 'users', 'teacher');

            // Generate a 6-character email verification code
            $verification_code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));

            // Prepare the INSERT statement for the users table
            $registeruser = mysqli_query($connection, "INSERT INTO users SET 
                user_id = '" . mysqli_real_escape_string($connection, $user_id) . "', 
                firstname = '" . mysqli_real_escape_string($connection, $_POST['firstName']) . "', 
                middlename = '" . mysqli_real_escape_string($connection, $_POST['middleName']) . "', 
                lastname = '" . mysqli_real_escape_string($connection, $_POST['lastName']) . "', 
                username = '" . mysqli_real_escape_string($connection, $_POST['username']) . "', 
                email = '" . mysqli_real_escape_string($connection, $_POST['email']) . "', 
                password = '" . $hashed_password . "', 
                usertype = 'TEACHER',  
                status = 'PENDING',  -- Status set to PENDING until email is verified
                date_added = '" . date("Y-m-d") . "', 
                code = '" . md5(uniqid(rand(), true)) . "', 
                image_path = 'profile2.png',  
                profile_image = '../uploads/profile2.png',
                verification_code = '" . mysqli_real_escape_string($connection, $verification_code) . "'");

            // Check if the insertion was successful
            if ($registeruser) {
                // Initialize PHPMailer
                $mail = new PHPMailer\PHPMailer\PHPMailer();

                try {
                    // Server settings for Gmail SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';  // Set Gmail SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = 'track4success2024@gmail.com';  // Your Gmail email address
                    $mail->Password = 'xgnvitrarfszoanx';  // Your Gmail password (or app-specific password)
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Recipients
                    $mail->setFrom('track4success2024@gmail.com', 'Track4success');  // Your from email address
                    $mail->addAddress($_POST['email']);  // User's email address

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Email Verification for Your Account';
                    $mail->Body    = 'Hello ' . $_POST['firstName'] . ',<br><br>' . 
                                     'Please verify your email address by entering the following 6-digit code: <strong>' . 
                                     $verification_code . '</strong><br><br>' . 
                                     'Thank you for registering with us!';

                    // Send the email
                    if ($mail->send()) {
                        // Send a success message back to JavaScript
                        echo "Verification email sent successfully.";
                        exit();  // Stop further script execution
                    } else {
                        echo "Registration successful, but failed to send the verification email.";
                    }
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                // Output MySQL error for debugging
                echo "Error: Failed to register. " . mysqli_error($connection);
            }
            break;
    }
} else {
    echo "Invalid request.";
}
?>
