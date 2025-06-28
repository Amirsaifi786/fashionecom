<?php
require'config.php';    

// if (isset($_REQUEST["import"])) 
// {
    
//     $fileName = $_FILES["image"]["tmp_name"];
//     $files = $_FILES["image"]["name"];
//      $ext = pathinfo($files, PATHINFO_EXTENSION);
//      date_default_timezone_set('Asia/Kolkata');
//     $currentTime = date( 'd-m-Y h:i:s A', time () );
 
//     if ($ext == 'csv' ) 
//     {
    
//         if ($_FILES["image"]["size"] > 0) 
//         {
            
//             $file = fopen($fileName, "r");
//             $count=0;
//             while (($column = fgetcsv($file, 10000, ",")) !== FALSE) 
//             {
                 
//             if ($count > 0)
//             {
//                 $Category = "";
//                 if (isset($column[0])) {
//                      $Category = $column[0];
//                 }
//                 $subcat = "";
//                 if (isset($column[1])) {
//                     $subcat = $column[1];
//                 }
//                 $subcat2 = "";
//                 if (isset($column[2])) {
//                     $subcat2 = $column[2];
//                 }
//                 $product = "";
//                 if (isset($column[3])) {
//                     $product = $column[3];
//                 }
//                 $mrp = "";
//                 if (isset($column[4])) {
//                     $mrp = $column[4];
//                 }
//                 $price = "";
//                 if (isset($column[5])) {
//                     $price = $column[5];
//                 }
//                 $size = "";
//                 if (isset($column[6])) {
//                     $size = $column[6];
//                 }
//                 $stock = "";
//                 if (isset($column[7])) {
//                     $stock = $column[7];
//                 } 
                
//                 $title = "";
//                 if (isset($column[8])) {
//                     $title = $column[8];
//                 }
//                 $desc = "";
//                 if (isset($column[9])) {
//                     $desc = $column[9];
//                 }
//                 $specific = "";
//                 if (isset($column[10])) {
//                     $specific = $column[10];
//                 }
//                 $image = "";
//                 if (isset($column[11])) {
//                     $image = $column[11];
//                 }
//                 $rating = "";
//                 if (isset($column[12])) {
//                     $rating = $column[12];
//                 }
                
        
                 
//                        $sqlInsert = "INSERT INTO `product`(`category`,`rating`, `subcategory`, `subcategory2`, `name`,  `mrp`, `image`, `sellprice`, `stock`, `size`, `title`, `description`, `specification`, `status`, `date`) VALUES ('$Category','$rating','$subcat','$subcat2', '$product', '$mrp', '$image', '$price', '$stock', '$size', '$title', '$desc', '$specific', '0', '$currentTime')";
                   
//                     $insertId = mysqli_query($con,$sqlInsert);
                    
                    
//                     if (! empty($insertId)) 
//                     {
//                         $msg= '<div class="alert alert-success" role="alert" style="width:40%">
//                           Success ! CSV Data Imported Into the database.
//                         </div>';
//                         echo "<script>setTimeout(function(){ window.location = 'products.php'; },2000);</script>";
//                     } 
//                     else 
//                     {
//                         $msg= '<div class="alert alert-danger" role="alert" style="width:40%">
//                           Alert !  Problem in Importing CSV Data.
//                         </div>';
//                     }
                
                
//             }
//            $count++; }
//         }
   
//     }
//     else
//     { 
//         ?>
//         <script>
//             alert("Invalid file type");
//         </script>
//         <?php
//     }
// }


$con = new mysqli($host, $user, $password, $db);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$inserted = 0;
$skipped = 0;
$rowCount = 0;
$uploadMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    if ($_FILES["csv_file"]["error"] == 0) {
        $filename = $_FILES["csv_file"]["tmp_name"];

        if (($handle = fopen($filename, "r")) !== false) {
            fgetcsv($handle); // skip header

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $rowCount++;
                if (count(array_filter($data)) == 0 || count($data) != 16) {
                    $skipped++;
                    continue;
                }

                list(
                    $category, $subcategory, $subcategory2, $rating, $name, $gender, $image,
                    $mrp, $sellprice, $stock, $size, $title, $description, $specification,
                    $status, $date
                ) = $data;

                if (empty($date)) {
                    $date = date('Y-m-d');
                }

                $sql = "INSERT INTO product (
                    category, subcategory, subcategory2, rating, name, gender, image,
                    mrp, sellprice, stock, size, title, description, specification,
                    status, date
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $con->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param(
                        "sssssssddissssds",
                        $category, $subcategory, $subcategory2, $rating, $name,
                        $gender, $image, $mrp, $sellprice, $stock, $size,
                        $title, $description, $specification, $status, $date
                    );
                    $stmt->execute();
                    $stmt->close();
                    $inserted++;
                } else {
                    $skipped++;
                }
            }

            fclose($handle);
            // Use session or query param to avoid resubmission
            header("Location: addbulk.php.php?success=1&inserted=$inserted&skipped=$skipped");
            exit();
        } else {
            $uploadMessage = "Failed to open the file.";
        }
    } else {
        $uploadMessage = "Error uploading file.";
    }
}
require'header.php';   
?>
   





 <main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="page-title">Add Product</h2>
              <!--<p class="text-muted">Provide valuable, actionable feedback to your users with HTML5 form validation</p>-->
              <div class="row">
        
                <div class="col-md-12">
                  <div class="card shadow mb-4">
                    <div class="card-header">
                      <strong class="card-title">Add Product in bulk</strong>
                        <a href="products.php" class="btn btn-primary float-right ml-3" type="button"><i class="fe fe-arrow-left "></i>Product List</a>

                    </div>
                    <div class="card-body">
                      <form class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                        <?php if(isset($msg)){ echo $msg; } ?>
                        <div class="form-row">
                          
                            <div class="col-md-12 mb-3">
                              <label for="customFile">Product CSV File</label>
                               <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="csv_file" accept=".csv"   required>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                               
                            </div>
                         
                        </div>
                       
                        <button class="btn btn-primary"name="submit" type="submit">Upload CSV</button>
                      </form>
                    </div> <!-- /.card-body -->
                  </div> <!-- /.card -->
                </div> <!-- /.col -->
              </div> <!-- end section -->
            </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
          </div> <!-- .row -->
        </div> <!-- .container-fluid -->
 
      </main>
      <!-------------------------------------------------CK EDITOR-------------------------------------------------->
      <script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
        
        <script>
                        CKEDITOR.replace( 'editor1' );
                </script>
        <script>
                        CKEDITOR.replace( 'description' );
                </script>
        <script>
                        CKEDITOR.replace( 'specification' );
                </script>
        
    <!---------------------------------------------------CK EDITOR--------------------------------------------------->

      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
        
        
        <script>
        $(document).ready(function(){
        
            $('#category').on("change",function () {
                var categoryId = $(this).find('option:selected').val();
                 $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    data: {categoryId:categoryId},
                    cache:false,
                    success: function (response) {
                         
                        $("#subcategory").html(response);
                    },
                });
            }); 
        
        });
        </script>
       
        <script>
        $(document).ready(function(){
        
            $('#subcategory').on("change",function () {
                var categoryId2 = $(this).find('option:selected').val();
                 $.ajax({
                    url: "ajax2.php",
                    type: "POST",
                    data: {categoryId2:categoryId2},
                    cache:false,
                    success: function (response) {
                         
                        $("#subcategory2").html(response);
                    },
                });
            }); 
        
        });
        </script>
            
            <script>
            $(document).ready(function () {
          
              // Denotes total number of rows
              var rowIdx = 0;
          
              // jQuery button click event to add a row
              $('#addBtn').on('click', function () {
          
                // Adding a row inside the tbody.
                $('#tbody').append(`<tr id="R${++rowIdx}">
                     <td><input type="text" class="form-control" id="validationCustom01"
                       name="size[]"  placeholder="Size"></td>
                     <td><input type="text" class="form-control" id="validationCustom01"
                                            name="stock[]" placeholder="Stock" required></td>
                 
                      <td class="text-center">
                        <button class="btn btn-danger remove"
                          type="button" style="float:left !important;">Remove</button>
                        </td>
                      </tr>`);
              });
          
              // jQuery button click event to remove a row.
              $('#tbody').on('click', '.remove', function () {
         
                // Getting all the rows next to the row
                // containing the clicked button
                var child = $(this).closest('tr').nextAll();
          
                // Iterating across all the rows 
                // obtained to change the index
                child.each(function () {
          
                  // Getting <tr> id.
                  var id = $(this).attr('id');
          
                  // Getting the <p> inside the .row-index class.
                  var idx = $(this).children('.row-index').children('p');
          
                  // Gets the row number from <tr> id.
                  var dig = parseInt(id.substring(1));
          
                  // Modifying row index.
                  idx.html(`Row ${dig - 1}`);
          
                  // Modifying row id.
                  $(this).attr('id', `R${dig - 1}`);
                });
          
                // Removing the current row.
                $(this).closest('tr').remove();
          
                // Decreasing total number of rows by 1.
                rowIdx--;
              });
            });
          </script>
      
      <?php require'footer.php';  ?>