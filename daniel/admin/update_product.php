<?php
include('./header.php');
include('../connect.php');

// Verify user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Validate and sanitize ID parameter
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) : 0;
if (!$id) {
    header("Location: product.php");
    exit();
}

// Prepare and execute query using prepared statement
$stmt = $conn->prepare("SELECT p.*, s.store FROM product p 
                       LEFT JOIN store s ON p.username = s.username 
                       WHERE p.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$row = $result->fetch_assoc()) {
    header("Location: product.php");
    exit();
}

// Handle form submission
if (isset($_POST['submit'])) {
  // Sanitize and validate inputs
  // ...
  
  // Validate required fields
  if (empty($item) || empty($branch) || $price <= 0 || $quantity <= 0) {
      $error = "Please fill in all required fields with valid values.";
  } else {
      // Update product using prepared statement
      // ...
      
      if ($stmt->execute()) {
          if ($stmt->affected_rows > 0) {
              header("Location: product.php");
              exit();
          } else {
              $error = "No changes were made to the product.";
          }
           }     }
}
?>

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Update Product</h2>
                    <div class="clearfix"></div>
                </div>
                
                <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>

                <div class="x_content">
                    <form class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        
                        <div class="form-group row">
                            <label class="control-label col-md-3">Item Name *</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="item" 
                                       value="<?php echo htmlspecialchars($row['item']); ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Barcode</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="barcode" 
                                       value="<?php echo htmlspecialchars($row['barcode']); ?>">
                                <canvas id="barcodeCanvas"></canvas>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Branch *</label>
                            <div class="col-md-9">
                                <select name="branch" required class="form-control">
                                    <?php
                                    $stmt = $conn->prepare("SELECT username, store FROM store ORDER BY store");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($store = $result->fetch_assoc()):
                                        $selected = ($store['username'] === $row['username']) ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo htmlspecialchars($store['username']); ?>" <?php echo $selected; ?>>
                                            <?php echo htmlspecialchars($store['store']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-9">
                                <textarea name="description" id="description" class="form-control" rows="5"><?php echo htmlspecialchars($row['description']); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Price *</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="price" 
                                       value="<?php echo htmlspecialchars($row['price']); ?>" 
                                       required min="0.01" step="0.01">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Product Image</label>
                            <div class="col-md-9">
                                <input type="file" class="form-control" name="image" id="image" 
                                       accept="image/png, image/jpeg, image/gif">
                                <textarea id="img" name="img" style="display:none"><?php echo htmlspecialchars($row['image']); ?></textarea>
                                <?php if ($row['image']): ?>
                                    <div class="mt-2">
                                        <img src="<?php echo htmlspecialchars($row['image']); ?>" 
                                             alt="Current product image" style="max-width: 200px;">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Category *</label>
                            <div class="col-md-9">
                                <select class="form-control" name="category" required>
                                    <?php
                                    $categories = [
                                        'Processors', 'Motherboards', 'CPU Cooler', 'RAM', 
                                        'Hard drive', 'Solid States', 'Power Supply', 'Case', 
                                        'Case Fans', 'Monitors', 'Keyboards', 'Mouse', 'AVR', 
                                        'Webcam', 'Speakers', 'Cables', 'Routers', 
                                        'PC Bundles - for gaming', 'PC Bundles - for office', 'Others'
                                    ];
                                    foreach ($categories as $category):
                                        $selected = ($category === $row['category']) ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo htmlspecialchars($category); ?>" <?php echo $selected; ?>>
                                            <?php echo htmlspecialchars($category); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Compatibility *</label>
                            <div class="col-md-9">
                                <select name="compatibility" required class="form-control">
                                    <?php
                                    $compatibilities = ['Intel', 'AMD', 'None'];
                                    foreach ($compatibilities as $comp):
                                        $selected = ($comp === $row['compatibility']) ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo htmlspecialchars($comp); ?>" <?php echo $selected; ?>>
                                            <?php echo htmlspecialchars($comp); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Quantity *</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="quantity" 
                                       value="<?php echo htmlspecialchars($row['quantity']); ?>" 
                                       required min="0">
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group row">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" name="submit" class="btn btn-success">Update Product</button>
                                <a href="product.php" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="update_product.php?id=<?php echo $id; ?>" method="POST">
    <input type="text" name="item" value="<?php echo htmlspecialchars($product['item']); ?>" required>
    <textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
    <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
    <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required>
    <select name="category">
        <!-- Populate categories -->
    </select>
    <button type="submit">Update Product</button>
</form>

<script>
// Image handling
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onloadend = function() {
            document.getElementById('img').value = reader.result;
        };
        reader.readAsDataURL(file);
    }
});

// Barcode handling
document.addEventListener('DOMContentLoaded', function() {
    const barcodeInput = document.querySelector('input[name="barcode"]');
    const canvas = document.getElementById('barcodeCanvas');
    
    function updateBarcode() {
        try {
            JsBarcode(canvas, barcodeInput.value, {
                format: "CODE128",
                width: 2,
                height: 100,
                displayValue: true
            });
        } catch (e) {
            console.error('Invalid barcode value');
        }
    }
    
    if (barcodeInput.value) {
        updateBarcode();
    }
    
    barcodeInput.addEventListener('input', updateBarcode);
});

// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#description'))
    .catch(error => {
        console.error(error);
    });
</script>

<?php include('./footer.php'); ?>