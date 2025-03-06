<?php
	include("../connect.php");
	session_start();

	switch ($_POST['form']) {

		case 'currenttime':
            echo date("Y-m-d H:i:s");
        break;  

        case 'dsplyFname':
           	$getname = mysqli_fetch_array(mysqli_query($connection, "SELECT firstname FROM users WHERE user_id = '" . $_SESSION['user_id'] . "'"));
           	echo $getname[0];
        break; 

        case 'dsplytotalseller':
        	$gettotalseller = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) FROM users WHERE usertype = 'SELLER'"));
			echo number_format($gettotalseller[0]);
		break;

		case 'dsplytotalcustomer':
        	$gettotalcustomer = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) FROM users WHERE usertype = 'CUSTOMER' AND status = 'APPROVED'"));
			echo number_format($gettotalcustomer[0]);
		break;

		case 'dsplytotalproduct':
        	$gettotalproduct = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) FROM products"));
			echo number_format($gettotalproduct[0]);
		break;

		case 'dsplytotalorders':
        	$gettotalorders = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) FROM orders"));
			echo number_format($gettotalorders[0]);
		break;

		case 'loadchartappointment':
        	$array = array();
        	$sql = "SELECT
					  SUM(CASE WHEN MONTH(date_added) = 1  THEN 1 ELSE 0 END) AS janx,
					  SUM(CASE WHEN MONTH(date_added) = 2  THEN 1 ELSE 0 END) AS febx,
					  SUM(CASE WHEN MONTH(date_added) = 3  THEN 1 ELSE 0 END) AS marx,
					  SUM(CASE WHEN MONTH(date_added) = 4  THEN 1 ELSE 0 END) AS aprx,
					  SUM(CASE WHEN MONTH(date_added) = 5  THEN 1 ELSE 0 END) AS mayx,
					  SUM(CASE WHEN MONTH(date_added) = 6  THEN 1 ELSE 0 END) AS junx,
					  SUM(CASE WHEN MONTH(date_added) = 7  THEN 1 ELSE 0 END) AS julx,
					  SUM(CASE WHEN MONTH(date_added) = 8  THEN 1 ELSE 0 END) AS augx,
					  SUM(CASE WHEN MONTH(date_added) = 9  THEN 1 ELSE 0 END) AS septx,  
					  SUM(CASE WHEN MONTH(date_added) = 10  THEN 1 ELSE 0 END) AS octx,
					  SUM(CASE WHEN MONTH(date_added) = 11  THEN 1 ELSE 0 END) AS novx,
					  SUM(CASE WHEN MONTH(date_added) = 12  THEN 1 ELSE 0 END) AS decx 
					FROM `orders` WHERE YEAR(date_added) = '".date('Y')."';";
			$result = mysqli_query($connection, $sql);
			$row = mysqli_fetch_array($result); 
		
			$monthly = array($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]);
			$x = 0;
			while($x < 12)
			{
				$get[$x] = $monthly[$x];
				$x ++;

			}
			echo json_encode($get);
        break;
        case 'loadchartappointment2':
        	$array = array();
        	$sql = "SELECT
					  SUM(CASE WHEN YEAR(date_added) = 2023  THEN 1 ELSE 0 END) AS y2023,
					  SUM(CASE WHEN YEAR(date_added) = 2024  THEN 1 ELSE 0 END) AS y2024,
					  SUM(CASE WHEN YEAR(date_added) = 2025  THEN 1 ELSE 0 END) AS y2025,
					  SUM(CASE WHEN YEAR(date_added) = 2026  THEN 1 ELSE 0 END) AS y2026,
					  SUM(CASE WHEN YEAR(date_added) = 2027  THEN 1 ELSE 0 END) AS y2027,
					  SUM(CASE WHEN YEAR(date_added) = 2028  THEN 1 ELSE 0 END) AS y2028,
					  SUM(CASE WHEN YEAR(date_added) = 2029  THEN 1 ELSE 0 END) AS y2029,
					  SUM(CASE WHEN YEAR(date_added) = 2030  THEN 1 ELSE 0 END) AS y2030,
					  SUM(CASE WHEN YEAR(date_added) = 2031  THEN 1 ELSE 0 END) AS y2031,  
					  SUM(CASE WHEN YEAR(date_added) = 2032 THEN 1 ELSE 0 END) AS y2032,
					  SUM(CASE WHEN YEAR(date_added) = 2033 THEN 1 ELSE 0 END) AS y2033,
					  SUM(CASE WHEN YEAR(date_added) = 2034 THEN 1 ELSE 0 END) AS y2034 
					FROM `orders`;";
			$result = mysqli_query($connection, $sql);
			$row = mysqli_fetch_array($result); 
		
			$monthly = array($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]);
			$x = 0;
			while($x < 12)
			{
				$get[$x] = $monthly[$x];
				$x ++;

			}
			echo json_encode($get);
        break;
        case 'loadchartappointment3':
			$startfirstweekofthismonth = date('Y-m-d', strtotime('first day of this month'));
			$endfirstweekofthismonth = date('Y-m-d', strtotime($startfirstweekofthismonth.' +6 days'));


			$startsecondweekofthismonth = date('Y-m-d', strtotime($startfirstweekofthismonth.' +7 days'));
			$endsecondweekofthismonth = date('Y-m-d', strtotime($startfirstweekofthismonth.' +13 days'));

			$startthirdweekofthismonth = date('Y-m-d', strtotime($startfirstweekofthismonth.' +14 days'));
			$endthirdweekofthismonth = date('Y-m-d', strtotime($startfirstweekofthismonth.' +20 days'));

			$startfourthweekofthismonth = date('Y-m-d', strtotime($startfirstweekofthismonth.' +21 days'));
			$lastdayofthismonth = date('Y-m-d', strtotime('last day of this month'));

        	$array = array();
     //    	$sql = "SELECT
					//   SUM(CASE WHEN date_added BETWEEN '$startfirstweekofthismonth' AND '$endfirstweekofthismonth'  THEN 1 ELSE 0 END) AS firstweek,
					//   SUM(CASE WHEN date_added BETWEEN '$startsecondweekofthismonth' AND '$endsecondweekofthismonth'  THEN 1 ELSE 0 END) AS secondweek,
					//   SUM(CASE WHEN date_added BETWEEN '$startthirdweekofthismonth' AND '$endthirdweekofthismonth'  THEN 1 ELSE 0 END) AS thirdweek,
					//   SUM(CASE WHEN date_added BETWEEN '$startfourthweekofthismonth' AND '$lastdayofthismonth'  THEN 1 ELSE 0 END) AS fourthweek,
					// FROM `orders`;";
        	$sql = "SELECT COUNT(date_added) AS date_added1 FROM `orders` WHERE date_added BETWEEN '$startfirstweekofthismonth' AND '$endfirstweekofthismonth';";
			$result = mysqli_query($connection, $sql);
			$row1 = mysqli_fetch_array($result); 

			$sql = "SELECT COUNT(date_added) AS date_added2 FROM `orders` WHERE date_added BETWEEN '$startsecondweekofthismonth' AND '$endsecondweekofthismonth';";
			$result = mysqli_query($connection, $sql);
			$row2 = mysqli_fetch_array($result); 

			$sql = "SELECT COUNT(date_added) AS date_added3 FROM `orders` WHERE date_added BETWEEN '$startthirdweekofthismonth' AND '$endthirdweekofthismonth';";
			$result = mysqli_query($connection, $sql);
			$row3 = mysqli_fetch_array($result); 

			$sql = "SELECT COUNT(date_added) AS date_added4 FROM `orders` WHERE date_added BETWEEN '$startfourthweekofthismonth' AND '$lastdayofthismonth';";
			$result = mysqli_query($connection, $sql);
			$row4 = mysqli_fetch_array($result); 
		
			$monthly = array($row1[0],$row2[0],$row3[0],$row4[0]);
			$x = 0;
			while($x < 12)
			{
				$get[$x] = $monthly[$x];
				$x ++;

			}
			echo json_encode($get);
        break;
	}
?>