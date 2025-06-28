<?php include('header.php');?>
<style>
    .img-fluid {
        height: 71px !important;
        width: 86px !important;
    }

    .pro {
        text-align: center !important;
        align-content: center !important;
    }
</style>
<?php



if (isset($_POST['user_id']) && isset($_POST['product_id'])) {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];

    // Avoid duplicates
    $check = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id = '$user_id' AND product_id = '$product_id'");
    if (mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO wishlist (user_id, product_id) VALUES ('$user_id', '$product_id')";
        if (mysqli_query($conn, $sql)) {
            // header("Location: ".$_SERVER['HTTP_REFERER']); // Go back
            echo"<meta http-equiv='refresh' content='0;url=wishlist.php'>";
        } else {
            echo "Error: ".mysqli_error($conn);
        }
    } else {
                    echo"<meta http-equiv='refresh' content='0;url=wishlist.php'>";

    }
} 
?>

<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Wishlist</h4>
                    <div class="breadcrumb__links">
                        <a href="index.php">Home</a>/
                        <a href="shop.php">Shop</a>/
                        <span>Wishlist</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- wishlist main wrapper start -->
<div class="wishlist-main-wrapper section-padding">
    <div class="container custom-container">
        <!-- Wishlist Page Content Start -->
        <div class="row">
            <div class="col-lg-12">
                <!-- Wishlist Table Area -->
                <div class="cart-table table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="pro-thumbnail">Image</th>
                                <th class="pro-title">Product</th>
                                <th class="pro-price">Price</th>
                                <th class="pro-quantity">Stock Status</th>
                                <th class="pro-subtotal">Add to Cart</th>
                                <th class="pro-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    if (!isset($_SESSION['User_id'])) {
                    ?>
                        <script>
                            Swal.fire({
                                title: 'Login Required',
                                text: 'You must be logged in to view your wishlist.',
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonText: 'Login Now'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'login.php';
                                }
                            });
                        </script>
                    <?php
                        exit;
                    }
                    ?>

                <?php 

       
            $userid = $_SESSION['User_id'];
            $sql = "SELECT * FROM wishlist WHERE user_id = '$userid'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $product_id = $row['product_id'];

                    // Fetch product details
                    $product_sql = "SELECT * FROM product WHERE P_id = '$product_id'";
                    $product_result = mysqli_query($conn, $product_sql);

                    if (mysqli_num_rows($product_result) > 0) {
                        $product = mysqli_fetch_assoc($product_result);
            ?>
    <tr>
        <td class="pro-thumbnail pro">
            <div class="product__cart__item__pic">
                <img src="../admin/Images/<?php echo $product['P_image']; ?>" alt="" width="70">
            </div>
        </td>
        <td class="pro-title pro">
            <a href="#"><?php echo $product['P_name']; ?></a>
        </td>
        <td class="pro-price pro">
            <span>$<?php echo $product['P_price']; ?></span>
        </td>
        <td class="pro-quantity pro">
            <span class="text-success">In Stock</span>
        </td>
        <td class="pro-subtotal pro">

            <form  id="addToCartForm_<?php echo $product['P_id']; ?>" action="add_to_cart.php" method="POST" >
                <input type="hidden" name="user_id" value="<?php echo $userid; ?>">
                <input type="hidden" name="product_id" value="<?php echo $product['P_id']; ?>">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="price" value="<?php echo $product['P_price']; ?>">
                <button type="submit" class="btn btn-sm btn-success" title="Add to Cart" onclick="document.getElementById('addToCartForm_<?php echo $product['P_id']; ?>').submit();">
                    <i class="fa fa-shopping-cart" style="font-size: 20px;"></i>
                </button>
            </form>
        </td>
        <?php

                    if (isset($_POST['wishlist_id']) && isset($_SESSION['User_id']) && $_SESSION['User_id'] !== '' && isset($_POST['remove_wishlist'])) {
                        $wishlist_id = intval($_POST['wishlist_id']);
                        $user_id = $_SESSION['User_id'];

                        $sql = "DELETE FROM wishlist WHERE id = $wishlist_id AND user_id = $user_id";
                        if (mysqli_query($conn, $sql)) {
                             echo"<meta http-equiv='refresh' content='0;url=wishlist.php'>";
                        } else {
                            echo "error";
                        }
                    } else {
                        echo "invalid";
                    }
        ?>
        <td class="pro-remove pro">
            <form method="POST" >
                <input type="hidden" name="wishlist_id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="product_id" value="<?php echo $product['P_id']; ?>">
                <button type="submit" class="btn btn-sm btn-danger" title="Remove" name="remove_wishlist">
                    <i class="fa fa-close" style="font-size: 20px;"></i>
                </button>
            </form>
        </td>
    </tr>
<?php
        }
    }
} else {
    echo "<tr><td colspan='6'>No wishlist items found.</td></tr>";
}
?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Wishlist Page Content End -->
    </div>
</div>
<!-- wishlist main wrapper end -->
</main>



<?php include('footer.php');?>