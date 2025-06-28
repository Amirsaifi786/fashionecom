
<?php include('header.php');
// require_once('../config/conn.php');
	$id=$_SESSION['User_id'];
	
	
	$sql = "select * from user where User_id = '".$id."'";
	//echo $sql;
	//die;                   
	$result = mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);
	

?>

<!-- Bootstrap Container -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="list-group" id="account-tabs" role="tablist">
                <a class="list-group-item list-group-item-action active" id="tab-profile" data-bs-toggle="list" href="#profile" role="tab">👤 Profile</a>
                <a class="list-group-item list-group-item-action" id="tab-edit" data-bs-toggle="list" href="#edit" role="tab">✏️ Edit Profile</a>
                <a class="list-group-item list-group-item-action" id="tab-orders" data-bs-toggle="list" href="#orders" role="tab">🧾 My Orders</a>
                <a class="list-group-item list-group-item-action" id="tab-orders"  href="logout.php" role="tab">🧾 Logout</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content border rounded p-4 shadow-sm" id="account-tab-content">
                
                <!-- Profile -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <h3 class="mb-3">Welcome, <?php echo htmlspecialchars($row['User_name']); ?> 👋</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($row['Email']); ?></li>
                        <li class="list-group-item"><strong>Mobile:</strong> <?php echo htmlspecialchars($row['Contact_no']); ?></li>
                    </ul>
                </div>

                <!-- Edit Profile -->
                <div class="tab-pane fade" id="edit" role="tabpanel">
                    <h3 class="mb-3">Edit Profile</h3>
                    <form action="update_profile.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Name</label>
                            <input type="text" name="username" class="form-control" id="username" value="<?php echo htmlspecialchars($row['User_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($row['Email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="tel" name="mobile" class="form-control" id="mobile" value="<?php echo htmlspecialchars($row['Contact_no']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>

                <!-- Orders -->
                <div class="tab-pane fade" id="orders" role="tabpanel">
                    <h3 class="mb-3">My Orders</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        <?php
                            // Assuming $id = $_SESSION['User_id']; is already defined
                            $sql2 = "SELECT * FROM `order` WHERE User_id = '$id' ORDER BY Order_id DESC";
                            $result2 = mysqli_query($conn, $sql2);
                            ?>

                <tbody>
                <?php
                if (mysqli_num_rows($result2) > 0) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        $order_id = $row2['Order_id'];
                        $order_date = $row2['Order_date'];
                        $order_status = $row2['Order_status'];

                        // Calculate total from order_details
                        $total_sql = "SELECT SUM(Amount) as total_amount FROM order_details WHERE Order_id = '$order_id'";
                        $total_result = mysqli_query($conn, $total_sql);
                        $total_row = mysqli_fetch_assoc($total_result);
                        $total_amount = $total_row['total_amount'] ?? 0;
                ?>
                <tr>
                    <td>#<?php echo htmlspecialchars($order_id); ?></td>
                    <td><?php echo htmlspecialchars($order_date); ?></td>
                    <td>₹<?php echo number_format($total_amount, 2); ?></td>
                    <td>
                        <?php
                        // Map numeric status to label and class
                        $status_labels = [
                            0 => ['label' => 'Pending', 'class' => 'warning'],
                            1 => ['label' => 'Accepted', 'class' => 'info'],
                            2 => ['label' => 'Delivered', 'class' => 'success'],
                            3 => ['label' => 'Cancelled', 'class' => 'danger']
                        ];

                        $status = (int) $order_status; // Cast to int in case it's a string
                        $label = $status_labels[$status]['label'] ?? 'Unknown';
                        $class = $status_labels[$status]['class'] ?? 'secondary';
                        ?>
                        <span class="badge bg-<?php echo $class; ?>">
                            <?php echo $label; ?>
                        </span>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="4">No orders found.</td></tr>';
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

<!-- Load Bootstrap JS (required for tabs to work) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'footer.php'; ?>
