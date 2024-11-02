<?php 
 if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: token, Content-Type');
        header('Access-Control-Max-Age: 1728000');
        header('Content-Length: 0');
        header('Content-Type: text/plain');
        die();
    }

    header('Access-Control-Allow-Origin: *');
session_start(); 

include "connect.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    $username = validate($_POST['username']);
    $password = $_POST['password'];
    if (empty($username)) {
        
    }else if(empty($password)){
    }else{
        $sql = "SELECT * FROM login WHERE  username='$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
			
        $row = mysqli_fetch_assoc($result);
		
			$password1 = $row['password'];
			$user = $row['username'];
			$type = $row['type'];
			
			if($password1 != $password) {
				echo '<script>alert("Password is incorrect");window.location="index.php";</script>';
			} else {
				$_SESSION['username'] = $user;
				if($type == 'admin') {
					
					date_default_timezone_set('Asia/Manila');
					$message = 'Admin account logged in';
					$date = date('F d, Y h:i A');
				
				echo '<script>window.location="admin/index.php"</script>';
				}
				if($type == 'store') {
					date_default_timezone_set('Asia/Manila');
					$message = 'Admin account logged in';
					$date = date('F d, Y h:i A');
				
				echo '<script>window.location="store/index.php"</script>';
				}
				if($type == 'user') {
					date_default_timezone_set('Asia/Manila');
					$message = 'Alumni account logged in';
					$date = date('F d, Y h:i A');
				
				echo '<script>window.location="./index.php"</script>';
				}
			}
		
            

        }else{
			echo '<script>alert("Login Failed. Invalid User ID or password");window.location="index.php";</script>';
        }
    }
}else{
    echo '<script>alert("Login Failed. Invalid User ID or password");window.location="index.php";</script>';
}
?>