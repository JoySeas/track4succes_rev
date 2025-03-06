<?php
include("../connect.php");
session_start();

switch ($_POST['form']) {

	case 'displaycustomerlist':
		if ($_POST['srchprod'] != '') {
			$searchuseracc = "AND (a.user_id LIKE '%" . $_POST['srchprod'] . "%' OR CASE WHEN a.middlename = '' OR a.middlename IS NULL THEN CONCAT(a.lastname, ', ', a.firstname) ELSE CONCAT(a.lastname, ', ', a.firstname, ' ', LEFT(a.middlename, '1'), '.') END LIKE '%" . $_POST['srchprod'] . "%')";
		} else {
			$searchuseracc = "";
		}

		$counter = 0;
		$page = $_POST["page"];
		$limit = ($page - 1) * 10;
		$res = mysqli_query($connection, "SELECT a.user_id, CASE WHEN a.middlename = '' OR a.middlename IS NULL THEN CONCAT(a.lastname, ', ', a.firstname) ELSE CONCAT(a.lastname, ', ', a.firstname, ' ', LEFT(a.middlename, '1'), '.') END, b.contactnum, b.address, a.status, b.image, a.id FROM users AS a LEFT JOIN user_details AS b ON a.user_id = b.user_id WHERE a.usertype = 'CUSTOMER' AND a.status = 'APPROVED' " . $searchuseracc . " ORDER BY a.user_id ASC LIMIT " . $limit . ",10");
		$numrows = mysqli_num_rows($res);
		if ($numrows == TRUE) {
			while ($row = mysqli_fetch_array($res)) {

				$counter++;

				if ($row[5] == "") {
					$img = "assets/images/profile4.png";
				} else {
					$img = "../" . $row[5];
				}

				if ($row[4] == "PENDING") {
					$status = "<span class='label label-light-danger'>Pending</span>";
				} else {
					$status = "<span class='label label-light-success'>Approved</span>";
				}

				echo "<tr style='cursor:pointer;'>
							<td style='white-space: nowrap; text-align: center;'>" . $counter . "</td>
	                        <td style='white-space: nowrap;'><img class='card-img-top img-responsive' src='" . $img . "' style='width:50px;cursor:pointer;' onclick='viewvalidIDphoto(\"" . $img . "\");'></td>
	                        <td style='white-space: nowrap;'>" . $row[1] . "</td>
	                        <td style='white-space: nowrap;'>" . $row[2] . "</td>
	                        <td style='white-space: nowrap;'>" . $row[3] . "</td>
	                        <td style='white-space: nowrap;'>" . $status . "</td>
	                        <td style='white-space: nowrap; text-align: center;'>
	                        	<i class='fas fa-eye fa-lg text-info' style='cursor:pointer;' onclick='modalopencustprof(\"" . $row[6] . "\")' title='Edit Branch'></i>
	                        </td>
	                    </tr>";
			}
			echo "|" . $counter;
		} else {
			echo "<tr><td  colspan='12' style='text-align:center'>No Record Found . . .</td></tr>";
		}
		break;

	case "loadcustomerlistPagination":
		if ($_POST['srchprod'] != '') {
			$searchuseracc = "AND (a.user_id LIKE '%" . $_POST['srchprod'] . "%' OR CASE WHEN a.middlename = '' OR a.middlename IS NULL THEN CONCAT(a.lastname, ', ', a.firstname) ELSE CONCAT(a.lastname, ', ', a.firstname, ' ', LEFT(a.middlename, '1'), '.') END LIKE '%" . $_POST['srchprod'] . "%')";
		} else {
			$searchuseracc = "";
		}

		$page = $_POST["page"];
		$rowCount = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(a.id) FROM users AS a LEFT JOIN user_details AS b ON a.user_id = b.user_id WHERE a.usertype = 'CUSTOMER' AND a.status = 'APPROVED' " . $searchuseracc . ";"));
		$rowsperpage = 10;
		$range = 1;
		$totalpages = ceil($rowCount[0] / $rowsperpage);
		$prevpage;
		$nextpage;
		if ($page > 1) {
			echo "<li style='width:50px !important;' onclick='customerlistPageFunc(1)'><< </li>";
			$prevpage = $page - 1;
			echo "<li style='width:70px !important;' onclick='customerlistPageFunc(" . $prevpage . ")'>< </li>";
		}
		for ($x = ($page - $range); $x < (($page + $range) + 1); $x++) {
			if (($x > 0) && ($x <= $totalpages)) {
				if ($x == $page) {
					echo "<li id='pgcustomerlistPageFunc" . $x . "' class='pgnumcustomerlistPageFunc active' onclick='customerlistPageFunc(" . $x . "," . $x . ")'>" . $x . "</li>";
					$ex = $x;
				} else {
					echo "<li id='pgcustomerlistPageFunc" . $x . "' class='pgnumcustomerlistPageFunc' onclick='customerlistPageFunc(" . $x . "," . $x . ")'>" . $x . "</li>";
					$ex = $x;
				}
			}
		}
		if ($page < ($totalpages - $range)) {
			echo "<li>...</li>";
		}
		if ($page != $totalpages && $rowCount[0] != 0) {
			$nextpage = $page + 1;
			echo "<li style='width:50px !important;' onclick='customerlistPageFunc(" . $nextpage . ", " . $nextpage . ")'> ></li>";
			echo "<li style='width:50px !important;' onclick='customerlistPageFunc(" . $totalpages . ", " . $totalpages . ")'> >></li>";
		}
		echo "|" . $ex;
		break;

	case 'fncdsplycustinfo':
		$custdet = mysqli_fetch_array(mysqli_query($connection, "SELECT CASE WHEN a.middlename = '' OR a.middlename IS NULL THEN CONCAT(a.lastname, ', ', a.firstname) ELSE CONCAT(a.lastname, ', ', a.firstname, ' ', LEFT(a.middlename, '1'), '.') END, b.contactnum, b.email, b.address, b.image, b.latitude, b.longitude FROM users AS a LEFT JOIN user_details AS b ON a.user_id = b.user_id WHERE a.id = '" . $_POST['ID'] . "';"));

		if ($custdet[4] == "") {
			$img = "assets/images/profile4.png";
		} else {
			$img = "../" . $custdet[4];
		}

		echo $custdet[0] . "|" . $custdet[1] . "|" . $custdet[2] . "|" . $custdet[3] . "|" . $img . "|" . $custdet[5] . "|" . $custdet[6];
		break;
}
