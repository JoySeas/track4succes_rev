<!DOCTYPE html>
<html lang="en">
<head>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <?php include('header.php'); ?>
    <style type="text/css">
       body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        .auth {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            background-color: #ffffff;
            overflow-x: hidden;
            overflow-y: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .auth-container {
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            box-shadow: 1px 1px 5px rgb(126, 142, 159);
            border-radius: 20px;
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            height: 600px;
        }

        .auth-container img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .form-container {
            padding: 2rem 2.5rem;
            overflow-y: auto;
            max-height: 100%;
        }

        .auth-header {
            margin-top:1px;
            color: #000000;
        }

        .card {
            border: none;
            background-color: transparent;
            box-shadow: none;
        }

        .form-row {
        display: flex;
        gap: 20px; /* Adjust gap as needed */
        margin-bottom: 1px; /* Smaller margin for rows */
        }

        .form-group {
        display: flex;
        flex-direction: column;
        flex: 1;
        margin-bottom: 5px; /* Smaller margin for rows */
        }

        .form-label {
        margin-bottom: 0.1rem;
        color: #000000;
        font-family: 'Poppins';
        font-weight: 500;
        font-size: 0.8rem;
        }

        .form-control {
        height: 40px;
        border-radius: 8px;
        }
        @media (min-width: 768px) {
            .auth-container {
                flex-direction: row;
            }

            .auth-container img {
                width: 50%;
                display: block; /* Ensure image is visible on larger screens */
            }

            .form-container {
                width: 50%;
            }
        }

        @media (max-width: 767px) {
            .auth-container img {
                display: none; /* Hide image on smaller screens */
            }
        }
        hr.custom-line {
            border: none;
            border-top: 1px solid #D2D2D2;
            margin: 20px 0;
        }
        .signup-text {
            text-align: center;
            font-family: 'Poppins';
            font-size: 1rem;
            color: #000000;
            margin-top: 15px;
        }

        .signup-text a {
            font-weight: bold;
            color: #000000;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .signup-text a:hover {
            text-decoration: none;
            color: #D2D2D2;
        }
    </style>
</head>
<body>
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <div class="auth">
        <div class="auth-container">
            <img src="../assets/images/teacher/teacher.png" alt="teacher">
            <div class="card form-container">
                <div class="card-body cardbodylogin">
                    <div class="form-horizontal form-material">
                        <header class="auth-header">
                            <p style="margin-bottom: 10px;font-family: 'Montserrat'; font-weight: 900; font-size: 1.5rem">Let's get started!</p>
                        </header>
                        <form method="POST" action="" onsubmit="registeruseraccount(event);">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <p style="margin-bottom: 5px; font-family: 'Poppins'; color:#000000; font-weight: 400; font-size: 1rem">Sign up to Track4Success</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control underlined" name="firstName" id="firstName" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label for="middleName" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control underlined" name="middleName" id="middleName" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control underlined" name="lastName" id="lastName" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-row">
    <div class="form-group">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control underlined" name="username" id="username" placeholder="" required>
    </div>
</div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control underlined" name="email" id="email" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-row">
    <div class="form-group">
        <label for="password" class="form-label">Password</label>
        <div class="row">
            <div class="col-md-11" style="padding-right: 0px; flex: 0 0 95%; max-width: 95%;">
                <input type="password" class="form-control underlined" name="password" id="password" placeholder="" required>
            </div>
            <div class="col-md-1" style="padding-left: 0px; padding-right: 0px; flex: 1%; max-width: 1%;">
                <i class="fa fa-eye-slash" style="margin-left: -23px; cursor: pointer; font-size: 1.1rem; margin-top: .7rem" id="logineye1" onclick="togglePasswordVisibility('password', 'logineye1')"></i>
            </div>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <div class="row">
            <div class="col-md-11" style="padding-right: 0px; flex: 0 0 95%; max-width: 95%;">
                <input type="password" class="form-control underlined" name="confirm_password" id="confirm_password" placeholder="" required>
            </div>
            <div class="col-md-1" style="padding-left: 0px; padding-right: 0px; flex: 1%; max-width: 1%;">
                <i class="fa fa-eye-slash" style="margin-left: -23px; cursor: pointer; font-size: 1.1rem; margin-top: .7rem" id="logineye2" onclick="togglePasswordVisibility('confirm_password', 'logineye2')"></i>
            </div>
        </div>
    </div>
</div>

                            <div class="form-group mt-4">
                                <div class="col-xs-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="termsCheckbox" required>
                                        <label class="form-check-label" for="termsCheckbox" style="margin-bottom: 0px; color:#000000; font-family: 'Poppins'; font-weight: 500; font-size: 0.8rem">
                                            I Agree to the <a href="../terms.php">Terms and Conditions</a> of Track4Success.
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-md btn-block waves-effect waves-light" style="padding: 10px 10px; font-weight: 500; background-color: #FC4100; border-radius: 14px;"  onclick="registeruseraccount();">Sign Up</button>
                                </div>
                                <hr class="custom-line">
                                <p class="signup-text">Already have an account? <a href="login.php">Log in</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('jscripts.php'); ?>
</body>
</html>

<script type="text/javascript">
    
    function registeruseraccount(event) {
    event.preventDefault(); // Prevent the default form submission

    // Gather form data
    var firstName = $("#firstName").val();
    var middleName = $("#middleName").val();
    var lastName = $("#lastName").val();
    var username = $("#username").val(); // New field
    var email = $("#email").val();
    var password = $("#password").val();
    var confirmPassword = $("#confirm_password").val();
    var termsAccepted = $('#termsCheckbox').is(':checked');

    // Basic form validation
    if (!firstName || !middleName || !lastName || !username || !email || !password || !confirmPassword || !termsAccepted) {
        Swal.fire(
            'ALERT',
            'Please review your entries. Ensure all required fields are filled out and agree to the Terms and Conditions.',
            'warning'
        );
        return; // Stop further execution
    }

    if (password !== confirmPassword) {
        Swal.fire(
            'ALERT',
            'Passwords do not match. Please try again.',
            'error'
        );
        return; // Stop further execution
    }

    // Show preloader
    $(".preloader").show().css('background', 'rgba(255,255,255,0.5)');

    // AJAX request to register user
    $.ajax({
        type: 'POST',
        url: 'signup_class.php', // PHP script for registration
        data: {
            form: 'registeruseraccount',
            firstName: firstName,
            middleName: middleName,
            lastName: lastName,
            username: username, // New field
            email: email,
            password: password,
            confirmPassword: confirmPassword,
            termsAccepted: termsAccepted
        },
        success: function(response) {
            $(".preloader").hide().css('background', ''); // Hide preloader

            if (response.trim() === "Verification email sent successfully.") {
    Swal.fire({
        title: "Success!",
        text: 'A verification email has been sent. Please check your inbox for the verification code.',
        icon: "success",
        confirmButtonColor: "#00fb71",
        confirmButtonText: "Okay"
    }).then(() => {
        // Redirect to verification page
        window.location.href = 'verification.php?email=' + encodeURIComponent(email);
    });
} else {
    Swal.fire(
        'ERROR',
        response.trim(), // Display the exact error message
        'error'
    );
}

        },
        error: function(xhr, status, error) {
            $(".preloader").hide().css('background', ''); // Hide preloader
            Swal.fire(
                'ERROR',
                'Failed to register. Please try again. Server error: ' + error,
                'error'
            );
        }
    });
}




    function fncloginpassattribHash() {
        $("#txtpassword").attr("type", "password");
        $("#logineye").attr("onclick", "fncloginpassattribunHash()");
        $("#logineye").removeClass("fa-eye");
        $("#logineye").addClass("fa-eye-slash");
    }

    function fncloginpassattribunHash() {
        $("#txtpassword").attr("type", "text");
        $("#logineye").attr("onclick", "fncloginpassattribHash()");
        $("#logineye").addClass("fa-eye");
        $("#logineye").removeClass("fa-eye-slash");
    }
    function togglePasswordVisibility(passwordFieldId, eyeIconId) {
    var passwordField = document.getElementById(passwordFieldId);
    var eyeIcon = document.getElementById(eyeIconId);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    }
}


</script>
