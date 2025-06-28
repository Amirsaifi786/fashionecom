<?php
// Start session and enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include header and database connection
include('header.php');
require_once('../config/connection.php');

// Initialize variables
$id = isset($_GET['id']) ? $_GET['id'] : null;
$name = isset($_GET['name']) ? $_GET['name'] : null;
$bname = isset($_GET['bname']) ? $_GET['bname'] : null;

// Get product details
if ($id && $name && $bname) {
    $sql = "SELECT * FROM product WHERE P_id = '".mysqli_real_escape_string($conn, $id)."'";
    $result = mysqli_query($conn, $sql);
    $row1 = mysqli_fetch_array($result);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['P_name', 'P_des', 'P_price', 'P_size', 'P_colour', 'Brand_id', 'Sub_C_id', 'P_quantity'];
    $missing_fields = [];
    
    // Check for missing fields
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (empty($missing_fields)) {
        // Process form data
        $P_name = mysqli_real_escape_string($conn, $_POST['P_name']);
        $P_des = mysqli_real_escape_string($conn, $_POST['P_des']);
        $P_price = floatval($_POST['P_price']);
        $P_size = mysqli_real_escape_string($conn, $_POST['P_size']);
        $P_colour = mysqli_real_escape_string($conn, $_POST['P_colour']);
        $Brand_id = intval($_POST['Brand_id']);
        $Sub_C_id = intval($_POST['Sub_C_id']);
        $P_quantity = intval($_POST['P_quantity']);
        $current_image = isset($row1['P_image']) ? $row1['P_image'] : '';
        
        // Handle image upload
        $image_path = $current_image;
        if (!empty($_FILES['P_image']['name'])) {
            $target_dir = "Images/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            
            $image_name = time().'_'.basename($_FILES['P_image']['name']);
            $target_file = $target_dir.$image_name;
            
            if (move_uploaded_file($_FILES['P_image']['tmp_name'], $target_file)) {
                $image_path = $image_name;
            }
        }

        // Update query
        $sql = "UPDATE product SET 
                P_name = '$P_name',
                P_des = '$P_des',
                P_price = '$P_price',
                P_image = '$image_path',
                P_Size = '$P_size',
                P_colour = '$P_colour',
                P_quantity = '$P_quantity',
                Brand_id = '$Brand_id',
                Sub_C_id = '$Sub_C_id'
                WHERE P_id = '".$id."'";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success_message'] = "Product updated successfully!";
                echo "<meta http-equiv='refresh' content='3;url=product.php'>";
            exit();
        } else {
            $_SESSION['error_message'] = "Database error: ".mysqli_error($conn);
                echo "<meta http-equiv='refresh' content='1;url=productupdate.php?id=$id&name=$name&bname=$bname'>";

            exit();
        }
    } else {
        $_SESSION['missing_fields'] = $missing_fields;
                echo "<meta http-equiv='refresh' content='1;url=productupdate.php?id=$id&name=$name&bname=$bname'>";

        exit();
    }
}

// Clear messages if this is a fresh page load (not a redirect)
if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], 'productupdate.php') === false) {
    unset($_SESSION['success_message']);
    unset($_SESSION['error_message']);
    unset($_SESSION['missing_fields']);
}
?>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-message { margin-bottom: 20px; }
        .form-section { margin-top: 20px; }
        .current-image { max-width: 200px; max-height: 200px; margin-top: 10px; display: block; }
</style>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <!-- Success Message -->
                        <?php if(isset($_SESSION['success_message'])): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <?php echo $_SESSION['success_message']; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; ?>
                        
                        <!-- Error Message -->
                        <?php if(isset($_SESSION['error_message'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?php echo $_SESSION['error_message']; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>
                        
                        <!-- Missing Fields Message -->
                        <?php if(isset($_SESSION['missing_fields'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                Missing required fields: <?php echo implode(', ', $_SESSION['missing_fields']); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php unset($_SESSION['missing_fields']); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Update Product</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <!-- Product Name -->
                                    <div class="form-group">
                                        <label>Product Name *</label>
                                        <input type="text" class="form-control" name="P_name" value="<?php echo htmlspecialchars($row1['P_name'] ?? ''); ?>" >
                                    </div>
                                    
                                    <!-- Description -->
                                    <div class="form-group">
                                        <label>Description *</label>
                                        <textarea class="form-control" name="P_des" ><?php echo htmlspecialchars($row1['P_des'] ?? ''); ?></textarea>
                                    </div>
                                    
                                    <!-- Price -->
                                    <div class="form-group">
                                        <label>Price *</label>
                                        <input type="number" step="0.01" class="form-control" name="P_price" value="<?php echo htmlspecialchars($row1['P_price'] ?? ''); ?>" >
                                    </div>
                                    
                                    <!-- Quantity -->
                                    <div class="form-group">
                                        <label>Quantity *</label>
                                        <input type="number" class="form-control" name="P_quantity" value="<?php echo htmlspecialchars($row1['P_quantity'] ?? ''); ?>" >
                                    </div>
                                    
                                    <!-- Image Upload -->
                                    <div class="form-group">
                                        <label>Product Image</label>
                                        <input type="file" class="form-control-file" name="P_image">
                                        <?php if(isset($row1['P_image']) && !empty($row1['P_image'])): ?>
                                            <p>Current Image: <?php echo htmlspecialchars($row1['P_image']); ?></p>
                                            <img height="50px;"width="50px"src="Images/<?php echo htmlspecialchars($row1['P_image']); ?>" class="current-image">
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Size -->
                                    <div class="form-group">
                                        <label>Size *</label>
                                        <input type="text" class="form-control" name="P_size" value="<?php echo htmlspecialchars($row1['P_Size'] ?? ''); ?>" >
                                    </div>
                                    
                                    <!-- Colour -->
                                    <div class="form-group">
                                        <label>Colour *</label>
                                        <input type="text" class="form-control" name="P_colour" value="<?php echo htmlspecialchars($row1['P_colour'] ?? ''); ?>" >
                                    </div>
                                    
                                    <!-- Sub-Category -->
                                    <div class="form-group">
                                        <label>Sub-Category *</label>
                                        <select class="form-control" name="Sub_C_id" >
                                            <?php
                                            $sql2 = "SELECT * FROM `sub-category`";
                                            $result2 = mysqli_query($conn, $sql2);
                                            while($row2 = mysqli_fetch_array($result2)):
                                                $selected = ($row2['Sub_C_name'] == $name) ? 'selected' : '';
                                            ?>
                                                <option value="<?php echo $row2['Sub_C_id']; ?>" <?php echo $selected; ?>>
                                                    <?php echo htmlspecialchars($row2['Sub_C_name']); ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    
                                    <!-- Brand -->
                                    <div class="form-group">
                                        <label>Brand *</label>
                                        <select class="form-control" name="Brand_id" >
                                            <?php
                                            $sql3 = "SELECT * FROM brand";
                                            $result3 = mysqli_query($conn, $sql3);
                                            while($row3 = mysqli_fetch_array($result3)):
                                                $selected = ($row3['Brand_name'] == $bname) ? 'selected' : '';
                                            ?>
                                                <option value="<?php echo $row3['Brand_id']; ?>" <?php echo $selected; ?>>
                                                    <?php echo htmlspecialchars($row3['Brand_name']); ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Update Product</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>
