<?php
include('./connect.php');
$name =$_POST['name'];
$address =$_POST['address'];
$contact =$_POST['contact'];
$email =$_POST['email'];
$username =$_POST['username'];
$password =$_POST['password'];
$type ='user';

$r = mysqli_query($conn,"SELECT * FROM login WHERE username = '$username'");
$s = mysqli_num_rows($r);
if($s>0) {
echo '<script>alert("The username you are trying to register is already exist");window.history.back();</script>';	
} else {
mysqli_query($conn,"INSERT INTO login (username, password, type)VALUES ('$username','$password','$type')");
mysqli_query($conn,"INSERT INTO user (name,address,contact,email,username)VALUES ('$name','$address','$contact','$email','$username')");
echo '<script>alert("Account has been registered");window.history.back();</script>';
}
?>