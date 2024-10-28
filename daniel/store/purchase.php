<?php

session_start();
   ini_set( 'display_errors', 1 );
   error_reporting( E_ALL );
   include('../connect.php');
$user = $_GET['customer'];
$email =$_GET['email'];
$date= date('F d, Y');
					$result1a = $conn->query("SELECT * FROM user WHERE username = '$user'");
					  while($row1a = $result1a->fetch_assoc()) {
						  $name =$row1a['name'];
						  $address =$row1a['address'];
						  $email =$row1a['email'];
						  $contact =$row1a['contact'];
					  }
   $from = "DanielandMarilyn@gmail.com@gmail.com";
   $to = $email;
   $subject = "Checking PHP mail";
   $message = "
<!DOCTYPE html>
<html>
<head>
  <title>Invoice Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
    }
    h1 {
      font-family: fantasy;
      font-size: 70px;
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid black;
    }
    th, td {
      border: 1px solid black;
      padding: 5px;
    }
    th {
      text-align: center;
    }
    table.yellowTable thead {
      background-color: #FFFF00;
    }
    table.yellowTable tbody tr:nth-child(even) {
      background-color: #FFFFFF;
    }
    table.yellowTable tbody tr:nth-child(odd) {
      background-color: #ecebeb;
    }
    img {
      float: right;
      width: 200px;
      height: 200px;
      transform: translateY(-90px);
        padding-right: 50px;
    }
	
	@media print {
    body {
      font-family: Arial, sans-serif;
      margin: 0;
    }
    h1 {
      font-family: fantasy;
      font-size: 70px;
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid black;
    }
    th, td {
      border: 1px solid black;
      padding: 5px;
    }
    th {
      text-align: center;
    }
    table.yellowTable thead {
      background-color: #FFFF00;
    }
    table.yellowTable tbody tr:nth-child(even) {
      background-color: #FFFFFF;
    }
    table.yellowTable tbody tr:nth-child(odd) {
      background-color: #ecebeb;
    }
    img {
      float: right;
      width: 200px;
      height: 200px;
      transform: translateY(-90px);
        padding-right: 50px;
    }
}
  </style>
</head>
<body>

  <h1>Daniel and Marilyn's General Merchandise</h1>
  <img src='../img/logo.png'  style='width:200px;height:200px'>
  <h2>Invoice</h2>
  <p><strong>Invoice number:</strong> ".$_GET['invoice']."</p>
  <p><strong>Date:</strong> ".$date."</p>
  <p><strong>Customer:</strong> ".$name."</p>
  <p><strong>Address:</strong> ".$address."</p>
  <table class='yellowTable'>
    <thead>
      <tr>
        <th>Item Description</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>";
	
					include('../connect.php');
					$total_price = 0;
					  $username =$_SESSION['username'];
					$result = $conn->query("SELECT * FROM cart WHERE username = '$username' AND status = 'Pending'");
					  while($row = $result->fetch_assoc()) {
						  $id =$row['id'];
						  $product =$row['product'];
						  $quantity = $row['quantity'];
					$result1 = $conn->query("SELECT * FROM product WHERE id = '$product'");
					  while($row1 = $result1->fetch_assoc()) {
						  $id_prod = $row1['id'];
						  $item = $row1['item'];
						  $category = $row1['category'];
						  $price = $row1['price'];
						  $compatibility = $row1['compatibility'];
						  $description = $row1['description'];
						  $image = $row1['image'];
					  }
						  $total = $quantity  * $price;
					$message.= "<tr>";
					$message.= "	<td>$item</td>";
					$message.= "	<td>$quantity</td>";
					$message.= "	<td>&#8369; ".number_format($price,2)."</td>";
					$message.= "	<td>&#8369; ".number_format($total,2)."</td>";
					$message.= "</tr>	  ";
					$total_price += $total;
					  }
					$tax = $total_price * 0.12;
					$t1 = $total_price - $tax;
						  
    $message.= "<tfoot>
      <tr>
        <th colspan='3'>Subtotal</th>
        <td>&#8369; ".number_format($total_price,2)."</td>
      </tr>
      <tr>
        <th colspan='3'>Tax</th>
        <td>&#8369; 12%</td>
      </tr>
      <tr>
        <th colspan='3'>Total</th>
        <td>&#8369; ".number_format($total_price,2)."</td>
      </tr>
    </tfoot>
  </table>
  <center>
    <p>If you have any questions about this invoice, please contact <a href='mailto:DanielandMarilyn@gmail.com@gmail.com'>DanielandMarilyn@gmail.com@gmail.com</a></p>
  </center>
  <center><b>Thank you for purchasing!</b></center>
</div>
 
</body>
</html>



   
   ";
   
  // The content-type header must be set when sending HTML email
 $headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: DanielandMarilyn@gmail.com@gmail.com\r\n"."X-Mailer: php";
   //if(mail($to,$subject,$message, $headers)) {
      //echo "Message was sent.";
   //} else {
      //echo "Message was not sent.";
   //}
?>

<?php
?>
<!DOCTYPE html>
<html>
<head>
  <title>Invoice Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
    }
    h1 {
      font-family: fantasy;
      font-size: 70px;
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid black;
    }
    th, td {
      border: 1px solid black;
      padding: 5px;
    }
    th {
      text-align: center;
    }
    table.yellowTable thead {
      background-color: #FFFF00;
    }
    table.yellowTable tbody tr:nth-child(even) {
      background-color: #FFFFFF;
    }
    table.yellowTable tbody tr:nth-child(odd) {
      background-color: #ecebeb;
    }
    img {
      float: right;
      width: 200px;
      height: 200px;
      transform: translateY(-90px);
        padding-right: 50px;
    }
	
	@media print {
    body {
      font-family: Arial, sans-serif;
      margin: 0;
    }
    h1 {
      font-family: fantasy;
      font-size: 70px;
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid black;
    }
    th, td {
      border: 1px solid black;
      padding: 5px;
    }
    th {
      text-align: center;
    }
    table.yellowTable thead {
      background-color: #FFFF00;
    }
    table.yellowTable tbody tr:nth-child(even) {
      background-color: #FFFFFF;
    }
    table.yellowTable tbody tr:nth-child(odd) {
      background-color: #ecebeb;
    }
    img {
      float: right;
      width: 200px;
      height: 200px;
      transform: translateY(-90px);
        padding-right: 50px;
    }
}
  </style>
</head>
<body>
<?php
$user = $_GET['customer'];
					$result1a = $conn->query("SELECT * FROM user WHERE username = '$user'");
					  while($row1a = $result1a->fetch_assoc()) {
						  $name =$row1a['name'];
						  $address =$row1a['address'];
						  $email =$row1a['email'];
						  $contact =$row1a['contact'];
					  }
?>
<div id="print">
  <h1>Daniel and Marilyn's General Merchandise</h1>
  <img src="../img/logo.png" alt="MGS" style="width:200px;height:200px">
  <h2>Invoice</h2>
  <p><strong>Invoice number:</strong> <?php echo $_GET['invoice'] ?></p>
  <p><strong>Date:</strong> <?php echo date('F d, Y'); ?></p>
  <p><strong>Customer:</strong> <?php echo $name ?></p>
  <p><strong>Address:</strong> <?php echo $address ?></p>
  <table class="yellowTable">
    <thead>
      <tr>
        <th>Item Description</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
	<?php
					include('../connect.php');
					$total_price = 0;
					  $username =$_SESSION['username'];
					$result = $conn->query("SELECT * FROM cart WHERE username = '$username' AND status = 'Pending'");
					  while($row = $result->fetch_assoc()) {
						  $id =$row['id'];
						  $product =$row['product'];
						  $quantity = $row['quantity'];
					$result1 = $conn->query("SELECT * FROM product WHERE id = '$product'");
					  while($row1 = $result1->fetch_assoc()) {
						  $id_prod = $row1['id'];
						  $item = $row1['item'];
						  $category = $row1['category'];
						  $price = $row1['price'];
						  $compatibility = $row1['compatibility'];
						  $description = $row1['description'];
						  $image = $row1['image'];
					  }
						  $total = $quantity  * $price;
					echo '<tr>';
					echo '	<td>'.$item.'</td>';
					echo '	<td>'.$quantity.'</td>';
					echo '	<td>&#8369; '.number_format($price,2).'</td>';
					echo '	<td>&#8369; '.number_format($total,2).'</td>';
					echo '</tr>	  ';
					$total_price += $total;
					  }
					$tax = $total_price * 0.12;
					$t1 = $total_price - $tax;
						  ?>
    <tfoot>
      <tr>
        <th colspan="3">Subtotal</th>
        <td>&#8369; <?php echo number_format($total_price,2) ?></td>
      </tr>
      <tr>
        <th colspan="3">Tax</th>
        <td>&#8369; 12%</td>
      </tr>
      <tr>
        <th colspan="3">Total</th>
        <td>&#8369; <?php echo number_format($total_price,2) ?></td>
      </tr>
    </tfoot>
  </table>
  <center>
    <p>If you have any questions about this invoice, please contact <a href="mailto:DanielandMarilyn@gmail.com@gmail.com">DanielandMarilyn@gmail.com@gmail.com</a></p>
  </center>
  <center><b>Thank you for purchasing!</b></center>
</div>
  <!-- Invoice Management Features (Front-end Only) -->
  <h2>Invoice Management</h2>
  <button onclick="PrintElem('print')">Print Invoice</button>
  <button onclick="window.location='pos.php'">Close Invoice</button>

  <div id="invoiceList" style="display: none;">
    <!-- Display a list of invoices here (for viewing) -->
  </div>

  <div id="invoiceManagement" style="display: none;">
    <!-- Add features for managing invoices here (e.g., create, edit, delete) -->
  </div>

  <script>
    function viewInvoices() {
      document.getElementById('invoiceList').style.display = 'block';
      document.getElementById('invoiceManagement').style.display = 'none';
    }

    function manageInvoices() {
      document.getElementById('invoiceList').style.display = 'none';
      document.getElementById('invoiceManagement').style.display = 'block';
    }
	function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=766,width=1278');
	mywindow.document.write('<link rel="stylesheet" type="text/css" href="./print_invoice.css">'); //loads the style

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
  </script>
</body>
</html>





<?php
include('../connect.php');
$username =$_SESSION['username'];

					$message = 'A customer purchased an item';
					$date = date('F d, Y h:i A');
					$username = $username;
				$save = $conn->query("INSERT INTO audit (action, timestamp,username)VALUES ('$message','$date','$username')");

$result = $conn->query("UPDATE cart SET status = 'Approved' WHERE username = '$username' AND status = 'Pending'");
?>
<script>
//alert("Items has been purchased");
//window.location='pos.php';
</script>