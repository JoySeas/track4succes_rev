<?php
include("connect.php");
session_start();

// Ensure $_SESSION['stud_id'] is set and possibly check other session variables if needed
if (empty($_SESSION['user_id']) || $_SESSION['usertype'] !== 'TEACHER') {
  echo "<script> window.location = 'login.php';</script>";
  exit(); // Add exit to stop further execution of the script
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php
  include('header.php');
  ?>
</head>

<body class="fix-header fix-sidebar card-no-border">

    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <div id="main-wrapper">
        <?php include('topbar.php'); ?>

        <?php
    include('leftsidebar.php');
    ?>

        <div class="page-wrapper">

            <div class="container-fluid containerfluidneed" style="padding: 20px 20px;">
                <?php
        if (!isset($_GET['url'])) {
          echo "<script>window.location='index.php?url=dashboard';</script>";
        } else {
          if ($_GET['url'] == "dashboard") {
            include "dashboard/index.php";
          }

          if ($_GET['url'] == "user") {
            include "user/index.php";
          }

          if ($_GET['url'] == "seller") {
            include "seller/index.php";
          }

          if ($_GET['url'] == "announcement") {
            include "announcement/index.php";
          }
          if ($_GET['url'] == "announcementarchive") {
            include "announcement/archive.php";
          }
          if ($_GET['url'] == "announcementdetails") {
            include "announcement/announcement_details.php";
          }

          if ($_GET['url'] == "events") {
            include "events/index.php";
          }

          if ($_GET['url'] == "teachers") {
            include "teachers/index.php";
          }
          if ($_GET['url'] == "students") {
            include "students/index.php";
          }
          if ($_GET['url'] == "parents") {
            include "parents/index.php";
          }
          if ($_GET['url'] == "classroom") {
            include "classroom/index.php";
          }
          if ($_GET['url'] == "classarchive") {
            include "classarchive/index.php";
          }
          if ($_GET['url'] == "classes") {
            include "classes/index.php";
          }
          if ($_GET['url'] == "schedule") {
            include "schedule/index.php";
          }
          if ($_GET['url'] == "performancereport") {
            include "performancereport/index.php";
          }
          if ($_GET['url'] == "attendance") {
            include "attendance/index.php";
          }
          if ($_GET['url'] == "eachclass") {
            include "classroom/eachclass.php";
          }
          if ($_GET['url'] == "eachsubject") {
            include "classroom/eachsubject.php";
          }
          if ($_GET['url'] == "eachclassarchive") {
            include "classarchive/eachclass.php";
          }
          if ($_GET['url'] == "eachsubjectarchive") {
            include "classarchive/eachsubject.php";
          }
        }
        ?>
            </div>

            <?php include('footer.php'); ?>
        </div>

    </div>

    <?php include('jscripts.php'); ?>
</body>

</html>