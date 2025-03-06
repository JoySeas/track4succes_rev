<!DOCTYPE html>
<html lang="en">

<head>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

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
            padding: 3rem 3rem;
        }

        .auth-header {
            margin-top: 5px;
            color: #000000;
        }

        .card {
            border: none;
            background-color: transparent;
            box-shadow: none;
        }

        .form-group {
            margin-bottom: 20px;
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

        /* Forgot Password Link Style */
        .forgot-password {
            font-size: 0.9rem;
            color: #2C4E80;
            text-decoration: none;
            font-family: 'Poppins';
            font-weight: 800;
            display: block;
            text-align: right;
            margin-top: 5px;
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: #FC4100;
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
            <div class="card form-container">
                <div class="card-body cardbodylogin">
                    <div class="form-horizontal form-material">
                        <header class="auth-header">
                            <p class="" style="margin-bottom: 10px; font-family: 'Montserrat'; font-weight: 900; font-size: 1.45rem">
                                WELCOME TO <span style="color: #2C4E80;  font-weight: 900;">Track</span><span style="color: #FFC55A;  font-weight: 900;">4</span><span style="color: #FC4100;  font-weight: 900;">Success</span>
                            </p>
                        </header>
                        <div class="form-group row" style="margin-bottom: 5px;">
                            <div class="col-md-12">
                                <p class="" style="margin-bottom: 5px; font-family: 'Poppins'; color:#000000; font-size: 1rem">Log in to your teacher account</p>
                            </div>
                        </div>
                        <label class="mt-3" for="username" style="margin-bottom: 0px; color:#000000; font-family: 'Poppins'; font-weight: 500; font-size: 0.8rem">Email</label>
                        <div class="form-group row">
                            <span class="text-danger"></span>
                            <div class="col-md-11" style="flex: 0 0 98.2%; max-width: 98.2%;">
                                <input type="email" class="form-control underlined" name="txtemail" id="txtemail" placeholder="" required style="height: 40px; border-radius: 8px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" style="margin-bottom: 0px; color:#000000; font-family: 'Poppins'; font-weight: 500; font-size: 0.8rem">Password</label>
                            <span class="text-danger"></span>
                            <div class="row">
                                <div class="col-md-11" style="padding-right: 0px; flex: 0 0 95%; max-width: 95%;">
                                    <input type="password" class="form-control underlined" name="txtpassword" id="txtpassword" placeholder="" required style="height: 40px; border-radius: 8px;">
                                </div>
                                <div class="col-md-1" style="padding-left: 0px;padding-right: 0px; flex: 1%; max-width: 1%;">
                                    <i class="fa fa-eye-slash" style="margin-left: -23px; cursor: pointer; font-size: 1.1rem; margin-top: .7rem" id="logineye" onclick="fncloginpassattribunHash()"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Forgot Password Link -->
                        <a href="forgot-password.php" class="forgot-password">Forgot Password?</a>

                        <div class="form-group mt-4">
                            <div class="col-xs-12">
                                <button class="btn btn-success btn-md btn-block text-uppercase waves-effect waves-light" onclick="loginuser();" style="padding: 10px 10px; font-weight: 500; background-color: #FC4100; border-radius: 14px;">LogIn</button>
                            </div>
                            <hr class="custom-line">
                            <p class="signup-text">Don't have an account? <a href="signup.php">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <img src="..//assets/images/teacher/teacher.png" alt="Description of the image">
        </div>
    </div>
</body>

</html>

<?php include('jscripts.php'); ?>

<script type="text/javascript">
    $(document).keyup(function(e) {
        var e = e || window.event; // for IE to cover IEs window event-object
        if (e.which == 13) {
            loginuser();
        }
    });

    function loginuser() {
        var txtemail = $("#txtemail").val();
        var txtpassword = $("#txtpassword").val();
        $(".preloader").show().css('background', 'rgba(255,255,255,0.5)');
        $.ajax({
            type: 'POST',
            url: 'loginclass.php',
            data: 'txtemail=' + txtemail +
                '&txtpassword=' + txtpassword +
                '&form=loginuser',
            success: function(data) {
                setTimeout(function() {
                    $(".preloader").hide().css('background', '');
                    if (data == 1) {
                        window.location = 'index.php';
                    } else if (data == 3) {
                        Swal.fire(
                            'USER INACTIVE',
                            'Your account is currently inactive, Please contact your admin.',
                            'warning'
                        )
                    } else {
                        Swal.fire(
                            'USER NOT FOUND',
                            'You have entered invalid username or password.',
                            'warning'
                        )
                    }
                }, 1000);
            }
        })
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
        $("#logineye").removeClass("fa-eye-slash");
        $("#logineye").addClass("fa-eye");
    }
</script>
