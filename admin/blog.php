<?php include('header.php');?>


      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>blog Table</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
					<div class="dt-buttons btn-group">        
					
             
</div>
					 <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                        <a href="bloginsert.php">Add record</a>
						<thead>
                          <tr>
                            <th>blog id</th>
                            <th>blog Name</th>
                            <th>blog Logo</th>
							<th>Delete</th>
							
                          </tr>
                        </thead>
						
                        <tbody>
                          <?php
						   require_once('../config/connection.php');
						  $sql="select * from blogs";
						 $result=mysqli_query($conn,$sql);
						  while ($row=mysqli_fetch_array($result))
						  {
							  $id=$row['blog_id'];
						  ?>
						  <tr>
							<td><?php echo $row['id']?></td> 
							<td><?php echo $row['title']?></td>
							<td><img src="../admin/Images/<?php echo $row['image']?>"height="50" width="50" style="border-radius:50%"></td>
							<td><a href="blogdelete.php?id=<?php echo $id?>"><img src="delete.png" height="30"><a></td>
							
							<?php
						  }
						  ?>

                        
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
		<?php include('footer.php');?>
  