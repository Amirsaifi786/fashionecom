<?php include('header.php');?>
<?php
$message = '';

if (isset($_POST["submit"])) {
    if ($_FILES['csv_file']['name']) {
        $filename = $_FILES['csv_file']['tmp_name'];
        $file = fopen($filename, "r");

        // Skip the header
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $name = $conn->real_escape_string($row[0]);
            $description = $conn->real_escape_string($row[1]);
            $price = floatval($row[2]);
            $quantity = intval($row[3]);
            $image = $conn->real_escape_string($row[4]);
            $size = $conn->real_escape_string($row[5]);
            $color = $conn->real_escape_string($row[6]);
            $sub_category_id = intval($row[7]);
            $brand_id = intval($row[8]);


            $sql = "INSERT INTO product (P_name, P_des, P_price, P_quantity, P_image, P_Size, P_colour, Sub_C_id, Brand_id)
                    VALUES ('$name', '$description', $price, $quantity, '$image', '$size', '$color', $sub_category_id, $brand_id)";
            
            $conn->query($sql);
        }

        fclose($file);
        $message = "✅ Products imported successfully!";
    } else {
        $message = "❌ Please upload a CSV file.";
    }
}
?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Bulk Product Upload</h4>
                 
                  <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <?php if ($message) echo "<p>$message</p>"; ?>
                      <div class="form-group">
                       
                            <label>Select CSV File:</label><br>
                            <input type="file" name="csv_file" accept=".csv" required><br><br>
                            <button type="submit" name="submit">Upload & Import</button>
                       </div>
                    </form>
                    </div>
                </div>
            </div>
         </div>
         </div>
</section>
      </div>
    


		<?php include('footer.php');?>
