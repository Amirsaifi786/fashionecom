<?php include('header.php');?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <form enctype="multipart/form-data" method="post">
				<div class="card">
                  <div class="card-header">
                    <h4>blog Insert</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                        <label>Blog Title</label>
                <input type="text" name="title" class="form-control">

             
                    </div>
                      <!-- Include CKEditor CDN -->
                        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

                        <!-- Textarea -->
                        <textarea name="content" id="content1"></textarea>

                        <!-- Script to initialize CKEditor -->
                        <script>
                            CKEDITOR.replace('content1');

                            // Set content in CKEditor after initialization
                            CKEDITOR.on('instanceReady', function () {
                                var editor = CKEDITOR.instances.content1;
                                var content = '<h2>Welcome to CKEditor</h2><p>This is dynamic content.</p>';
                                editor.setData(content);
                            });
                        </script>


                                        <div class="form-group">
                     <label>Author ID</label>
                <input type="hidden" name="author_id" value="1">
                    </div>
					
		            <div class="form-group">
                        <label for="colorpicker-rgb" class="col-sm-4 control-label">blog Logo</label>
                        <div class="col-sm-8">						
			              <span class="btn btn-green fileinput-button">
                              <i class="fa fa-plus"></i>
                              <span> Select Image</span>
                              <input type="file" name="image">
                           </span>
                   
                            <div class="card-footer text-right">
                                <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                <button class="btn btn-secondary" type="reset">Reset</button>
                            </div>
                        </div>                
                  </div>
                </div>
              </div>
            </form>
            </form>
	</div>
          </div>
        </section>


<?php


function slugify($text) {
    // create a slug: lowercased, spaces to hyphens, only alphanumerics
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['title']) && !empty($_POST['content']) && !empty($_FILES['image']['name'])) {
echo "<script>alert(" . json_encode($_POST) . ");</script>";
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $slug = slugify($title);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $author_id = $_POST['author_id'] ?? 1; // fallback to 1
        $status = 'published';

        // Upload image
        $file_name = time() . '_' . basename($_FILES['image']['name']);
        $file_tmp = $_FILES['image']['tmp_name'];
        $upload_path = "..admin/Images/" . $file_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            $query = "INSERT INTO blogs (title, slug, content, image, author_id, status)
                      VALUES ('$title', '$slug', '$content', '$file_name', '$author_id', '$status')";

            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>
                    alert('Blog inserted successfully!');
                    window.location.href='blog.php';
                </script>";
                exit;
            } else {
                echo "<script>alert('Database insert failed.');</script>";
            }
        } else {
            echo "<script>alert('Image upload failed.');</script>";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
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
