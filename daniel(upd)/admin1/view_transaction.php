<?php
include('./header.php');

?>

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="d-sm-flex align-items-baseline report-summary-header">
                          <h5 class="font-weight-semibold">Pending Orders</h5> 
                        </div>
                      </div>
                    </div>
  <table id="customers" class="table table-striped table-bordered" style="width:100%">
                      <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
					<?php
					$total = 0;
					$username = $_GET['id'];
					$trans_id =$_GET['trans_id'];
					$r = mysqli_query($conn,"SELECT * FROM cart WHERE username = '$username' AND trans_id = '$trans_id'");
					while($row = mysqli_fetch_array($r)) {
						$id =$row['item'];
						$quantity = $row['quantity'];
						$size = $row['size'];
						$r1 = mysqli_query($conn,"SELECT * FROM product WHERE id = '$id'");
						while($row1 = mysqli_fetch_array($r1)) {
							$item = $row1['item'];
							$image = $row1['image'];
							$price = number_format($row1['price'],2);
						}
						$t = $quantity * $price;
						?>
                        <tr>
                            <td class="align-middle"><?php echo $item ?></td>
                            <td class="align-middle"><?php echo $size ?></td>
                            <td class="align-middle">&#8369; <?php echo $price ?></td>
                            <td class="align-middle">
							<?php echo $quantity ?>
                                
                            </td>
                            <td class="align-middle">&#8369; <?php echo number_format($t,2) ?></td>
                           
                        </tr>
						<?php
						$total += $t;
					}
						?>
                      
                    </tbody>
					<tfoot>
						<td align="right" colspan="4">Total</td>
						<td>&#8369; <?php echo number_format($total,2) ?></td>
					</tfoot>
						</table>
						<br>
						<input type="button" value="Approve Orders" class="btn btn-primary" onclick="window.location='approve.php?username=<?php echo $_GET['id'] ?>&trans_id=<?php echo $trans_id ?>'">
						<input type="button" value="Decline Orders" class="btn btn-danger" onclick="window.location='decline.php?username=<?php echo $_GET['id'] ?>&trans_id=<?php echo $trans_id ?>'">
						<input type="button" value="Delete Orders" class="btn btn-danger" onclick="window.location='delete1.php?username=<?php echo $_GET['id'] ?>&trans_id=<?php echo $trans_id ?>'">
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
             	<script>
 $('#customers1').dataTable({
               
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Excel',
                        text:'Export to excel'
                        //Columns to export
                        //exportOptions: {
                       //     columns: [0, 1, 2, 3,4,5,6]
                       // }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'PDF',
                        text: 'Export to PDF'
                        //Columns to export
                        //exportOptions: {
                       //     columns: [0, 1, 2, 3, 4, 5, 6]
                      //  }
                    }
                ]
            });
  //]]></script>
          </div>
        

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>
        </div>
      
      </div>
      
    </div>
  
    <script src="./vendors/js/vendor.bundle.base.js"></script>
  
    <script src="./vendors/chart.js/Chart.min.js"></script>
    <script src="./vendors/moment/moment.min.js"></script>
    <script src="./vendors/daterangepicker/daterangepicker.js"></script>
    <script src="./vendors/chartist/chartist.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="./js/off-canvas.js"></script>
    <script src="./js/misc.js"></script>

    <script src="./js/dashboard.js"></script>
  </body>
</html>