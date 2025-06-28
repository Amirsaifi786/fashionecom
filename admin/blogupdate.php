<?php include('header.php');
require_once('../config/connection.php');

if(isset($_GET['id']) )
{
$id = $_GET['id'];
$name = $_GET['name'];

$sql="select * from blog where blog_id = '".$id."'";
$result=mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
}
?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
			  <form method="post">
                <div class="card">
                  <div class="card-header">
                    <h4>blog Update</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label>blog Name</label>
                      <input type="text" class="form-control" name="blog_name" value="<?php echo $row['blog_name'] ?>">
                    </div>
					
					<div class="section-title"> Logo</div>
                    <div class="form-control">
                      <input type="file" class="form-control" id="customFile" name="blog_logo">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                   
                  <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
                  </div>
                </div>
                </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
	<?php	
		if ($_SERVER["REQUEST_METHOD"] == "POST")
{
		if (isset($_POST["blog_name"]) && isset($_POST["blog_logo"]))
		{
			$blog_name=$_POST["blog_name"];
			$blog_logo=$_POST["blog_logo"];
							
			if(($blog_name!='') && ($blog_logo!=''))
			{				
				$sql="update blog set blog_name='".$blog_name."',blog_logo='".$blog_logo."' where blog_id = '".$id."'";
		
				$result=mysqli_query($conn,$sql); 
				if($result)
				{
					
					 echo "<meta http-equiv='refresh' content='3;url=blog.php'>";

				}
			}
			else
			{
					echo "Value is null";
			}
		}
		else
		{
				echo "Value not set";
		}
}

?>
        
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