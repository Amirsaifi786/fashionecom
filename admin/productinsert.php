<?php include('header.php');
require_once('../config/connection.php');
?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Product Insert</h4>
                  </div>
				  <form method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group">
                      <label>Product Name </label>
                      <input type="text" name="P_name" class="form-control">
                    </div>
					<div class="form-group">
					<label>Descirption</label>
                      <textarea name="P_des" class="form-control" ></textarea>
                    </div>
					<div class="form-group">
                      <label>Price </label>
                      <input type="text"  name="P_price"class="form-control">
                    </div>
					
					<div class="form-group">
                      <label>Quantity</label>
                      <input type="text" name="P_quantity" class="form-control">
                    </div>
					
					 <div class="section-title"> Image</div>
                    <div class="custom-file">
                      <input type="file" class="form-control" name="image[]" id="customFile" multiple>
						
                    </div>
					<div class="form-group">
                      <label>Size</label>
                      <input type="text" name="P_size" class="form-control">
                    </div>
					
					<div class="form-group">
                      <label>Colour</label>
                      <input type="text" name="P_colour" class="form-control">
                    </div>
               
					<div class="form-group">
                   
					
                      <label>Subcategory Name</label>
                      <select class="form-control" name="Sub_C_id">
                         <?php
                                $sql="select * from `sub-category`";
								$result = mysqli_query($conn,$sql);
								while($row=mysqli_fetch_array($result))
								{
							 ?>
								<option value="<?php echo $row['Sub_C_id']; echo $row['Sub_C_name']?>"><?php echo $row['Sub_C_name'];?>
								<?php
								}
								?>
                      </select>
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  

                    </div>
					
					
				<div class="form-group">
                   
					
                      <label>Brand Name</label>
                      <select class="form-control" name="brand_id">
                         <?php
                                $sql3="select * from `brand`";
								$result3 = mysqli_query($conn,$sql3);
								while($row3=mysqli_fetch_array($result3))
								{
							 ?>
								<option value="<?php echo $row3['Brand_id']; echo $row3['Brand_name']?>"><?php echo $row3['Brand_name'];?>
								<?php
								}
								?>
                      </select>
					  
                    </div>		    
                 
				 <div>
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
					</form>
 <?php

// if($_SERVER["REQUEST_METHOD"]=="POST")
// { 
// 		if(isset($_POST['P_name']) && isset($_POST['P_des']) && isset($_POST['P_price']) && isset($_FILES['image']) &&
// 			 isset($_POST['P_size']) && isset($_POST['P_colour']) && isset($_POST['P_quantity']) && isset($_POST['brand_id']) 
// 			 && isset($_POST['Sub_C_id']))
// 		{
// 			$P_name = $_POST['P_name'];
// 			$P_des = $_POST['P_des'];
// 			$P_price = $_POST['P_price'];
			
// 			$P_size = $_POST['P_size'];
// 			$P_colour = $_POST['P_colour'];
// 			$brand_id = $_POST['brand_id'];
// 			$Sub_C_id = $_POST['Sub_C_id'];
// 			$P_quantity = $_POST['P_quantity'];
// 			 $file_name = $_FILES['image']['name'];
// 			$file_tmp =$_FILES['image']['tmp_name'];
			
			
// 			if($P_name!='' && $P_des!='' && $P_price!='' && $file_name!='' && $P_size!='' && $P_colour!=''
// 			&& $brand_id!='' && $Sub_C_id!='' && $P_quantity!='')
// 			{
// 				$sql = "insert into product(P_name,P_des,P_price,P_quantity,P_image,P_Size,P_colour,Sub_C_id,Brand_id) 
// 				values('".$P_name."','".$P_des."','".$P_price."','".$P_quantity."','".$file_name."','".$P_size."','".$P_colour."','".$Sub_C_id."','".$brand_id."')";
				
// 				$result = mysqli_query($conn,$sql);
				
// 				if($result)
// 				{
// 					echo "<meta http-equiv='refresh' content='0;url=product.php'>";
// 				}
// 			}
// 		}
// 		else
// 		{
// 			echo "value not set";
// 		}
// }
// WARNING: This code is highly optimized for line count, sacrificing robust security, validation, and error handling.
// NOT recommended for production use without significant additions.

// Assuming $conn is your database connection, established elsewhere.

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
//     $data = $_POST; $file = $_FILES['image'];
//     if (isset($data['P_name'], $data['P_des'], $data['P_price'], $data['P_size'], $data['P_colour'], $data['P_quantity'], $data['brand_id'], $data['Sub_C_id']) && $file['error'] === UPLOAD_ERR_OK) {
//         $upload_dir = "Images/"; // Ensure this directory exists and is writable
//         $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
//         $unique_file_name = uniqid('product_', true) . '.' . $file_ext;
//         $destination_path = $upload_dir . $unique_file_name;

//         if (move_uploaded_file($file['tmp_name'], $destination_path)) {
//             $sql = "INSERT INTO product (P_name, P_des, P_price, P_quantity, P_image, P_Size, P_colour, Sub_C_id, Brand_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
//             $stmt = mysqli_prepare($conn, $sql);
//             if ($stmt) {
//                 // 'ssdisssii' assumes string, string, double, integer, string, string, string, integer, integer
//                 mysqli_stmt_bind_param($stmt, 'ssdisssii', $data['P_name'], $data['P_des'], $data['P_price'], $data['P_quantity'], $unique_file_name, $data['P_size'], $data['P_colour'], $data['Sub_C_id'], $data['brand_id']);
//                 if (mysqli_stmt_execute($stmt)) { echo "<meta http-equiv='refresh' content='0;url=product.php'>"; }
//                 else { echo "DB Error: " . mysqli_error($conn); unlink($destination_path); }
//                 mysqli_stmt_close($stmt);
//             } else { echo "DB Prep Error: " . mysqli_error($conn); unlink($destination_path); }
//         } else { echo "File Move Error."; }
//     } else { echo "Missing fields or upload error."; }
// } else { echo "Invalid request or no file uploaded."; }
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    $data = $_POST;
    $files = $_FILES['image'];
    
    if (isset($data['P_name'], $data['P_des'], $data['P_price'], $data['P_size'], $data['P_colour'], $data['P_quantity'], $data['brand_id'], $data['Sub_C_id'])) {
        $upload_dir = "Images/"; // Ensure this directory exists and is writable
        $image_names = []; // Array to hold names of uploaded images

        // Loop through each file
        foreach ($files['tmp_name'] as $key => $tmp_name) {
            if ($files['error'][$key] === UPLOAD_ERR_OK) {
                $file_ext = strtolower(pathinfo($files['name'][$key], PATHINFO_EXTENSION));
                $unique_file_name = uniqid('product_', true) . '.' . $file_ext;
                $destination_path = $upload_dir . $unique_file_name;

                if (move_uploaded_file($tmp_name, $destination_path)) {
                    $image_names[] = $unique_file_name; // Store the name of the uploaded image
                } else {
                    echo "File Move Error for " . $files['name'][$key];
                }
            } else {
                echo "Upload error for " . $files['name'][$key];
            }
        }

        // Convert the array of image names to a comma-separated string
        $image_names_string = implode(',', $image_names);

        // Prepare SQL statement
        $sql = "INSERT INTO product (P_name, P_des, P_price, P_quantity, P_image, P_Size, P_colour, Sub_C_id, Brand_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            // 'ssdisssii' assumes string, string, double, integer, string, string, string, integer, integer
            mysqli_stmt_bind_param($stmt, 'ssdisssii', $data['P_name'], $data['P_des'], $data['P_price'], $data['P_quantity'], $image_names_string, $data['P_size'], $data['P_colour'], $data['Sub_C_id'], $data['brand_id']);
            if (mysqli_stmt_execute($stmt)) {
                echo "<meta http-equiv='refresh' content='0;url=product.php'>";
            } else {
                echo "DB Error: " . mysqli_error($conn);
                // Optionally, delete uploaded files if DB insert fails
                foreach ($image_names as $image_name) {
                    unlink($upload_dir . $image_name);
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "DB Prep Error: " . mysqli_error($conn);
        }
    } else {
        echo "Missing fields.";
    }
} else {
    echo "Invalid request or no files uploaded.";
}


?>

                  </div>
                </div>
                
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
		
		
        
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- Mirrored from www.radixtouch.in/templates/admin/otika/source/light/basic-form.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 23 Nov 2019 14:26:53 GMT -->
</html>