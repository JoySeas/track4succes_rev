<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <style>
        body {
            font-family: 'Poppins';
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f7f7f7;
        }

        .card {
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .card h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #333;
        }

        .card label {
            display: block;
            text-align: left;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }

        .card .verification-box {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 20px;
        }

        .card input[type="text"] {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 1.5rem;
            border: 1px solid #2C4E80;
            border-radius: 5px;
            outline: none;
        }

        .card input[type="submit"] {
            background: #2C4E80;
            color: #fff;
            padding: 10px 50px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 1rem;
        }

        .card input[type="submit"]:hover {
            background: #0056b3;
        }

        .card p {
            font-size: 0.9rem;
            color: #333;
        }

        .card a {
            color: #007BFF;
            text-decoration: none;
        }

        .card a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .success {
            color: green;
            margin-bottom: 20px;
            font-size: 1rem;
        }
    </style>
</head>
<body>
<?php
include("connect.php");

$error_message = ''; // Initialize error message
$success_message = ''; // Initialize success message

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Concatenate the individual input values into a single string
        $entered_code = implode('', $_POST['verification_code']); 

        // Retrieve the stored verification code from the database
        $query = "SELECT verification_code FROM users WHERE email = '" . mysqli_real_escape_string($connection, $email) . "'";
        $result = mysqli_query($connection, $query);
        $user = mysqli_fetch_assoc($result);

        if ($user && $user['verification_code'] === $entered_code) {
            // Update user status to 'APPROVED'
            $update_query = "UPDATE users SET status = 'APPROVED' WHERE email = '" . mysqli_real_escape_string($connection, $email) . "'";
            mysqli_query($connection, $update_query);

            $success_message = "Your email has been verified. You can now <a href='login.php'>login</a>."; // Set success message
        } else {
            $error_message = "Invalid verification code. Please try again."; // Set error message
        }
    }


    // Display form to enter the verification code
    echo '<div class="card">
            <form method="POST">
                <h2>Email Verification</h2>';

    if ($error_message) {
        echo "<div class='error'>$error_message</div>"; // Display error message above input field
    }
// Display success message if exists
if ($success_message) {
    echo "<div class='success'>$success_message</div>"; // Display success message above the label
}
    echo '  <label for="verification_code">Enter Verification Code </label>
            <div class="verification-box">
                <input type="text" name="verification_code[]" maxlength="1" required>
                <input type="text" name="verification_code[]" maxlength="1" required>
                <input type="text" name="verification_code[]" maxlength="1" required>
                <input type="text" name="verification_code[]" maxlength="1" required>
                <input type="text" name="verification_code[]" maxlength="1" required>
                <input type="text" name="verification_code[]" maxlength="1" required>
            </div>
            <input type="submit" value="Verify">
          </form>
        </div>';
} else {
    echo "<div class='card'><p>Invalid email.</p></div>";
}
?>
</body>
</html>
