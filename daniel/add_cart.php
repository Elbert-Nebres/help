<?php
session_start();
include('./connect.php');
if(isset($_SESSION['username']))  {
	$id = $_GET['id'];
	$username = $_SESSION['username'];
	$status = 'Cart';
	if(isset($_GET['quantity'])) {
		$quantity = $_GET['quantity'];
	} else {
		$quantity = '1';
	}
	$date = date('Y-m-d');
	$size =$_GET['size'];
	$r = mysqli_query($conn,"SELECT  * FROM product WHERE id = '$id'");
	while($row  = mysqli_fetch_array($r)) {
		$quan = $row['quantity'];
	}
	//echo '<script>alert("'.$quan.'");</script>';
	//echo '<script>alert("'.$quantity.'");</script>';
	if($quantity < $quan) {
	mysqli_query($conn,"INSERT INTO cart (product, quantity, status,username)VALUES ('$id','$quantity','$status','$username')");
	echo '<script>alert("Item has been added to cart");window.history.back();</script>';

} else {
	echo '<script>alert("You can only purchase '.$quan.' piece/s of this item.");window.history.back();</script>';
}

}
 else {
	echo '<script>alert("Please login to continue");window.history.back();</script>';
}

?>