<?php
include('./header.php');
?>


         <script
    type="text/javascript"
    src="https://code.jquery.com/jquery-2.1.3.js"
    
  ></script>

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row" style="display: inline-block;" >
          <div class="tile_count">
           &nbsp;
          </div>
        </div>
          <!-- /top tiles -->

          <br />


<style>
	.nicEdit-main {
		width:100% !important;
	}
	
.ck-editor__editable_inline {
    min-height: 200px;
}
</style>
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
              <div class="row">

                <div class="col-md-12 col-sm-12 " style="color:#000">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Purchase List</h2>
                      
                      <div class="clearfix"></div>
                    </div>
					
                    <div class="x_content">
                      
                      <div class="dashboard-widget-content" style="width:100%;overflow-x:scroll">
					  
<div class="row" style="margin-top:20px">
  <div class="col-sm-4">
    <div class="card" style="background:#C0EBA6">
      <div class="card-body">
        <h5  style="color:#000" class="card-title">Filter by Date</h5>
		  <form action="filter.php" method="POST">
		  Select Date:<br>
		  <input type="date" name="date" class="form-control" required>
		  <br>
		  <input type="submit" name="by_date" class="btn btn-primary">
		  </form>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card" style="background:#C0EBA6">
      <div class="card-body">
        <h5  style="color:#000" class="card-title">Filter by Month</h5>
		  <form action="filter.php" method="POST">
		  <table width="125%">
			<tr>
				<td width="50%">Start Month<input type="month" name="start_date" class="form-control" required></td>
				<td width="50%">End Month<input type="month" name="end_date" class="form-control" required></td>
			</tr>
		  </table>
		  
		  <br>
		  <input type="submit" name="by_month" class="btn btn-primary">
		  </form>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card" style="background:#C0EBA6">
      <div class="card-body">
        <h5 style="color:#000" class="card-title">Filter by Year</h5>
		  <form action="filter.php" method="POST">
		  Enter Year
		  <input type="number" name="year" class="form-control" required>
		  <br>
		  <input type="submit" name="by_year" class="btn btn-primary">
		  </form>
      </div>
    </div>
  </div>
</div>		  
 <br>
                         <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                      
                      <tbody>
                      <?php
$conn = mysqli_connect("localhost", "root", "", "daniel");

// First, let's check the table structure
$tableCheck = $conn->query("DESCRIBE cart");
echo "<!-- Table Structure: -->";
while($field = $tableCheck->fetch_assoc()) {
    echo "<!-- Field: " . $field['Field'] . " -->";
}

// Modified query to show all fields
$result1 = $conn->query("SELECT * FROM cart WHERE status = 'Approved' GROUP BY invoice ORDER BY timestamp DESC");

// Debug query
if (!$result1) {
    echo "Query Error: " . $conn->error;
}

?>
<table id="datatable" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Invoice Number</th>
            <th>Name</th>
            <th>Contact Number</th>
            <th>Address</th>
            <th>Item/Quantity</th>
            <th>Total Price</th>
            <th>Date Purchased</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        while ($row1 = $result1->fetch_assoc()) {
            // Debug row data
            echo "<!-- Row Data: " . print_r($row1, true) . " -->";
            
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row1['invoice']) . '</td>';
            
            // Add debug output for these fields
            echo "<!-- Name value: " . ($row1['name'] ?? 'null') . " -->";
            echo "<!-- Contact value: " . ($row1['contact'] ?? 'null') . " -->";
            echo "<!-- Address value: " . ($row1['address'] ?? 'null') . " -->";
            
            // Output fields with fallback
            echo '<td>' . htmlspecialchars($row1['name'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row1['contact'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row1['address'] ?? '') . '</td>';

            // Display items
            echo '<td><ul>';
            $invoice = $row1['invoice'];
            $result1a = $conn->query("SELECT * FROM cart WHERE invoice = '$invoice'");
            $t = 0;

            while ($row1a = $result1a->fetch_assoc()) {
                $prd = $row1a['product'];
                $product_result = $conn->query("SELECT * FROM product WHERE id = '$prd'");
                while ($product = $product_result->fetch_assoc()) {
                    $item = $product['item'];
                    $price = $product['price'];
                    $quantity = $row1a['quantity'];
                    $p = $quantity * $price;
                    echo '<li>' . htmlspecialchars($item) . ' - ' . $quantity . ' ' . 
                         htmlspecialchars($product['type_quantity'] ?? 'pcs') . '</li>';
                    $t += $p;
                }
            }
            echo '</ul></td>';
            echo '<td>₱' . number_format($t, 2) . '</td>';
            echo '<td>' . date('F d, Y', strtotime($row1['timestamp'])) . '</td>';
            echo '</tr>';

          
        }
        ?>
  
</table>

<?php
// Add additional debugging at the end
echo "<!-- Connection Info: -->";
echo "<!-- Connection Error: " . $conn->connect_error . " -->";
echo "<!-- Connection Errno: " . $conn->connect_errno . " -->";
?>
          
<form class="form-horizontal form-label-left" action="addproductexec.php" method="POST" enctype="multipart/form-data">
  <!-- Fields for item details -->
</form>
<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      responsive: true,
      dom: 'Bfrtip',
      buttons: [
        { extend: 'copy', className: 'btn btn-primary' },
        { extend: 'excel', className: 'btn btn-primary' },
        { extend: 'pdf', className: 'btn btn-primary' },
        { extend: 'print', className: 'btn btn-primary' }
      ],
      initComplete: function() {
        var btns = $('.dt-button');
        btns.addClass('btn btn-success sp');
      }
    });
  });
</script>

  
<hr>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
		<div id="con" style="border:0px solid #000;width:100%;height:700px" ></div>
		<table id="example1" class="customers display" cellspacing="0" width="100%" style="font-size:15px;display:none">
	<tr>
		<th>Date</th>
		<th>Number of Sales</th>
	</tr>
	<tr>
		<?php		
			  $jan = 0;
			  $feb = 0;
			  $mar = 0;
			  $apr = 0;
			  $may = 0;
			  $jun = 0;
			  $jul = 0;
			  $aug = 0;
			  $sep = 0;
			  $oct = 0;
			  $nov = 0;
			  $dec = 0;
		$result1 = $conn->query("SELECT * FROM cart WHERE status = 'Approved'");
		  while($row1 = $result1->fetch_assoc()) {
			  $prod = $row1['product'];
		$result1a = $conn->query("SELECT * FROM product WHERE id = '$prod'");
		  while($row1a = $result1a->fetch_assoc()) {
			  $date = date($row1['timestamp']);
			  $date = date('F',strtotime($date));
			  
			  $prod = $row1['product'];  
			  $tot = 0;
			  $quantity = $row1['quantity'];
			  $tot += $row1a['price'];
			  $tot += $tot * $quantity;
			  
			  if($date == 'January') {
				  $jan += $tot;
			  }
			  if($date == 'February') {
				  $feb += $tot;
			  }
			  if($date == 'March') {
				  $mar += $tot;
			  }
			  if($date == 'April') {
				  $apr += $tot;
			  }
			  if($date == 'May') {
				  $may += $tot;
			  }
			  if($date == 'June') {
				  $jun += $tot;
			  }
			  if($date == 'July') {
				  $jul += $tot;
			  }
			  if($date == 'August') {
				  $aug += $tot;
			  }
			  if($date == 'September') {
				  $sep += $tot;
			  }
			  if($date == 'October') {
				  $oct += $tot;
			  }
			  if($date == 'November') {
				  $nov += $tot;
			  }
			  if($date == 'December') {
				  $dec += $tot;
			  }
		  }
		  }
		  echo '<tr>';
		echo '<td>January</td>';
		echo '<td>'.$jan.'</td>';
		echo '</tr>';
		  echo '<tr>';
		echo '<td>February</td>';
		echo '<td>'.$feb.'</td>';
		echo '</tr>';
		  echo '<tr>';
		echo '<td>March</td>';
		echo '<td>'.$mar.'</td>';
		echo '</tr>';
		  echo '<tr>';
		echo '<td>April</td>';
		echo '<td>'.$apr.'</td>';
		echo '</tr>';
		  echo '<tr>';
		echo '<td>May</td>';
		echo '<td>'.$may.'</td>';
		echo '</tr>';
		  echo '<tr>';
		echo '<td>June</td>';
		echo '<td>'.$jun.'</td>';
		echo '</tr>';
		  echo '<tr>';
		echo '<td>July</td>';
		echo '<td>'.$jul.'</td>';
		echo '</tr>';
		  echo '<tr>';
		echo '<td>August</td>';
		echo '<td>'.$aug.'</td>';
		echo '</tr>';
		  echo '<tr>';
		echo '<td>September</td>';
		echo '<td>'.$sep.'</td>';
		echo '</tr>';
		  echo '<tr>';
		echo '<td>October</td>';
		echo '<td>'.$oct.'</td>';
		echo '</tr>';
		  echo '<tr>';
		echo '<td>November</td>';
		echo '<td>'.$nov.'</td>';
		echo '</tr>';
		  echo '<tr>';
		echo '<td>December</td>';
		echo '<td>'.$dec.'</td>';
		echo '</tr>';
		?>
	</tr>
</table>
 <script>
 
 Highcharts.chart('con', {
            data: {
                table: 'example1'
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'Sales Report'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Units'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' + this.point.y + ' ' + this.point.name.toLowerCase();
                }
            },
            navigation: {
                buttonOptions: {
                    enabled: false
                }
            }
        });
        </script>


                      </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
			 
              <div class="row">


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
	<h3>Fill up all fields to add an item</h2>
      <span class="close">&times;</span>
      
    </div>
    <div class="modal-body">
      
					  
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
				
                    <form class="form-horizontal form-label-left" action="addproductexec.php" method="POST">

                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Item Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" name="item" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
						<div style="width:100%;border:1px solid #000">
						<textarea name="description"  style="width:100%;height:200px !important" id="description"></textarea>
						</div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Price</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="number" class="form-control" name="price" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Product Image</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="file" class="form-control" name="image" id="image" required accept="image/png, image/gif, image/jpeg">
						  <textarea id="img" name="img" style="display:none !important"></textarea>
                        </div>
                      </div>
					  <script>
const fileInput = document.getElementById('image');
fileInput.addEventListener('change', (e) => {
// get a reference to the file
const file = e.target.files[0];

// encode the file using the FileReader API
const reader = new FileReader();
reader.onloadend = () => {

    // use a regex to remove data url part
    const base64String = reader.result;
        document.getElementById('img').value =reader.result; 
    console.log(base64String);
};
reader.readAsDataURL(file);});
				</script>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Catergory</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
						<select class="form-control" name="category">
							<option></option>
							<option>Processors</option>
<option>Motherboards</option>
<option>CPU Fans</option>
<option>RAM</option>
<option>Hard drives</option>
<option>Solid States</option>
<option>Power Supply</option>
<option>Case</option>
<option>Case Fans</option>
<option>Monitors</option>
<option>Keyboards</option>
<option>Mouse</option>
<option>AVR</option>
<option>Webcam</option>
<option>Speakers</option>
<option>Cables</option>
<option>Routers</option>
						</select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Compatibility</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <select name="compatibility" required class="form-control">
							<option></option>
							<option>Intel</option>
							<option>AMD</option>
							<option>None</option>
						  </select>
                        </div>
                      </div>
					  
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Quantity</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="number" class="form-control" name="quantity" required>
                        </div>
                      </div>
                      <div class="ln_solid"></div>

                      <div class="form-group row">
                        <div class="col-md-9 offset-md-3">
                          <button type="submit" class="btn btn-success" name="submit">Submit</button>
                          <button type="button" onclick="window.location='product.php'" class="btn btn-danger">Cancel</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
    </div>
  </div>

</div>

 

              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Daniel and Marilyn's General Merchandise - 2024
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div> 

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
   <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

	

    <script src="../build/js/custom.min.js"></script>	
    <!-- Custom Theme Scripts -->
	
  </body>
</html>
