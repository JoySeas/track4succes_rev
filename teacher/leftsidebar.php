<?php
include("../connect.php");
session_start();

// Check if user is logged in (you should implement your own authentication logic)
if (empty($_SESSION['user_id']) || $_SESSION['usertype'] !== 'TEACHER') {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Get firstname from session
$firstname = $_SESSION['firstname'];

?>
<head>
  <link href="assets/fontawesome/css/fontawesome.css" rel="stylesheet" />
  <link href="assets/fontawesome/css/brands.css" rel="stylesheet" />
  <link href="assets/fontawesome/css/solid.css" rel="stylesheet" />
  <style>
    .dropdown-item.active, .dropdown-item:active {
        color: #fff;
        text-decoration: none;
        background-color: #D7EBF0;
    }
    .dropdown-item:active {
        color: #fff;
        text-decoration: none;
        background-color: #D7EBF0;
    }
    .sidebar-nav > ul > li > a.active {
  font-weight: 500;
  background: #D7EBF0;
  
    }
  </style>
</head>
<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
            <li class="nav-devider" style="margin: 10px 0;"></li>

            <li id="mainuseraccount">
                    <a href="index.php?url=user"><i class="fas fa-user" style="color: #0092D1"></i>
                        <span class="hide-menu">&nbsp;&nbsp;Teacher <?php echo htmlspecialchars($firstname);?></span>
                    </a>
                </li>
                <li id="maindashboard">
                    <a href="index.php?url=dashboard"><i class="fas fa-home" style="color: #0092D1"></i>
                        <span class="hide-menu">&nbsp;&nbsp;Dashboard</span>
                    </a>
                </li>

                <li id="mainuseraccount">
                    <a href="index.php?url=announcement"><i><img src="assets/images/megaphone.png" alt="" style="width: 25px"></i>
                        <span class="hide-menu">&nbsp;&nbsp;Announcement Feed</span>
                    </a>
                </li>

                <li id="mainuseraccount">
                    <a href="index.php?url=events"><i><img src="assets/images/calendar.png" alt="" style="width: 25px"></i>
                        <span class="hide-menu">&nbsp;&nbsp;Calendar of Events</span>
                    </a>
                </li>
                <!-- <li id="mainuseraccount">
                    <a href="index.php?url=classroom"><i><img src="assets/images/class.png" alt="" style="width: 25px"></i>
                        <span class="hide-menu">&nbsp;&nbsp;Classroom</span>
                    </a>
                </li> -->
                <li id="mainuseraccount">
                    <a href="index.php?url=classroom" class="<?php echo ($_GET['url'] == 'classroom' || $_GET['url'] == 'eachclass' || $_GET['url'] == 'eachsubject') ? 'active' : ''; ?>">
                        <i><img src="assets/images/class.png" alt="" style="width: 25px"></i>
                        <span class="hide-menu">&nbsp;&nbsp;Classroom</span>
                    </a>
                </li>


                <li id="mainuseraccount">
                    <a href="index.php?url=schedule"><i><img src="assets/images/schedule.png" alt="" style="width: 25px"></i>
                        <span class="hide-menu">&nbsp;&nbsp;Schedule</span>
                    </a>
                </li>
                <li id="mainuseraccount">
                    <a class="dropdown-item" href="index.php?url=attendance"><i><img src="assets/images/attendance.png" alt="" style="width: 25px"></i>  
                    <span class="hide-menu">&nbsp;&nbsp;Attendance</span> </a>
                </li>
                



                <li class="nav-devider" style="margin: 50px 0;"></li>

                <!-- <li id="notifications">
                    <a href="#"><i><img src="assets/images/notification.png" alt="" style="width: 30px"></i>
                        <span class="hide-menu">&nbsp;&nbsp;Notifications</span>
                    </a>
                </li> -->
                
                <li class=" nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                        style="font-size: 2rem;"><img src="assets/images/gear.png" alt="" style="width: 30px"></i><span class="hide-menu">&nbsp;&nbsp;Settings</span>
                    </a>
                    <!-- <a class="nav-link text-muted waves-effect waves-dark" href="#" style="font-weight: 300; font-size: 16px; display:none;"><span id=""><b></b></span></a> -->
                    <div class="dropdown-menu dropdown-menu-right animated flipInY" style="width: 270px;">
                        <ul class="dropdown-user">
                            <li><a href="javascript:void(0)" onclick="opensettingmod();" class="settinghover"><i
                                        class="ti-settings" style="margin-right: 5px;"></i> Account Settings</a></li>
                            <li><a href="index.php?url=classarchive" class="settinghover"><i class="ti-archive" style="margin-right: 5px;"></i>
                            See Archive Classes</a></li>
                            <li><a href="javascript:void(0)" onclick="logoutuser();" class="settinghover"><i
                                        class="fas fa-lock"
                                        style="margin-left: 10px; margin-right: 10px;"></i>Logout</a></li>
                        </ul>
                    </div>
                </li>

            </ul>
        </nav>
    </div>
    
<div id="modalupdateprofileset" class="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" style="max-width: 400px;">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div style="display: flex;justify-content: space-between !important;">
                            <h4 class="headerfontfont2" style="color: #2c2b2e;font-weight: 500;">Account Settings</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                onclick="cleardata()"
                                style="padding: 1rem 1rem;margin: -1.6rem -1rem -1rem auto;">×</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="txtsetemail" style="margin-bottom: 0px;">Email</label>
                        <input type="text" class="form-control reqdistitem5" name="txtsetemail" id="txtsetemail"
                            style="height: 40px;">
                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="txtsetpassword" style="margin-bottom: 0px;">Password</label>
                        <div class="input-group">
                            <input type="Password" class="form-control reqdistitem5" id="txtsetpassword">
                            <div class="input-group-prepend" style="cursor: pointer;"
                                onclick="fncaddpassattribunHash();" id="inputaddusereye">
                                <span class="input-group-text"><i class="fas fa-eye-slash" id="addusereye"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="padding: 10px 15px;">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn waves-effect waves-light btn-secondary"
                            style="background-color: #4C644B!important; border: 1px solid #4C644B!important;"
                            onclick="updateuser2();">Update</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
$(function() {

})

function logoutuser() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to logout your account?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "logout.php";
        }
    });
}

function opensettingmod() {
    $("#modalupdateprofileset").modal('show');

    $.ajax({
        type: 'POST',
        url: 'loginclass.php',
        data: 'form=opensettingmod',
        success: function(data) {
            var arr = JSON.parse(data);
            $("#txtsetemail").val(arr[0]);
            $("#txtsetpassword").val(arr[1]);
        }
    });
} // displaying the change email and pass for admin---------------------------------------------------------------------

// design for confirming update on user---------------------------------------------------------------------
function reqField1(classN) {
    var isValid = 1;
    $('.' + classN).each(function() {
        if ($(this).val() == '') {
            $(this).css('border', '1px #a94442 solid');
            $(this).addClass('lala');
            isValid = 0;
        } else {
            $(this).css('border', '');
            $(this).removeClass('lala');
        }
    });

    return isValid;
} //for confirming update on user---------------------------------------------------------------------

function fncaddpassattribHash() { //for unseeing the password----------------------------------------------------------------
    $("#txtsetpassword").attr("type", "password");
    $("#inputaddusereye").attr("onclick", "fncaddpassattribunHash()");
    $("#addusereye").removeClass("fa-eye");
    $("#addusereye").addClass("fa-eye-slash");
} //for unseeing the password----------------------------------------------------------------

function fncaddpassattribunHash() { //for seeing the password----------------------------------------------------------------
    $("#txtsetpassword").attr("type", "text");
    $("#inputaddusereye").attr("onclick", "fncaddpassattribHash()");
    $("#addusereye").addClass("fa-eye");
    $("#addusereye").removeClass("fa-eye-slash");
} //for seeing the password----------------------------------------------------------------

//for confirming update on user---------------------------------------------------------------------
function updateuser2() {
    var textsetemail = $("#txtsetemail").val();
    var textsetpassword = $("#txtsetpassword").val();
    if (reqField1('reqdistitem5') == 1) {
        $(".preloader").show().css('background', 'rgba(255,255,255,0.5)');
        $.ajax({
            type: 'POST',
            url: 'loginclass.php',
            data: 'textsetemail=' + textsetemail + '&textsetpassword=' + textsetpassword + '&form=updateuser2',
            success: function(data) {
                setTimeout(function() {
                    $(".preloader").hide().css('background', '');
                    $("#modalupdateprofileset").modal('hide');
                    Swal.fire(
                        'Success!',
                        'Successfully Updated Account.',
                        'success'
                    )
                }, 1000);
                setTimeout(function() {
                    window.location.reload();
                }, 3000);
            }
        })
    } else {
        alert('Please review your entries. Ensure all required fields are filled out');
    }
} //for confirming update on user---------------------------------------------------------------------

</script>
</aside>
