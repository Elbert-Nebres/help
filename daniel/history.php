<?php
include('./header.php');
if(isset($_SESSION['username']))  {
	
} else {
	echo '<script>alert("Please login to continue");window.history.back();</script>';
}
?>

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">History</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                 
  <table class="table table-light table-borderless table-hover text-center mb-0">
                      <thead class="thead-dark">
                        <tr>
                          <th>Customer Name</th>
                          <th>Address</th>
                          <th>Contact Number</th>
                          <th>Number of Items Purchased</th>
                          <th>Type of Transaction</th>
                          <th>Type of Payment</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
					<?php
					include('./connect.php');
						$username =$_SESSION['username'];
							$ss = mysqli_query($conn,"SELECT * FROM cart WHERE status = 'Approved'"); 
							$quantity = mysqli_num_rows($ss);
							while($rs = mysqli_fetch_array($ss)) {
								$item = $rs['product'];
								$username = $_SESSION['username'];
								$r1 = mysqli_query($conn,"SELECT * FROM user WHERE username = '$username'");
								while($row1 = mysqli_fetch_array($r1)) {
									$name =$row1['name'];
									$address =$row1['address'];
									$contact =$row1['contact'];
								}
						echo '<tr>';
                        echo '  <td>'.$name.'</td>';
                        echo '  <td>'.$address.'</td>';
                        echo '  <td>'.$contact.'</td>';
                        echo '  <td>'.$quantity.'</td>';
                        echo '  <td>'.$row['invoice'].'</td>';
						echo '  <td>'.$row['payment'].'</td>';
						echo '<td>'.$row['status'].'</td>';
                        echo '</tr>';
							}
						
					  
					?>
                    
						</table>
            </div>
           
            </div>
        </div>
    </div>
    <!-- Cart End -->
<?php
include('./footer.php');
?>