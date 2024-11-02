<?php
include('./connect.php');
session_start();

// Initialize variables
$profile = 'default_profile.png'; // Default profile image
$name = 'Guest'; // Default name

if(isset($_SESSION['username']))  {
    $username = $_SESSION['username'];
    $r = mysqli_query($conn,"SELECT * FROM user WHERE username = '$username'");
    while($row = mysqli_fetch_array($r)) {
        $name = $row['name']; // This will override the default if set
        $address = $row['address'];
        $contact = $row['contact'];
        $email = $row['email'];
        $profile = $row['image']; // This will override the default if set
        if($profile == '') {
            $profile = 'profile.png'; // Fallback if image is empty
        } 
        $delivery = $row['delivery'];
    }
    $r1 = mysqli_query($conn,"SELECT * FROM login WHERE username = '$username'");
    while($row1 = mysqli_fetch_array($r1)) {
        $password = $row1['password'];
    }
    //check cart
    $c = mysqli_query($conn,"SELECT * FROM cart WHERE username = '$username' AND status = 'Cart'");
    $cart = mysqli_num_rows($c);
    $h = mysqli_query($conn,"SELECT * FROM cart WHERE username = '$username' AND status = 'Heart'");
    $heart = mysqli_num_rows($h);
} else {
    $cart = 0;
    $heart = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
		<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-duotone-solid.css">
		<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-thin.css">
		<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-solid.css">
		<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-regular.css">
		<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-light.css">
    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<style>

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 30%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
  from {top:-300px; opacity:0} 
  to {top:0; opacity:1}
}

@keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: #FFD333;
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}
</style>
<body style="background:#FFFBE6">
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex"  style="background:#347928 !important">
            <div class="col-lg-4">
                <a href="index.php" class="text-decoration-none">
				<div class="row">
					<div class="col-lg-2">
					<img src="./img/logo.PNG" style="width:100%;border:1px solid #d3d3d3">
					</div>
					<div class="col-lg-10">
					<span  class="h3 text-uppercase text-primary  px-2" style="color:#FCCD2A">Daniel and Marilyn's</span>
                    <span  class="h3 text-uppercase text-dark px-2 ml-n1" style="color:#FCCD2A !important"> General Merchandise</span>
					</div>
				</div>
					
                    
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="search.php" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products" name="search">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
			<?php
			if(isset($_SESSION['username'])) {
				?>
							<div class="profile-menu">
    <div class="profile-header">
        <img src="./uploads/<?php echo $profile ?>" alt="Profile Picture" class="profile-pic" style="border:1px solid #d3d3d3">
        <span class="profile-name"><?php echo $name ?></span>
        <span class="dropdown-icon">▼</span>
    </div>
    <div class="dropdown-content" style="z-index:999999999999999;margin-top:-1px">
        <a href="profile.php"><i class="icon profile-icon"></i> Profile</a>
        <a href="history.php"><i class="icon history-icon"></i> Transaction History</a>
        <a href="./logout.php" onclick="return confirm('Are you sure you want to logout?')"><i class="icon exit-icon"></i> logout</a>
    </div>
</div>
<?php
			}
?>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
<style>
/* Container for profile menu */
.profile-menu {
    position: relative;
    display: inline-block;
    font-family: Arial, sans-serif;
}

/* Profile header */
.profile-header {
    display: flex;
    align-items: center;
    cursor: pointer;
    background-color: #FCCD2A;
    color: white;
    padding: 10px;
    border-radius: 5px;
}

.profile-pic {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 10px;
}

.profile-name {
    font-size: 14px;
	color:#000;
    margin-right: 5px;
}

.dropdown-icon {
    font-size: 12px;
    color: #FFD700; /* gold color */
}

/* Dropdown content */
.dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: white;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    margin-top: 8px;
    min-width: 200px;
    z-index: 1;
}

.profile-menu:hover .dropdown-content {
    display: block;
}

.dropdown-content a {
    color: #333;
    padding: 10px;
    display: flex;
    align-items: center;
    text-decoration: none;
    border-top: 1px solid #eee;
}

.dropdown-content a:first-child {
    border-top: none;
}

.dropdown-content a:hover {
    background-color: #f9f9f9;
}

.icon {
    width: 20px;
    height: 20px;
    margin-right: 10px;
}

/* Icons styling (replace with actual icons if needed) */
.profile-icon::before { content: "👤"; }
.settings-icon::before { content: "⚙️"; color: #FCCD2A; }
.payments-icon::before { content: "💵"; }
.history-icon::before { content: "⏳"; }
.devices-icon::before { content: "📱"; }
.exit-icon::before { content: "🚪"; }

/* Arrow for the dropdown */
.dropdown-content::before {
    content: "";
    position: absolute;
    top: -10px;
    left: 20px;
    border-width: 10px;
    border-style: solid;
    border-color: transparent transparent white transparent;
}

</style>

    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30" style="background:#347928 !important">
	
        <div class="row px-xl-5" >
            <div class="col-lg-3 d-none d-lg-block" >
                <a class="btn d-flex align-items-center justify-content-between nav-dark w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-light m-0" style="color:#FFF !important"><i class="fa fa-bars mr-2"></i>Categories</h6>
                    <i class="fa fa-angle-down text-light"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;background:#000 !important">
                    <div class="navbar-nav w-100"  style="color:#FFF !important">
					<?php
					
					$result = $conn->query("SELECT * FROM category ");
					  while($row = $result->fetch_assoc()) {
						echo '<a href="view_shop.php?id='.$row['category'].'"  style="background:#FFF;color:#000 !important"class="nav-item nav-link">'.$row['category'].'</a>';  
					  }
					
					?>
                        
                    </div>
                </nav>
            </div>
            <div class="col-lg-9"  style="background:#347928 !important">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse" style="background:#347928 !important">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link">Home</a>
                            <a href="shop.php" class="nav-item nav-link">Shop</a>
                            
<!--                             <a href="about.php" class="nav-item nav-link">About Us</a> -->
						<?php
						if(isset($_SESSION['username'])) {
							echo '<a href="./logout.php" onclick="return confirm(\'Are you sure you want to logout?\')" class="nav-item nav-link">Logout</a>';	
						} else {
						echo '<a href="#" id="myBtn" class="nav-item nav-link">Login</a>
						<a href="#" id="myBtn1" class="nav-item nav-link">Register</a>';	
						}
						?>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="favorites.php" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;"><?php echo $heart ?></span>
                            </a>
                            <a href="cart.php" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;"><?php echo $cart ?></span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->