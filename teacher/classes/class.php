<?php
include("../connect.php");
session_start();

switch ($_POST['form']) {

	case 'displayproductlist':
		if ($_POST['srchprod'] != '') {
			$searchuseracc = "WHERE (a.productname LIKE '%" . $_POST['srchprod'] . "%' OR CASE WHEN b.middlename = '' OR b.middlename IS NULL THEN CONCAT(b.lastname, ', ', b.firstname) ELSE CONCAT(b.lastname, ', ', b.firstname, ' ', LEFT(b.middlename, '1'), '.') END LIKE '%" . $_POST['srchprod'] . "%')";
		} else {
			$searchuseracc = "";
		}

		$counter = 0;
		$page = $_POST["page"];
		$limit = ($page - 1) * 10;
		$res = mysqli_query($connection, "SELECT a.product_id, a.productname, a.productdesc, a.price, a.quantity, a.unit, a.availat, a.availuntil, CASE WHEN b.middlename = '' OR b.middlename IS NULL THEN CONCAT(b.lastname, ', ', b.firstname) ELSE CONCAT(b.lastname, ', ', b.firstname, ' ', LEFT(b.middlename, '1'), '.') END, a.id FROM products AS a LEFT JOIN users_table AS b ON a.seller_id = b.user_id " . $searchuseracc . " ORDER BY a.product_id ASC LIMIT " . $limit . ",10");
		$numrows = mysqli_num_rows($res);
		if ($numrows == TRUE) {
			while ($row = mysqli_fetch_array($res)) {

				$counter++;

				if ($row[4] == "PENDING") {
					$status = "<span class='label label-light-danger'>Pending</span>";
				} else {
					$status = "<span class='label label-light-success'>Approved</span>";
				}


				$res2 = mysqli_query($connection, "SELECT image, imagename, id FROM products_image WHERE product_id = '" . $row[0] . "' ORDER BY id ASC LIMIT 1");
				while ($row2 = mysqli_fetch_array($res2)) {
					$img = "../" . $row2[0];
					$imagedisplay = "<img class='card-img-top img-responsive' src='../" . $row2[0] . "' style='width:50px;cursor:pointer;' onclick='viewvalidIDphoto(\"" . $img . "\");'>";
				}

				echo "<tr style='cursor:pointer; vertical-align: middle;'>
							<td style='white-space: nowrap; text-align: center;'>" . $counter . "</td>
	                        <td>" . $imagedisplay . "</td>
	                        <td style='white-space: nowrap;'>" . $row[1] . "</td>
	                        <td style='white-space: nowrap;'>" . $row[2] . "</td>
	                        <td style='white-space: nowrap;'>" . $row[3] . "</td>
	                        <td style='white-space: nowrap;'>" . $row[4] . "</td>
	                        <td style='white-space: nowrap;'>" . $row[5] . "</td>
							<td style='white-space: nowrap;'>" . $row[6] . "</td>
							<td style='white-space: nowrap;'>" . $row[7] . "</td>
							<td style='white-space: nowrap;'>" . $row[8] . "</td>
	                        <td style='white-space: nowrap; text-align: center;'>
	                        	<i class='fas fa-edit fa-lg text-success' style='cursor:pointer;color: #3f3f3f;' onclick='modaleditproduct(\"" . $row[0] . "\")' title='Edit Branch'></i>
	                        	<i class='fas fa-trash fa-lg text-danger' style='cursor:pointer;color: #3f3f3f;' onclick='deleteproduct(\"" . $row[0] . "\")' title='Edit Branch'></i>
	                        </td>
	                    </tr>";
			}
			echo "|" . $counter;
		} else {
			echo "<tr><td  colspan='12' style='text-align:center'>No Record Found . . .</td></tr>";
		}
		break;

	case "loadproductlistPagination":
		if ($_POST['srchprod'] != '') {
			$searchuseracc = "WHERE (a.productname LIKE '%" . $_POST['srchprod'] . "%' OR CASE WHEN b.middlename = '' OR b.middlename IS NULL THEN CONCAT(b.lastname, ', ', b.firstname) ELSE CONCAT(b.lastname, ', ', b.firstname, ' ', LEFT(b.middlename, '1'), '.') END LIKE '%" . $_POST['srchprod'] . "%')";
		} else {
			$searchuseracc = "";
		}

		$page = $_POST["page"];
		$rowCount = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(a.id) FROM products AS a LEFT JOIN users_table AS b ON a.seller_id = b.user_id " . $searchuseracc . ";"));
		$rowsperpage = 10;
		$range = 1;
		$totalpages = ceil($rowCount[0] / $rowsperpage);
		$prevpage;
		$nextpage;
		if ($page > 1) {
			echo "<li style='width:50px !important;' onclick='productlistPageFunc(1)'><< </li>";
			$prevpage = $page - 1;
			echo "<li style='width:70px !important;' onclick='productlistPageFunc(" . $prevpage . ")'>< </li>";
		}
		for ($x = ($page - $range); $x < (($page + $range) + 1); $x++) {
			if (($x > 0) && ($x <= $totalpages)) {
				if ($x == $page) {
					echo "<li id='pgproductlistPageFunc" . $x . "' class='pgnumproductlistPageFunc active' onclick='productlistPageFunc(" . $x . "," . $x . ")'>" . $x . "</li>";
					$ex = $x;
				} else {
					echo "<li id='pgproductlistPageFunc" . $x . "' class='pgnumproductlistPageFunc' onclick='productlistPageFunc(" . $x . "," . $x . ")'>" . $x . "</li>";
					$ex = $x;
				}
			}
		}
		if ($page < ($totalpages - $range)) {
			echo "<li>...</li>";
		}
		if ($page != $totalpages && $rowCount[0] != 0) {
			$nextpage = $page + 1;
			echo "<li style='width:50px !important;' onclick='productlistPageFunc(" . $nextpage . ", " . $nextpage . ")'> ></li>";
			echo "<li style='width:50px !important;' onclick='productlistPageFunc(" . $totalpages . ", " . $totalpages . ")'> >></li>";
		}
		echo "|" . $ex;
		break;

	case 'addnum':
		$num = $_POST['texthiddenwala'] + 1;
		echo $num;
		break;

	case 'fncdisplaycategories':
		$res = mysqli_query($connection, "SELECT category_id, categoryname FROM categories;");
?> <option value="">- Select Category -</option> <?php
													while ($row = mysqli_fetch_array($res)) {
													?> <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option> <?php
																															}
																															break;

																														case 'addproduct':
																															$generateID = generateID($connection, 'product_id', 'products', 'product');
																															$addproduct = mysqli_query($connection, "INSERT INTO products SET product_id = '" . $generateID . "', seller_id = '" . $_POST['textseller_id'] . "', productname = '" . $_POST['textaddprodname'] . "', productdesc = '" . $_POST['textaddproddesc'] . "', price = '" . $_POST['textaddprodprice'] . "', quantity = '" . $_POST['textaddprodqty'] . "', unit = '" . $_POST['textaddprodunit'] . "', availat = '" . $_POST['textaddprodavailat'] . "', availuntil = '" . $_POST['textaddprodavailuntil'] . "';");

																															foreach (explode('#', $_POST['textaddcategory']) as $key => $value) {
																																if ($value != '') {
																																	$listofcategories = mysqli_query($connection, "INSERT INTO products_category SET product_id = '" . $generateID . "', category_id = '" . $value . "';");
																																}
																															}

																															echo $generateID;
																															break;

																														case 'displaymdlappsellerlist':
																															$counter = 0;
																															$page = $_POST["page"];
																															$limit = ($page - 1) * 10;
																															$res = mysqli_query($connection, "SELECT a.user_id, CASE WHEN a.middlename = '' OR a.middlename IS NULL THEN CONCAT(a.lastname, ', ', a.firstname) ELSE CONCAT(a.lastname, ', ', a.firstname, ' ', LEFT(a.middlename, '1'), '.') END, b.contactnum, b.address, a.status, b.image, a.id, b.email FROM users_table AS a LEFT JOIN user_details AS b ON a.user_id = b.user_id WHERE a.usertype = 'SELLER' AND a.status = 'APPROVED' ORDER BY a.user_id ASC LIMIT " . $limit . ",10");
																															$numrows = mysqli_num_rows($res);
																															if ($numrows == TRUE) {
																																while ($row = mysqli_fetch_array($res)) {

																																	$counter++;

																																	if ($row[5] == "") {
																																		$img = "assets/images/noimage5.png";
																																	} else {
																																		$img = "../" . $row[5];
																																	}

																																	echo "<tr style='cursor:pointer;' onclick='getseller_id(\"" . $row[0] . "\", \"" . $row[1] . "\")'>
							<td style='white-space: nowrap; text-align: center;'>" . $counter . "</td>
	                        <td style='white-space: nowrap;'><img class='card-img-top img-responsive' src='" . $img . "' style='width:40px;cursor:pointer;' onclick='viewvalidIDphoto(\"" . $img . "\");'></td>
	                        <td style='white-space: nowrap;'>" . $row[1] . "</td>
	                        <td style='white-space: nowrap;'>" . $row[2] . "</td>
	                        <td style='white-space: nowrap;'>" . $row[7] . "</td>
	                    </tr>";
																																}
																															} else {
																																echo "<tr><td  colspan='12' style='text-align:center'>No Record Found . . .</td></tr>";
																															}
																															break;

																														case "loadmdlappselllistPagination":
																															$page = $_POST["page"];
																															$rowCount = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(a.id) FROM users_table AS a LEFT JOIN user_details AS b ON a.user_id = b.user_id WHERE a.usertype = 'SELLER' AND a.status = 'APPROVED';"));
																															$rowsperpage = 10;
																															$range = 1;
																															$totalpages = ceil($rowCount[0] / $rowsperpage);
																															$prevpage;
																															$nextpage;
																															if ($page > 1) {
																																echo "<li style='width:50px !important;' onclick='mdlappselllistPageFunc(1)'><< </li>";
																																$prevpage = $page - 1;
																																echo "<li style='width:70px !important;' onclick='mdlappselllistPageFunc(" . $prevpage . ")'>< </li>";
																															}
																															for ($x = ($page - $range); $x < (($page + $range) + 1); $x++) {
																																if (($x > 0) && ($x <= $totalpages)) {
																																	if ($x == $page) {
																																		echo "<li id='pgmdlappselllistPageFunc" . $x . "' class='pgnummdlappselllistPageFunc active' onclick='mdlappselllistPageFunc(" . $x . "," . $x . ")'>" . $x . "</li>";
																																		$ex = $x;
																																	} else {
																																		echo "<li id='pgmdlappselllistPageFunc" . $x . "' class='pgnummdlappselllistPageFunc' onclick='mdlappselllistPageFunc(" . $x . "," . $x . ")'>" . $x . "</li>";
																																		$ex = $x;
																																	}
																																}
																															}
																															if ($page < ($totalpages - $range)) {
																																echo "<li>...</li>";
																															}
																															if ($page != $totalpages && $rowCount[0] != 0) {
																																$nextpage = $page + 1;
																																echo "<li style='width:50px !important;' onclick='mdlappselllistPageFunc(" . $nextpage . ", " . $nextpage . ")'> ></li>";
																																echo "<li style='width:50px !important;' onclick='mdlappselllistPageFunc(" . $totalpages . ", " . $totalpages . ")'> >></li>";
																															}
																															echo "|" . $ex;
																															break;

																														case 'fncdsplycustinfo':
																															$custdet = mysqli_fetch_array(mysqli_query($connection, "SELECT CASE WHEN a.middlename = '' OR a.middlename IS NULL THEN CONCAT(a.lastname, ', ', a.firstname) ELSE CONCAT(a.lastname, ', ', a.firstname, ' ', LEFT(a.middlename, '1'), '.') END, b.contactnum, b.email, b.address, b.image, b.latitude, b.longitude FROM users_table AS a LEFT JOIN user_details AS b ON a.user_id = b.user_id WHERE a.id = '" . $_POST['ID'] . "';"));

																															if ($custdet[4] == "") {
																																$img = "assets/images/noimage5.png";
																															} else {
																																$img = "../" . $custdet[4];
																															}

																															echo $custdet[0] . "|" . $custdet[1] . "|" . $custdet[2] . "|" . $custdet[3] . "|" . $img . "|" . $custdet[5] . "|" . $custdet[6];
																															break;

																														case 'modaleditproduct':
																															$count = 0;
																															$res = mysqli_query($connection, "SELECT image, imagename, id FROM products_image WHERE product_id = '" . $_POST['product_id'] . "';");
																															$numrows = mysqli_num_rows($res);
																															echo $numrows . "|";
																															while ($row = mysqli_fetch_array($res)) {
																																$count++;
																																if ($count == 1) {
																																	echo "<div class='col-md-12 mb-2'>
               				<input type='file' class='dropify clearinfo reqresinfo dropdropdrop' id='txtproductImagefile1' name='txtproductImagefile1' accept='image/*' data-height='220' data-default-file='../" . $row[0] . "' value='" . $row[1] . "'>
               				</div><input type='hidden' class='form-control clearinfo' id='txtimageprodIDcount1' name='txtimageprodIDcount1' value='" . $row[2] . "'>|";
																																} else {
																																	echo "<div class='col-md-4 mb-2'>
               				<input type='file' class='dropify clearinfo reqresinfo dropdropdrop' id='txtproductImagefile" . $count . "' name='txtproductImagefile" . $count . "' accept='image/*' data-height='50' data-default-file='../" . $row[0] . "' value='" . $row[1] . "'>
               				</div><input type='hidden' class='form-control clearinfo' id='txtimageprodIDcount" . $count . "' name='txtimageprodIDcount" . $count . "' value='" . $row[2] . "'>";
																																}
																															}

																															$productdet = mysqli_fetch_array(mysqli_query($connection, "SELECT a.seller_id, CASE WHEN b.middlename = '' OR b.middlename IS NULL THEN CONCAT(b.lastname, ', ', b.firstname) ELSE CONCAT(b.lastname, ', ', b.firstname, ' ', LEFT(b.middlename, '1'), '.') END, a.productname, a.productdesc, a.quantity, a.unit, a.availat, a.availuntil, a.price FROM products AS a LEFT JOIN users_table AS b ON a.seller_id = b.user_id WHERE a.product_id = '" . $_POST['product_id'] . "';"));

																															echo "|" . $productdet[0] . "|" . $productdet[1] . "|" . $productdet[2] . "|" . $productdet[3] . "|" . $productdet[4] . "|" . $productdet[5] . "|" . $productdet[6] . "|" . $productdet[7] . "|" . number_format($productdet[8], "2", ".", ",") . "|";
																															$count2 = 0;
																															$res2 = mysqli_query($connection, "SELECT a.category_id, b.categoryname FROM products_category AS a LEFT JOIN categories AS b ON a.category_id = b.category_id WHERE a.product_id = '" . $_POST['product_id'] . "';");
																															$numrows2 = mysqli_num_rows($res2);
																															echo $numrows2 . "|";
																															while ($row2 = mysqli_fetch_array($res2)) {
																																if ($count2 == 0) {
																																	echo "<select class='form-control clearinfo mb-2 reqresinfo' name='txtaddcategory' id='txtaddcategory' style='font-size: .9rem;'>";
																																	$res3 = mysqli_query($connection, "SELECT category_id, categoryname FROM categories WHERE category_id != '" . $row2[0] . "';");
																																?> <option value="<?php echo $row2[0]; ?>"><?php echo $row2[1]; ?></option> <?php
																																																			while ($row3 = mysqli_fetch_array($res3)) {
																																																			?> <option value="<?php echo $row3[0]; ?>">
    <?php echo $row3[1]; ?></option> <?php
																																																			}
																																																			echo "</select>";
																																																			$count2++;
																																																		} else {
																																																			echo "<select class='form-control clearinfo mb-2 reqresinfo' name='txtaddcategory' id='txtaddcategory" . $count2 . "' style='font-size: .9rem;'>";
																																																			$res3 = mysqli_query($connection, "SELECT category_id, categoryname FROM categories WHERE category_id != '" . $row2[0] . "';");
															?> <option value="<?php echo $row2[0]; ?>">
    <?php echo $row2[1]; ?>
</option> <?php
																																																			while ($row3 = mysqli_fetch_array($res3)) {
							?> <option value="<?php echo $row3[0]; ?>"><?php echo $row3[1]; ?>
</option> <?php
																																																			}
																																																			echo "</select>";
																																																			$count2++;
																																																		}
																																																	}

																																																	echo "|" . $productdet[6] . "|" . $productdet[7] . "|" . $productdet[8] . "|" . $productdet[9] . "|" . $productdet[10] . "|" . $productdet[11] . "|" . $productdet[12] . "|" . $productdet[13] . "|" . $productdet[14] . "|" . $productdet[15];
																																																	break;

																																																case 'editproduct':
																																																	$editproduct = mysqli_query($connection, "UPDATE products SET seller_id = '" . $_POST['textseller_id'] . "', productname = '" . $_POST['textaddprodname'] . "', productdesc = '" . $_POST['textaddproddesc']  . "', price = '" . $_POST['textaddprodprice'] . "', quantity = '" . $_POST['textaddprodqty'] . "', availat = '" . $_POST['textaddprodavailat'] . "', availuntil = '" . $_POST['textaddprodavailuntil'] . "', unit = '" . $_POST['textaddprodunit'] . "' WHERE product_id = '" . $_POST['product_id'] . "';");

																																																	$deleteprod = mysqli_query($connection, "DELETE FROM products_category WHERE product_id = '" . $_POST['product_id'] . "'");
																																																	if ($deleteprod == TRUE) {
																																																		foreach (explode('#', $_POST['textaddcategory']) as $key => $value) {
																																																			if ($value != '') {
																																																				$sqlcat = "SELECT id FROM products_category WHERE category_id = '" . $value . "' AND product_id = '" . $_POST['product_id'] . "' ";
																																																				$rescat = mysqli_query($connection, $sqlcat);
																																																				$numcat = mysqli_num_rows($rescat);

																																																				if ($numcat == 0) {
																																																					$listofcategories = mysqli_query($connection, "INSERT INTO products_category SET product_id = '" . $_POST['product_id'] . "', category_id = '" . $value . "';");
																																																				} else {
																																																				}
																																																			}
																																																		}
																																																	}
																																																	break;

																																																case 'deleteproduct':
																																																	$deleteproduct1 = mysqli_query($connection, "DELETE FROM products WHERE product_id = '" . $_POST['product_id'] . "'");
																																																	$deleteproduct2 = mysqli_query($connection, "DELETE FROM products_category WHERE product_id = '" . $_POST['product_id'] . "'");
																																																	$deleteproduct3 = mysqli_query($connection, "DELETE FROM products_image WHERE product_id = '" . $_POST['product_id'] . "'");
																																																	break;

																																																case 'editproductsample':
																																																	$deleteprod = mysqli_query($connection, "DELETE FROM products_category WHERE product_id = '" . $_POST['product_id'] . "'");
																																																	if ($deleteprod == TRUE) {
																																																		foreach (explode('#', $_POST['textaddcategory']) as $key => $value) {
																																																			if ($value != '') {
																																																				$sqlcat = "SELECT id FROM products_category WHERE category_id = '" . $value . "' AND product_id = '" . $_POST['product_id'] . "' ";
																																																				$rescat = mysqli_query($connection, $sqlcat);
																																																				$numcat = mysqli_num_rows($rescat);

																																																				if ($numcat == 0) {
																																																					$listofcategories = mysqli_query($connection, "INSERT INTO products_category SET product_id = '" . $_POST['product_id'] . "', category_id = '" . $value . "';");
																																																				} else {
																																																				}
																																																			}
																																																		}
																																																	}
																																																	break;
																																															}
								?>