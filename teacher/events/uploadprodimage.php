<?php	
	include "../connect.php";
	
	$Target_dir = "../../OmaangatImages/Products/"; 
	$pre = strtotime(date('Y-m-d H:i:s'))."_";

	$num = trim($_REQUEST['hiddenwala']);
	$count = 0;
	for ($x = 1; $x <= $num; $x++) {
		$count++;
		$prodname = basename($_FILES["txtproductImagefile".$count]["name"]); //PRODUCT IMAGE FILE NAME
		$Filename = trim($_REQUEST['txtproductimageID']) . $pre . $prodname; //WHOLE FILE NAME
		$Target_file = $Target_dir . $Filename; // WHOLE PATH

		$prodname2 = $_FILES["txtproductImagefile".$count]["tmp_name"];
		$imagefilename = "OmaangatImages/Products/". $Filename;

		$getID = trim($_REQUEST["txtimageprodIDcount".$count]);
		if($getID == 0){
			mkdir("../../OmaangatImages/Products/", 0777, true);
			move_uploaded_file($prodname2, $Target_file);
			$updateimage = mysqli_query($connection, "INSERT INTO products_image SET product_id = '" . trim($_REQUEST['txtproductimageID']) . "', image = '" . $imagefilename . "', imagename = '" . $Filename . "', date_added = '" . date("Y-m-d") . "';");
		} else{
			if($prodname != ""){
				mkdir("../../OmaangatImages/Products/", 0777, true);
				move_uploaded_file($prodname2, $Target_file);
				$updateimage = mysqli_query($connection, "UPDATE products_image SET image = '" . $imagefilename . "', imagename = '" . $Filename . "' WHERE id = '" . $getID . "';");
			} else{

			}
		}
	}

?>