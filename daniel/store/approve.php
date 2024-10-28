<?php
include('../connect.php');
session_start();
$user = $_GET['user'];
$invoice = $_GET['invoice'];
$user1 = $_GET['user1'];
$username =$_SESSION['username'];
$conn->query("UPDATE cart SET customer = '$user' WHERE username = '$user' AND status = 'Pending'");
$conn->query("UPDATE cart SET username = '$username' WHERE username = '$user' AND status = 'Pending'");
?>



<script>
alert("Orders has been approved");
window.location='pos1.php?invoice=<?php echo $invoice ?>&user1=<?php echo $user1 ?>';
</script>